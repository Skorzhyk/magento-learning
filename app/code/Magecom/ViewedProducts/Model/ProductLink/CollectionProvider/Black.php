<?php

namespace Magecom\ViewedProducts\Model\ProductLink\CollectionProvider;

/**
 * Black products Collection Provider class
 *
 * @category Magecom
 * @package Magecom\ViewedProducts\Model\ProductLink\CollectionProvider
 * @author  Magecom
 */
class Black implements \Magento\Catalog\Model\ProductLink\CollectionProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function getLinkedProducts(\Magento\Catalog\Model\Product $product)
    {
        return $product->getBlackProducts();
    }
}
