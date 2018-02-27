<?php

namespace Magecom\ViewedProducts\Model\ProductLink\CollectionProvider;

class Viewed implements \Magento\Catalog\Model\ProductLink\CollectionProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function getLinkedProducts(\Magento\Catalog\Model\Product $product)
    {
        return $product->getViewedProducts();
    }
}
