<?php

namespace Magecom\ViewedProducts\Model\ResourceModel\AllViewedProducts;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init('Magecom\ViewedProducts\Model\AllViewedProducts', 'Magecom\ViewedProducts\Model\ResourceModel\AllViewedProducts');
    }
}