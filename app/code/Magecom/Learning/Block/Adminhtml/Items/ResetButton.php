<?php

namespace Magecom\Learning\Block\Adminhtml\Items;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
 * Class provides reset button rendering
 *
 * @category Magecom
 * @package Magecom\Learning\Block\Adminhtml\Items
 * @author  Magecom
 */
class ResetButton implements ButtonProviderInterface
{
    /**
     * Prepare a button
     *
     * @return array
     */
    public function getButtonData()
    {
        return [
            'label' => __('Reset'),
            'class' => 'reset',
            'on_click' => 'location.reload();',
            'sort_order' => 30
        ];
    }
}
