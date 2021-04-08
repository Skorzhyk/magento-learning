<?php

namespace Magecom\ViewedProducts\Model\ProductLink\CollectionProvider;

/**
 * Viewed products Collection Provider class
 *
 * @category Magecom
 * @package Magecom\ViewedProducts\Model\ProductLink\CollectionProvider
 * @author  Magecom
 */
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
