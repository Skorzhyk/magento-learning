<?php

namespace Magecom\ViewedProducts\Model\ProductLink\CollectionProvider;

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
