<?php

namespace Magecom\ViewedProducts\Model;

use Magento\Framework\Model\AbstractModel;

class AllViewedProducts extends AbstractModel
{
    protected function _construct()
    {
        $this->_init('Magecom\ViewedProducts\Model\ResourceModel\AllViewedProducts');
    }
}