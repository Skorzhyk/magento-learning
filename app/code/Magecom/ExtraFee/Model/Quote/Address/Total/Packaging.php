<?php

namespace Magecom\ExtraFee\Model\Quote\Address\Total;

class Packaging extends \Magento\Quote\Model\Quote\Address\Total\AbstractTotal
{
    /**
     * @var \Magento\Framework\Pricing\PriceCurrencyInterface
     */
    protected $_priceCurrency;

    /**
     * @param \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency
     */
    public function __construct(
        \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency
    ) {
        $this->_priceCurrency = $priceCurrency;
    }

    public function collect(
        \Magento\Quote\Model\Quote $quote,
        \Magento\Quote\Api\Data\ShippingAssignmentInterface $shippingAssignment,
        \Magento\Quote\Model\Quote\Address\Total $total
    ) {
        parent::collect($quote, $shippingAssignment, $total);

        $packaging = 10;
        $total->addTotalAmount('packaging', $packaging);
        $total->addBaseTotalAmount('packaging', $packaging);
        $quote->setPackaging($packaging);

        return $this;
    }

    public function fetch(
        \Magento\Quote\Model\Quote $quote,
        \Magento\Quote\Model\Quote\Address\Total $total
    ) {
        return [
            'code' => 'packaging',
            'title' => $this->getLabel(),
            'value' => 10
        ];
    }

    /**
     * get label
     * @return string
     */
    public function getLabel() {
        return __('Packaging');
    }
}