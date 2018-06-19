<?php

namespace Magecom\Learning\Block\Widget;

use Magento\Framework\View\Element\Template;
use Magento\Widget\Block\BlockInterface;

/**
 * Learning widget
 *
 * @category Magecom
 * @package Magecom\Learning\Block\Widget
 * @author  Magecom
 */
class TestWidget extends Template implements BlockInterface
{
    /**
     * TestWidget constructor.
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setTemplate('widget/testwidget.phtml');
    }
}