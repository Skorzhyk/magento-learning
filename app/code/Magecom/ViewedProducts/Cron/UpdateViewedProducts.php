<?php

namespace Magecom\ViewedProducts\Cron;

/**
 * Update viewed products list
 *
 * @category Magecom
 * @package Magecom\ViewedProducts\Cron
 * @author  Magecom
 */
class UpdateViewedProducts
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
        \Magecom\ViewedProducts\Model\AllViewedProductsFactory $modelAllViewedProductsFactory
    )
    {
        $this->_modelAllViewedProductsFactory = $modelAllViewedProductsFactory;
        $this->_productLinkFactory = $productLinkFactory;
        $this->_productRepository = $productRepository;
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
                if (array_key_exists($productId, $updatedProducts) === false) {
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
                    if (array_key_exists($linkedProductId, $updatedProducts) === false) {
                        $linkedViewedProducts = $this->_productRepository->getById($linkedProductId)->getViewedProductsData();
                        $updatedProducts[$linkedProductId] = $linkedViewedProducts;
                    } else {
                        $linkedViewedProducts = $updatedProducts[$linkedProductId];
                    }

                    $linkedBlackList = $this->_productRepository->getById($linkedProductId)->getBlackProductIds();

                    // Update current new product in current old product viewed products list
                    if (array_search($productId, $linkedBlackList) === false) {
                        if (array_key_exists($productId, $linkedViewedProducts) === false) {
                            $linkedViewedProducts[$productId] = [
                                'frequency' => 0,
                                'range' => 0
                            ];
                        }

                        $frequency = $linkedViewedProducts[$productId]['frequency']++;
                        $linkedViewedProducts[$productId]['range'] = round(($linkedViewedProducts[$productId]['range'] * $frequency + ($key - $i)) / ($frequency + 1), 3);

                        $updatedProducts[$linkedProductId] = $linkedViewedProducts;
                    }

                    // Update current old product in current new product viewed products list
                    if (array_search($linkedProductId, $blackList) === false) {
                        if (array_key_exists($linkedProductId, $viewedProducts) === false) {
                            $viewedProducts[$linkedProductId] = [
                                'frequency' => 0,
                                'range' => 0
                            ];
                        }

                        $frequency = $viewedProducts[$linkedProductId]['frequency']++;
                        $viewedProducts[$linkedProductId]['range'] = round(($viewedProducts[$linkedProductId]['range'] * $frequency + ($key - $i)) / ($frequency + 1), 3);
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

        return $this;
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
     * @param $viewedProducts
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function updateProductLinks($product, $viewedProducts)
    {
        $allProductLinks = $product->getProductLinks();
        $productLinks = [];
        foreach ($allProductLinks as $link) {
            if ($link->getLinkType() != 'viewed') {
                $productLinks[] = $link;
            }
        }

        $viewedProducts = $this->rangeViewedProducts($viewedProducts);

        $i = 1;
        foreach ($viewedProducts as $viewedProduct) {
            $linkedProduct = $this->_productRepository->getById($viewedProduct['id']);
            $newLink = $this->_productLinkFactory->create()
                ->setSku($product->getSku())
                ->setLinkedProductSku($linkedProduct->getSku())
                ->setLinkType('viewed')
                ->setFrequency($viewedProduct['frequency'])
                ->setRange($viewedProduct['range'])
                ->setPosition($i);
            $productLinks[] = $newLink;
            $i++;
        }

        $product->setProductLinks($productLinks)->save();
    }

    public function rangeViewedProducts($viewedProducts)
    {
        $priority = [];
        foreach ($viewedProducts as $viewedId => $viewedData) {
            $viewedProducts[$viewedId]['id'] = $viewedId;
            $priority[$viewedId] = round($viewedData['frequency'] / $viewedData['range'], 3);
        }

        array_multisort($priority, SORT_DESC, $viewedProducts);

        return $viewedProducts;
    }
}