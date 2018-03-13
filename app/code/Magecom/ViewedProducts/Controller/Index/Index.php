<?php

namespace Magecom\ViewedProducts\Controller\Index;

class Index extends \Magento\Framework\App\Action\Action
{
    protected $_productLinkFactory;

    protected $_session;

    protected $_currentProduct;

    protected $_productRepository;

    protected $_modelAllViewedProductsFactory;

    public function __construct(
        \Magento\Catalog\Api\Data\ProductLinkInterfaceFactory $productLinkFactory,
        \Magento\Framework\Session\SessionManagerInterface $coreSession,
        \Magento\Catalog\Model\ProductRepository $productRepository,
        \Magecom\ViewedProducts\Model\AllViewedProductsFactory $modelAllViewedProductsFactory,
        \Magento\Framework\App\Action\Context $context
    )
    {
        $this->_modelAllViewedProductsFactory = $modelAllViewedProductsFactory;
        $this->_productLinkFactory = $productLinkFactory;
        $this->_productRepository = $productRepository;
        parent::__construct($context);
    }

    public function execute()
    {
        $recentSessions = $this->getRecentSessions();
        $updatedProducts = [];

        // Process all updated sessions
        foreach ($recentSessions as $session) {
            $products = $this->getViewedProductsBySession($session->getSessionId());

            // Process all new products of current session
            foreach ($products as $key => $product) {
                if ($product['processed'] == 1) {
                    continue;
                }

                $productId = $product['id'];

                // Get viewed products of current new product
                if (array_search($productId, $updatedProducts) !== false) {
                    $viewedProducts = $this->_productRepository->getById($productId)->getViewedProductsData();
                    $updatedProducts[$productId] = $viewedProducts;
                } else {
                    $viewedProducts = $updatedProducts[$productId];
                }

                $blackList = $this->_productRepository->getById($productId)->getBlackProductIds();

                // Update links between current new product and all old products of current session
                for ($i = 0; $i < $key; $i++) {
                    $linkedProductId = $products[$i]['id'];

                    // Get viewed products of current old product
                    if (array_search($linkedProductId, $updatedProducts) !== false) {
                        $linkedViewedProducts = $this->_productRepository->getById($linkedProductId)->getViewedProductsData();
                        $updatedProducts[$linkedProductId] = $linkedViewedProducts;
                    } else {
                        $linkedViewedProducts = $updatedProducts[$linkedProductId];
                    }

                    $linkedBlackList = $this->_productRepository->getById($linkedProductId)->getBlackProductIds();

                    if (array_search($productId, $linkedBlackList) !== false) {
                        if (array_search($productId, $linkedViewedProducts) === false) {
                            $linkedViewedProducts[] = [
                                $productId => [
                                    'frequency' => 0,
                                    'range' => 0
                                ]
                            ];
                        }

                        $frequency = $linkedViewedProducts[$productId]['frequency']++;
                        $linkedViewedProducts[$productId]['range'] = round(($linkedViewedProducts[$productId]['range'] * $frequency + ($key - $i)) / ($frequency + 1), 3);

                        $updatedProducts[$linkedProductId] = $linkedViewedProducts;
                    }

                    if (array_search($linkedProductId, $blackList) !== false) {
                        if (array_search($linkedProductId, $viewedProducts) === false) {
                            $linkedViewedProducts[] = [
                                $linkedProductId => [
                                    'frequency' => 0,
                                    'range' => 0
                                ]
                            ];
                        }

                        $frequency = $viewedProducts[$linkedProductId]['frequency']++;
                        $viewedProducts[$linkedProductId]['range'] = round(($linkedViewedProducts[$linkedProductId]['range'] * $frequency + ($key - $i)) / ($frequency + 1), 3);
                    }
                }

                $updatedProducts[$productId] = $viewedProducts;
            }
        }

        // Update Viewed product links of updated products
        foreach ($updatedProducts as $productId => $viewedProducts) {
            $originalProduct = $this->_productRepository->getById($productId);
            $this->updateProductLinks($originalProduct, $viewedProducts);
        }
    }

    public function getRecentSessions()
    {
        $modelAllViewedProducts = $this->_modelAllViewedProductsFactory->create();
        $recentlyViewedProductsCollection = $modelAllViewedProducts->getCollection();
        $recentSessions = $recentlyViewedProductsCollection
            ->addFieldToSelect('session_id')
            ->distinct(true)
            ->addFieldToFilter('processed', array('eq' => 0))
            ->load()
            ->getItems();

        return $recentSessions;
    }

    public function getViewedProductsBySession($sessionId)
    {
        $modelAllViewedProducts = $this->_modelAllViewedProductsFactory->create();
        $sessionViewedProductReports = $modelAllViewedProducts->getCollection()
            ->addFieldToFilter('session_id', array('eq' => $sessionId))
            ->load()
            ->getItems();

        $products = [];
        foreach ($sessionViewedProductReports as $sessionReport) {
            if (count($products) == 0 || $sessionReport->getProductId() != $products[count($products) - 1]['id']) {
                $products[] = [
                    'entity_id' => $sessionReport->getId(),
                    'id' => $sessionReport->getProductId(),
                    'processed' => $sessionReport->getProcessed()
                ];
            }

            $sessionReport->setData('processed', 1)->save();
        }

        return $products;
    }

    /**
     * Set new viewed products on particular product
     *
     * @param $product
     * @param $viewedProductsData
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function updateProductLinks($product, $viewedProductsData)
    {
        $allProductLinks = $product->getProductLinks();
        $productLinks = [];
        foreach ($allProductLinks as $link) {
            if ($link->getLinkType() != 'viewed') {
                $productLinks[] = $link;
            }
        }

        $i = 1;
        foreach ($viewedProductsData as $viewedId => $viewedData) {
            $linkedProduct = $this->_productRepository->getById($viewedId);
            $newLink = $this->_productLinkFactory->create()
                ->setSku($product->getSku())
                ->setLinkedProductSku($linkedProduct->getSku())
                ->setLinkType('viewed')
                ->setFrequency($viewedProductsData['frequency'])
                ->setRange($viewedProductsData['range'])
                ->setPosition($i);
            $productLinks[] = $newLink;
            $i++;
        }

        $product->setProductLinks($productLinks)->save();
    }
}