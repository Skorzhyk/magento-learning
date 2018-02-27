<?php

namespace Magecom\ViewedProducts\Model;

use Magento\Catalog\Model\Product as ProductModel;

class Product extends ProductModel
{
    /**
     * Retrieve array of viewed products
     *
     * @return array
     */
    public function getViewedProducts()
    {
        if (!$this->hasViewedProducts()) {
            $products = [];
            $collection = $this->getViewedProductCollection();
            foreach ($collection as $product) {
                $products[] = $product;
            }
            $this->setViewedProducts($products);
        }
        return $this->getData('viewed_products');
    }

    /**
     * Retrieve viewed products identifiers
     *
     * @return array
     */
    public function getViewedProductIds()
    {
        if (!$this->hasViewedProductIds()) {
            $ids = [];
            foreach ($this->getViewedProducts() as $product) {
                $ids[] = $product->getId();
            }
            $this->setViewedProductIds($ids);
        }
        return $this->getData('viewed_product_ids');
    }

    /**
     * Retrieve collection viewed product
     *
     * @return \Magento\Catalog\Model\ResourceModel\Product\Link\Product\Collection
     */
    public function getViewedProductCollection()
    {
        $collection = $this->getLinkInstance()->useViewedLinks()->getProductCollection()->setIsStrongMode();
        $collection->setProduct($this);
        return $collection;
    }

    /**
     * Retrieve collection viewed link
     *
     * @return \Magento\Catalog\Model\ResourceModel\Product\Link\Collection
     */
    public function getRelatedLinkCollection()
    {
        $collection = $this->getLinkInstance()->useViewedLinks()->getLinkCollection();
        $collection->setProduct($this);
        $collection->addLinkTypeIdFilter();
        $collection->addProductIdFilter();
        $collection->joinAttributes();
        return $collection;
    }
}