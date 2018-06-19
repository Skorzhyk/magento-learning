<?php

namespace Magecom\Comment\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;
use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Sales\Api\Data\OrderExtensionFactory;

/**
 * Observer provides passing order comment from quote to order
 *
 * @category Magecom
 * @package Magecom\Comment\Observer
 * @author  Magecom
 */
class PassCommentToOrder implements ObserverInterface
{
    /**
     * @var OrderRepositoryInterface
     */
    protected $_rep;

    /**
     * @var OrderExtensionFactory
     */
    protected $_extFactory;

    /**
     * @var \Magento\Quote\Model\QuoteRepository
     */
    protected $_quoteRepository;

    /**
     * PassCommentToOrder constructor.
     * @param OrderRepositoryInterface $rep
     * @param OrderExtensionFactory $extensionFactory
     * @param \Magento\Quote\Model\QuoteRepository $quoteRepository
     */
    public function __construct(
        OrderRepositoryInterface $rep,
        OrderExtensionFactory $extensionFactory,
        \Magento\Quote\Model\QuoteRepository $quoteRepository
    )
    {
        $this->_rep = $rep;
        $this->_extFactory = $extensionFactory;
        $this->_quoteRepository = $quoteRepository;
    }

    /**
     * Pass order comment from quote to order
     *
     * @param Observer $observer
     */
    public function execute(Observer $observer)
    {
        $order = $observer->getEvent()->getData('order');
        $quote = $observer->getEvent()->getData('quote');

        $ext = $order->getExtensionAttributes();
        if (!$ext) {
            $ext = $this->_extFactory->create();
        }
        if ($comment = $quote->getComment()) {
            $ext->setComment($comment);
        }
        $order->setExtensionAttributes($ext);
    }
}