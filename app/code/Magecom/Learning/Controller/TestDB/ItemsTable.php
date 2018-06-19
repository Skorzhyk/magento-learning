<?php

namespace Magecom\Learning\Controller\TestDB;

use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\Action;

/**
 * Magecom Learning TestDB controller
 *
 * @category Magecom
 * @package Magecom\Learning\Controller\TestDB
 * @author  Magecom
 */
class ItemsTable extends Action
{
    /**
     * @var PageFactory
     */
    protected $_resultPageFactory;

    /**
     * ItemsTable constructor.
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(Context $context, PageFactory $resultPageFactory)
    {
        $this->_resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    /**
     * ItemsTable action
     *
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        $resultPage = $this->_resultPageFactory->create();
        return $resultPage;
    }
}