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
class AddMenuAbout implements ObserverInterface
{
    /**
     * @var Http
     */
    protected $_request;

    /**
     * AddMenuAbout constructor.
     * @param Http $request
     */
    public function __construct(Http $request)
    {
        $this->_request = $request;
    }

    /**
     * Add menu item "about"
     *
     * @param Observer $observer
     * @return $this
     */
    public function execute(Observer $observer)
    {
        $menu = $observer->getData('menu');
        $children = $menu->getChildren();
        $tree = $menu->getTree('tree');
        $subChildren = clone $children;

        $action = $this->_request->getOriginalPathInfo();
        $data = [
            'name' => 'About us',
            'id' => 'about',
            'url' => '/about-us',
            'is_active' => ($action == '/about-us')
        ];
        $node = new Node($data, 'id', $tree, $menu);

        foreach ($children as $child) {
            $menu->removeChild($child);
        }
        $menu->addChild($node);
        foreach ($subChildren as $child) {
            $menu->addChild($child);
        }

        return $this;
    }
}