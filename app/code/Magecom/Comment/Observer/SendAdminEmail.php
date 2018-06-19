<?php

namespace Magecom\Comment\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\User\Model\UserFactory;

/**
 * Observer provides sending order information to admins
 *
 * @category Magecom
 * @package Magecom\Comment\Observer
 * @author  Magecom
 */
class SendAdminEmail implements ObserverInterface
{
    /**
     * @var StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * @var TransportBuilder
     */
    protected $_transportBuilder;

    /**
     * @var UserFactory
     */
    protected $_modelUserFactory;

    /**
     * SendAdminEmail constructor.
     * @param StoreManagerInterface $storeManager
     * @param TransportBuilder $transportBuilder
     * @param UserFactory $modelUserFactory
     */
    public function __construct(
        StoreManagerInterface $storeManager,
        TransportBuilder $transportBuilder,
        UserFactory $modelUserFactory
    )
    {
        $this->_storeManager = $storeManager;
        $this->_transportBuilder = $transportBuilder;
        $this->_modelUserFactory = $modelUserFactory;
    }

    /**
     * Send order information to admins
     *
     * @param Observer $observer
     */
    public function execute(Observer $observer)
    {
        $templateVars = $observer->getEvent()->getData('transport')->getData();

        $templateOptions = array('area' => \Magento\Framework\App\Area::AREA_FRONTEND, 'store' => $this->_storeManager->getStore()->getId());

        $modelUser = $this->_modelUserFactory->create();
        $admins = $modelUser->getCollection()->getData();

        $from = array('email' => 'sales@example.com', 'name' => 'Sales');
        $to = [];
        foreach ($admins as $admin) {
            $to[] = $admin['email'];
        }

        $transport = $this->_transportBuilder->setTemplateIdentifier('order_info')
            ->setTemplateOptions($templateOptions)
            ->setTemplateVars($templateVars)
            ->setFrom($from)
            ->addTo($to)
            ->getTransport();
        $transport->sendMessage();
    }
}