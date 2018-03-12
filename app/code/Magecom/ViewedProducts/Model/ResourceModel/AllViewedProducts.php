<?php

namespace Magecom\ViewedProducts\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class AllViewedProducts extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('magecom_all_viewed_products', 'id');
    }
}