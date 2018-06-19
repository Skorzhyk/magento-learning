<?php

namespace Magecom\Comment\Plugin;

use Magento\Quote\Api\CartRepositoryInterface;
use Magento\Quote\Api\Data\CartInterface;
use Magento\Quote\Api\Data\CartExtensionFactory;

/**
 * Plugin provides saving order comment into DB (from quote)
 *
 * @category Magecom
 * @package Magecom\Comment\Plugin
 * @author  Magecom
 */
class SaveCommentQuote
{
    /**
     * @var CartExtensionFactory
     */
    protected $_extFactory;

    /**
     * SaveCommentQuote constructor.
     * @param CartExtensionFactory $extFactory
     */
    public function __construct(CartExtensionFactory $extFactory)
    {
        $this->_extFactory = $extFactory;
    }

    /**
     * Save order comment into DB (from quote)
     *
     * @param CartRepositoryInterface $subject
     * @param CartInterface $quote
     * @return array
     */
    public function beforeSave(CartRepositoryInterface $subject, CartInterface $quote)
    {
        $ext = $quote->getExtensionAttributes();
        if ($ext && $ext->getComment()) {
            $quote->setComment($ext->getComment());
        }

        return [$quote];
    }
}