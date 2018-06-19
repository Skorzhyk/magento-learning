<?php

namespace Magecom\Comment\Plugin;

use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Api\Data\OrderExtensionFactory;

/**
 * Plugin provides getting order comment from DB (for order)
 *
 * @category Magecom
 * @package Magecom\Comment\Plugin
 * @author  Magecom
 */
class GetCommentOrder
{
    /**
     * @var OrderExtensionFactory
     */
    protected $_extFactory;

    /**
     * GetCommentOrder constructor.
     * @param OrderExtensionFactory $extFactory
     */
    public function __construct(OrderExtensionFactory $extFactory)
    {
        $this->_extFactory = $extFactory;
    }

    /**
     * Get order comment from DB (for order)
     *
     * @param OrderRepositoryInterface $subject
     * @param OrderInterface $order
     * @return OrderInterface
     */
    public function afterGet(OrderRepositoryInterface $subject, OrderInterface $order)
    {
        $ext = $order->getExtensionAttributes();
        if (!$ext) {
            $ext = $this->_extFactory->create();
        }
        $ext->setComment($order->getComment());
        $order->setExtensionAttributes($ext);

        return $order;
    }
}