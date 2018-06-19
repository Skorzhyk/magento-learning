<?php

namespace Magecom\Learning\Block\Adminhtml\Items;

use Magento\Search\Controller\RegistryConstants;
use Magento\Backend\Block\Widget\Context;
use Magento\Framework\Registry;

/**
 * Class provides generating of buttons
 *
 * @category Magecom
 * @package Magecom\Learning\Block\Adminhtml\Items
 * @author  Magecom
 */
class GenericButton
{
    /**
     * @var \Magento\Framework\UrlInterface
     */
    protected $_urlBuilder;

    /**
     * @var Registry
     */
    protected $_registry;

    /**
     * GenericButton constructor.
     * @param Context $context
     * @param Registry $registry
     */
    public function __construct(Context $context, Registry $registry)
    {
        $this->_urlBuilder = $context->getUrlBuilder();
        $this->_registry = $registry;
    }

    /**
     * Get current item ID
     *
     * @return null
     */
    public function getId()
    {
        $item = $this->_registry->registry('item');
        return $item ? $item->getId() : null;
    }

    /**
     * Create URL
     *
     * @param string $route
     * @param array $params
     * @return string
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->_urlBuilder->getUrl($route, $params);
    }
}