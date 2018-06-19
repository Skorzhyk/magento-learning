<?php

namespace Magecom\Comment\Plugin;

use Magento\Quote\Api\Data\CartExtensionFactory;

/**
 * Plugin provides getting order comment from checkout to quote
 *
 * @category Magecom
 * @package Magecom\Comment\Plugin
 * @author  Magecom
 */
class PaymentInformationManagementPlugin
{
    /**
     * @var \Magento\Sales\Api\OrderRepositoryInterface
     */
    protected $_orderRepository;

    /**
     * @var \Magento\Quote\Model\QuoteRepository
     */
    protected $_quoteRepository;

    /**
     * @var CartExtensionFactory
     */
    protected $_extFactory;

    /**
     * PaymentInformationManagementPlugin constructor.
     * @param \Magento\Sales\Api\OrderRepositoryInterface $orderRepository
     * @param \Magento\Quote\Model\QuoteRepository $quoteRepository
     * @param CartExtensionFactory $extensionFactory
     */
    public function __construct(
        \Magento\Sales\Api\OrderRepositoryInterface $orderRepository,
        \Magento\Quote\Model\QuoteRepository $quoteRepository,
        CartExtensionFactory $extensionFactory
    ) {
        $this->_orderRepository = $orderRepository;
        $this->_quoteRepository = $quoteRepository;
        $this->_extFactory = $extensionFactory;
    }

    /**
     * Get order comment from checkout to quote
     *
     * @param \Magento\Checkout\Model\PaymentInformationManagement $subject
     * @param $cartId
     * @param \Magento\Quote\Api\Data\PaymentInterface $paymentMethod
     * @param \Magento\Quote\Api\Data\AddressInterface|null $billingAddress
     */
    public function beforeSavePaymentInformation(
        \Magento\Checkout\Model\PaymentInformationManagement $subject,
        $cartId,
        \Magento\Quote\Api\Data\PaymentInterface $paymentMethod,
        \Magento\Quote\Api\Data\AddressInterface $billingAddress = null
    )
    {
        $comment = $paymentMethod->getExtensionAttributes()->getComment();
        $quote = $this->_quoteRepository->getActive($cartId);

        $ext = $this->_extFactory->create();
        $ext->setComment($comment);
        $quote->setExtensionAttributes($ext);
        $this->_quoteRepository->save($quote);
    }
}