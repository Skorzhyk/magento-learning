<?php

namespace Magecom\Learning\Block\Adminhtml\Items;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

/**
 * Class provides back button rendering
 *
 * @category Magecom
 * @package Magecom\Learning\Block\Adminhtml\Items
 * @author  Magecom
 */
class BackButton extends GenericButton implements ButtonProviderInterface
{
    /**
     * Prepare a button
     *
     * @return array
     */
    public function getButtonData()
    {
        return [
            'label' => __('Back'),
            'on_click' => sprintf("location.href = '%s';", $this->getBackUrl()),
            'class' => 'back',
            'sort_order' => 10
        ];
    }

    /**
     * Create button URL
     *
     * @return string
     */
    public function getBackUrl()
    {
        return $this->getUrl('*/*/');
    }
}