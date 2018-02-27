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

    protected $_productCollection;

    public function __construct(
        \Magento\Catalog\Block\Product\Context $context,
        \Magento\Catalog\Model\ResourceModel\Product\Link\Product\Collection $productCollection,
        array $data = []
    )
    {
        $this->_productCollection = $productCollection;
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
     * @return \Magento\Catalog\Model\ResourceModel\Product\Link\Product\Collection
     */
    public function getItems()
    {
        if (is_null($this->_itemCollection)) {
            $this->_prepareData();
        }

        return $this->_itemCollection;
    }
}
