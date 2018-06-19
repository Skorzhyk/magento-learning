<?php

namespace Magecom\Learning\Plugin\Model;

/**
 * Learning plugin for Product
 *
 * @category Magecom
 * @package Magecom\Learning\Plugin\Model
 * @author  Magecom
 */
class Product
{
    /**
     * Add text to product name
     *
     * @param \Magento\Catalog\Model\Product $subject
     * @param $result
     * @return string
     */
    public function afterGetName(\Magento\Catalog\Model\Product $subject, $result)
    {
        $result .= ' low price';

        return $result;
    }
}