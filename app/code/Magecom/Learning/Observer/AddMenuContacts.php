<?php

namespace Magecom\Learning\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\Data\Tree\Node;
use Magento\Framework\App\Request\Http;

/**
 * Frontend menu observer
 *
 * @category Magecom
 * @package Magecom\Learning\Observer
 * @author  Magecom
 */
class AddMenuContacts implements ObserverInterface
{
    /**
     * @var Http
     */
    protected $_request;

    /**
     * AddMenuContacts constructor.
     * @param Http $request
     */
    public function __construct(Http $request)
    {
        $this->_request = $request;;
    }

    /**
     * Add menu item "contacts"
     *
     * @param Observer $observer
     * @return $this
     */
    public function execute(Observer $observer)
    {
        $menu = $observer->getData('menu');
        $tree = $menu->getTree('tree');

        $action = $this->_request->getOriginalPathInfo();
        $data = [
            'name' => 'Contacts',
            'id' => 'contacts',
            'url' => '/contact',
            'is_active' => ($action == '/contact')
        ];
        $node = new Node($data, 'id', $tree, $menu);
        $menu->addChild($node);

        return $this;
    }
}