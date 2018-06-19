<?php

namespace Magecom\Comment\Plugin;

use Magento\Quote\Api\CartRepositoryInterface;
use Magento\Quote\Api\Data\CartInterface;
use Magento\Quote\Api\Data\CartExtensionFactory;

/**
 * Plugin provides getting order comment from DB (for quote)
 *
 * @category Magecom
 * @package Magecom\Comment\Plugin
 * @author  Magecom
 */
class GetCommentQuote
{
    /**
     * @var CartExtensionFactory
     */
    protected $_extFactory;

    /**
     * GetCommentQuote constructor.
     * @param CartExtensionFactory $extFactory
     */
    public function __construct(CartExtensionFactory $extFactory)
    {
        $this->_extFactory = $extFactory;
    }

    /**
     * Get order comment from DB (for quote)
     *
     * @param CartRepositoryInterface $subject
     * @param CartInterface $quote
     * @return CartInterface
     */
    public function afterGet(CartRepositoryInterface $subject, CartInterface $quote)
    {
        $ext = $quote->getExtensionAttributes();
        if (!$ext) {
            $ext = $this->_extFactory->create();
        }
        if ($comment = $quote->getComment()) {
            $ext->setComment($comment);
        }

        $quote->setExtensionAttributes($ext);

        return $quote;
    }
}