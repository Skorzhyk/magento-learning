<?php

namespace Magecom\Learning\Controller;

use Magento\Framework\App\RouterInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\UrlInterface;
use Magento\Framework\App\ActionFactory;

/**
 * Learning custom router
 *
 * @category Magecom
 * @package Magecom\Learning\Controller
 * @author  Magecom
 */
class Router implements RouterInterface
{
    /**
     * @var UrlInterface
     */
    protected $_urlInterface;

    /**
     * @var ActionFactory
     */
    protected $_actionFactory;

    /**
     * Router constructor.
     * @param UrlInterface $urlInterface
     * @param ActionFactory $actionFactory
     */
    public function __construct(UrlInterface $urlInterface, ActionFactory $actionFactory)
    {
        $this->_urlInterface = $urlInterface;
        $this->_actionFactory = $actionFactory;
    }

    /**
     * Transform particular link type
     *
     * @param RequestInterface $request
     * @return int
     */
    public function match(RequestInterface $request)
    {
        $identifier = trim($request->getPathInfo(), '/');
        $urlArray = explode('-', $identifier);
        if ($urlArray[0] == 'learning') {
            $request->setPathInfo('/' . implode('/', $urlArray));
        }

        return 0;
    }
}