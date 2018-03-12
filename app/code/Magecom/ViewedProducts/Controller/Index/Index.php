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
        parent::__construct($context);
    }

    public function execute()
    {
        $recentlyViewedProducts = $this->getRecentlyViewedProducts();

    }

    public function getRecentlyViewedProducts()
    {
        $modelAllViewedProducts = $this->_modelAllViewedProductsFactory->create();
        $recentlyViewedProducts = $modelAllViewedProducts->getCollection()
            ->addFieldToFilter('processed', array('eq' => 0))
            ->load()
            ->getItems();

        $products = [];
        foreach ($recentlyViewedProducts as $product) {
            $productId = $report->getData('product_id');
            $products[] = $this->_productRepository->getById($productId);
        }

        return $products;
    }
//
//    /**
//     * Add new product to viewed products list on particular position
//     *
//     * @param $array
//     * @param $position
//     * @param $id
//     */
//    public function insertToViewed(&$array, $position, $id)
//    {
//        $currentPosition = array_search($id, $array);
//        if ($currentPosition) {
//            if ($currentPosition > $position) {
//                unset($array[$currentPosition]);
//            } else {
//                return;
//            }
//        }
//
//        $newStart = [];
//        for ($i = 0; $i < $position; $i++) {
//            $newStart[] = $array[$i];
//        }
//        $newStart[] = $id;
//        array_splice($array, 0, $position, $newStart);
//    }
//
//    /**
//     * Set new viewed products on particular product
//     *
//     * @param $product
//     * @param $viewedIds
//     * @throws \Magento\Framework\Exception\NoSuchEntityException
//     */
//    public function updateProductLinks($product, $viewedIds)
//    {
//        $allProductLinks = $product->getProductLinks();
//        $productLinks = [];
//        foreach ($allProductLinks as $link) {
//            if ($link->getLinkType() != 'viewed') {
//                $productLinks[] = $link;
//            }
//        }
//
//        $viewedIds = array_slice($viewedIds, 0, 10);
//
//        $i = 1;
//        foreach ($viewedIds as $id) {
//            $linkProduct = $this->_productRepository->getById($id);
//            $newLink = $this->_productLinkFactory->create()
//                ->setSku($product->getSku())
//                ->setLinkedProductSku($linkProduct->getSku())
//                ->setLinkType('viewed')
//                ->setPosition($i);
//            $productLinks[] = $newLink;
//            $i++;
//        }
//
//        $product->setProductLinks($productLinks)->save();
//    }
//
//    /**
//     * Remove the identical products from recently viewed products list by particular position
//     *
//     * @param $products
//     * @param $position
//     * @return array
//     */
//    public function filterRecentlyViewedProducts($products, $position)
//    {
//        $filteredProductIds = [];
//
//        for ($i = $position; $i >= 0; $i--) {
//            if (array_search($products[$i]->getId(), $filteredProductIds) === false) {
//                array_unshift($filteredProductIds, $products[$i]->getId());
//            }
//        }
//
//        for ($i = $position; $i < count($products); $i++) {
//            if (array_search($products[$i]->getId(), $filteredProductIds) === false) {
//                $filteredProductIds[] = $products[$i]->getId();
//            }
//        }
//
//        return $filteredProductIds;
//    }
}