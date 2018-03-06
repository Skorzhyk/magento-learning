<?php

namespace Magecom\ViewedProducts\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;

class UpdateViewedProducts implements ObserverInterface
{
    protected $_productLinkFactory;

    protected $_session;

    protected $_modelEventFactory;

    protected $_currentProduct;

    protected $_productRepository;

    public function __construct(
        \Magento\Catalog\Api\Data\ProductLinkInterfaceFactory $productLinkFactory,
        \Magento\Framework\Session\SessionManagerInterface $coreSession,
        \Magento\Reports\Model\EventFactory $modelEventFactory,
        \Magento\Catalog\Model\ProductRepository $productRepository
    )
    {
        $this->_productLinkFactory = $productLinkFactory;
        $this->_session = $coreSession;
        $this->_modelEventFactory = $modelEventFactory;
        $this->_productRepository = $productRepository;
    }

    public function execute(Observer $observer)
    {
        $this->_currentProduct = $observer->getData('product');
        $this->_session->start();

        $recentlyViewedProducts = $this->getRecentlyViewedProducts();
        $viewedIds = $this->_currentProduct->getViewedProductIds();

        $i = 0;
        foreach ($recentlyViewedProducts as $product) {
            if ($product->getId() == $this->_currentProduct->getId()) {
                $i++;
                continue;
            }
            $recentlyViewedProductIds = $this->filterRecentlyViewedProducts($recentlyViewedProducts, $i);
            $length = count($recentlyViewedProductIds);
            $position = array_search($product->getId(), $recentlyViewedProductIds);

            $this->insertToViewed($viewedIds, 0, $product->getId());

            $currentViewedIds = $product->getViewedProductIds();
            $positionInCurrentViewed = $length > 2 * $position ? $length - 1 : 2 * ($length - $position - 1);

            $this->insertToViewed($currentViewedIds, $positionInCurrentViewed, $this->_currentProduct->getId());
            $this->updateProductLinks($product, $currentViewedIds);

            $i++;
        }

        $this->updateProductLinks($this->_currentProduct, $viewedIds);
    }

    public function getRecentlyViewedProducts()
    {
        $visitorId = $this->_session->getVisitorData()['visitor_id'];
        $sessionStartTime = $this->_session->getSessionStartTime();

        $modelEvent = $this->_modelEventFactory->create();
        $reports = $modelEvent->getCollection()
            ->addFieldToFilter('logged_at', array('gteq' => $sessionStartTime))
            ->addFieldToFilter('subject_id', array('eq' => $visitorId))
            ->load()
            ->getItems();

        $products = [];
        foreach ($reports as $report) {
            $productId = $report->getData('object_id');
            $products[] = $this->_productRepository->getById($productId);
        }

        $prevId = false;
        foreach ($products as $product) {
            if ($prevId && $product->getId() == $prevId) {
                unset($product);
            } else {
                $prevId = $product->getId();
            }
        }

        return $products;
    }

    public function insertToViewed(&$array, $position, $id)
    {
        $currentPosition = array_search($id, $array);
        if ($currentPosition) {
            if ($currentPosition > $position) {
                unset($array[$currentPosition]);
            } else {
                return;
            }
        }

        $newStart = [];
        for ($i = 0; $i < $position; $i++) {
            $newStart[] = $array[$i];
        }
        $newStart[] = $id;
        array_splice($array, 0, $position, $newStart);
    }

    public function updateProductLinks($product, $viewedIds)
    {
        $allProductLinks = $product->getProductLinks();
        $productLinks = [];
        foreach ($allProductLinks as $link) {
            if ($link->getLinkType() != 'viewed') {
                $productLinks[] = $link;
            }
        }

        $viewedIds = array_slice($viewedIds, 0, 10);

        $i = 1;
        foreach ($viewedIds as $id) {
            $linkProduct = $this->_productRepository->getById($id);
            $newLink = $this->_productLinkFactory->create()
                ->setSku($product->getSku())
                ->setLinkedProductSku($linkProduct->getSku())
                ->setLinkType('viewed')
                ->setPosition($i);
            $productLinks[] = $newLink;
            $i++;
        }

        $product->setProductLinks($productLinks)->save();
    }

    public function filterRecentlyViewedProducts($products, $position)
    {
        $filteredProductIds = [];

        for ($i = $position; $i >= 0; $i--) {
            if (array_search($products[$i]->getId(), $filteredProductIds) === false) {
                array_unshift($filteredProductIds, $products[$i]->getId());
            }
        }

        for ($i = $position; $i < count($products); $i++) {
            if (array_search($products[$i]->getId(), $filteredProductIds) === false) {
                $filteredProductIds[] = $products[$i]->getId();
            }
        }

        return $filteredProductIds;
    }
}