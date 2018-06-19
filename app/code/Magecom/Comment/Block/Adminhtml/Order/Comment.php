<?php

namespace Magecom\Comment\Block\Adminhtml\Order;

use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Backend\Block\Template\Context;

/**
 * Block provides order comment rendering in admin order view
 *
 * @category Magecom
 * @package Magecom\Comment\Block\Adminhtml\Order
 * @author  Magecom
 */
class Comment extends \Magento\Backend\Block\Template
{
    /**
     * @var
     */
    protected $_order;

    /**
     * @var OrderRepositoryInterface
     */
    protected $_rep;

    /**
     * Comment constructor.
     * @param Context $context
     * @param OrderRepositoryInterface $orderRepository
     * @param array $data
     */
    public function __construct(Context $context, OrderRepositoryInterface $orderRepository, array $data = [])
    {
        $this->_rep = $orderRepository;
        parent::__construct($context, $data);
    }

    /**
     * Get current order
     */
    protected function _beforeToHtml()
    {
        $id = $this->getRequest()->getParam('order_id');
        $this->_order = $this->_rep->get($id);
        parent::_beforeToHtml();
    }

    /**
     * Get order comment
     *
     * @return mixed
     */
    public function getComment()
    {
        $comment = $this->_order->getExtensionAttributes()->getComment();

        return $comment;
    }
}