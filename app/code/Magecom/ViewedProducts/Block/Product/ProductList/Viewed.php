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

    public function __construct(
        \Magento\Catalog\Block\Product\Context $context,
        array $data = [])
    {
        parent::__construct($context, $data);
    }

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
        if (count($allItems) <= 5) {
            return $allItems;
        }

        $randKeys = array_rand($allItems, 5);
        $items = [];
        foreach ($randKeys as $key) {
            $items[] = $allItems[$key];
        }

        return $items;
    }
}
