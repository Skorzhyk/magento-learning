<?php

namespace Magecom\Learning\Model;

use Magento\Catalog\Model\Product\Attribute\Source\Status;

/**
 * Magento Product rewrite class
 *
 * @category Magecom
 * @package Magecom\Learning\Model
 * @author  Magecom
 */
class Product extends \Magento\Catalog\Model\Product
{
    /**
     * Get product status
     *
     * @return int
     */
    public function getStatus()
    {
        return Status::STATUS_ENABLED;
    }
}
