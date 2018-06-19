<?php

namespace Magecom\Learning\Model\ResourceModel\Items;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Items collection
 *
 * @category Magecom
 * @package Magecom\Learning\Model\ResourceModel\Items
 * @author  Magecom
 */
class Collection extends AbstractCollection
{
    /**
     * Collection constructor.
     */
    protected function _construct()
    {
        $this->_init('Magecom\Learning\Model\Items', 'Magecom\Learning\Model\ResourceModel\Items');
    }
}
