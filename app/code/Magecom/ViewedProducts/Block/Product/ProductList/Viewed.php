<?php

namespace Magecom\ViewedProducts\Block\Product\ProductList;

class Viewed extends \Magento\Catalog\Block\Product\AbstractProduct
{
    /**
     * Viewed item collection
     *
     * @var \Magento\Catalog\Model\ResourceModel\Product\Link\Product\Collection
     */
    protected $_itemCollection;

    protected $_productLinkFactory;

    protected $_productRepository;

    /**
     * Prepare viewed items data
     *
     * @return $this
     */
    protected function _prepareData()
    {
        $product = $this->_coreRegistry->registry('product');
        /* @var $product \Magento\Catalog\Model\Product */

        $this->_itemCollection = $product->getViewedProductCollection();

        $this->_addProductAttributesAndPrices($this->_itemCollection);

        $this->_itemCollection->load();

        return $this;
    }

    /**
     * Before rendering html process
     * Prepare items collection
     *
     * @return $this
     */
    protected function _beforeToHtml()
    {
        $this->_prepareData();
        return $this;
    }

    /**
     * Retrieve viewed items collection
     *
     * @return array|\Magento\Framework\DataObject[]
     */
    public function getItems()
    {
        if (is_null($this->_itemCollection)) {
            $this->_prepareData();
        }

        $allItems = $this->_itemCollection->getItems();

        $product = $this->_coreRegistry->registry('product');
        $blackIds = $product->getBlackProductIds();

        $filteredItems = [];
        foreach ($allItems as $item) {
            if (array_search($item->getId(), $blackIds) === false) {
                $filteredItems[] = $item;
            }
        }

        if (count($filteredItems) <= 5) {
            return $filteredItems;
        }

        $randKeys = array_rand($filteredItems, 5);
        $items = [];
        foreach ($randKeys as $key) {
            $items[] = $filteredItems[$key];
        }

        return $items;
    }
}