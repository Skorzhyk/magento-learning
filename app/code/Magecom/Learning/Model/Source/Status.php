<?php

namespace Magecom\Learning\Model\Source;

use Magento\Framework\Option\ArrayInterface;

/**
 * Used in creating options for Status config value selection
 *
 * @category Magecom
 * @package Magecom\Learning\Model\Source
 * @author  Magecom
 */
class Status implements ArrayInterface
{
    /**
     * Create otions
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => '1', 'label' => 'Enabled'],
            ['value' => '0', 'label' => 'Disabled'],
            ['value' => '2', 'label' => 'Archive']
        ];
    }
}