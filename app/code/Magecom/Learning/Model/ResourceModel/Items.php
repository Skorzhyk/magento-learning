<?php

namespace Magecom\Learning\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Items resource model
 *
 * @category Magecom
 * @package Magecom\Learning\Model\ResourceModel
 * @author  Magecom
 */
class Items extends AbstractDb
{
    /**
     * Items constructor.
     */
    protected function _construct()
    {
        $this->_init('magecom_learning_items', 'id');
    }
}
