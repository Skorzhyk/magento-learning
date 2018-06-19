<?php

namespace Magecom\Learning\Model;

use Magento\Framework\Model\AbstractModel;

/**
 * Items model
 *
 * @category Magecom
 * @package Magecom\Learning\Model
 * @author  Magecom
 */
class Items extends AbstractModel
{
    /**
     * Items constructor.
     */
    protected function _construct()
    {
        $this->_init('Magecom\Learning\Model\ResourceModel\Items');
    }
}