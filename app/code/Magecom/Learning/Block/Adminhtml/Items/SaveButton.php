<?php

namespace Magecom\Learning\Block\Adminhtml\Items;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
 * Class provides save button rendering
 *
 * @category Magecom
 * @package Magecom\Learning\Block\Adminhtml\Items
 * @author  Magecom
 */
class SaveButton extends GenericButton implements ButtonProviderInterface
{
    /**
     * Prepare a button
     *
     * @return array
     */
    public function getButtonData()
    {
        return [
            'label' => __('Save Item'),
            'class' => 'save primary',
            'data_attribute' => [
                'mage-init' => ['button' => ['event' => 'save']],
                'form-role' => 'save',
            ],
            'sort_order' => 90,
        ];
    }
}