<?php

namespace Magecom\Comment\Plugin;

use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Api\Data\OrderExtensionFactory;

/**
 * Plugin provides saving order comment into DB (from order)
 *
 * @category Magecom
 * @package Magecom\Comment\Plugin
 * @author  Magecom
 */
class SaveCommentOrder
{
    /**
     * @var OrderExtensionFactory
     */
    protected $_extFactory;

    /**
     * SaveCommentOrder constructor.
     * @param OrderExtensionFactory $extFactory
     */
    public function __construct(OrderExtensionFactory $extFactory)
    {
        $this->_extFactory = $extFactory;
    }

    /**
     * Save order comment into DB (from order)
     *
     * @param OrderRepositoryInterface $subject
     * @param OrderInterface $order
     * @return array
     */
    public function beforeSave(OrderRepositoryInterface $subject, OrderInterface $order)
    {
        $ext = $order->getExtensionAttributes();
        if ($ext && $ext->getComment()) {
            $order->setComment($ext->getComment());
        }

        return [$order];
    }
}