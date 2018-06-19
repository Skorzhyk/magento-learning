<?php

namespace Magecom\Learning\Model\Product;

use Magento\Catalog\Model\Product\Type\AbstractType;
use Magento\Catalog\Model\Product;

/**
 * Learning product type Type class
 *
 * @category Magecom
 * @package Magecom\Learning\Model\Product
 * @author  Magecom
 */
class Type extends AbstractType
{
    const TYPE_ID = 'learning_product_type';

    /**
     * @param Product $product
     */
    public function deleteTypeSpecificData(Product $product)
    {

    }
}