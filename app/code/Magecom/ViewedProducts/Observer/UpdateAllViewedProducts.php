<?php

namespace Magecom\ViewedProducts\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;

/**
 * Update all viewed products list on product page
 *
 * @category Magecom
 * @package Magecom\ViewedProducts\Observer
 * @author  Magecom
 */
class UpdateAllViewedProducts implements ObserverInterface
{
    protected $_modelAllViewedProductsFactory;

    protected $_session;

    public function __construct(
        \Magecom\ViewedProducts\Model\AllViewedProductsFactory $modelAllViewedProductsFactory,
        \Magento\Framework\Session\SessionManagerInterface $session
    )
    {
        $this->_modelAllViewedProductsFactory = $modelAllViewedProductsFactory;
        $this->_session = $session;
    }

    public function execute(Observer $observer)
    {
        $modelAllViewedProducts = $this->_modelAllViewedProductsFactory->create();

        $this->_session->start();

        $modelAllViewedProducts->setData([
            'session_id' => $this->_session->getVisitorData()['session_id'],
            'product_id' => $observer->getProduct()->getId()
        ]);

        $modelAllViewedProducts->save();
    }
}