<?php

namespace Magecom\Learning\Controller\Adminhtml\Items;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Backend\App\Action;
use Magento\Framework\Profiler;

/**
 * Magecom Learning Items admin controller
 *
 * @category Magecom
 * @package Magecom\Learning\Controller\Adminhtml\Items
 * @author  Magecom
 */
class Index extends Action
{
    /**
     * @var PageFactory
     */
    protected $_resultPageFactory;

    /**
     * Index constructor.
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(Context $context, PageFactory $resultPageFactory)
    {
        $this->_resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    /**
     * Product page listing
     *
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        Profiler::start('my_profiler');

        $resultPage = $this->_resultPageFactory->create();
        $resultPage->setActiveMenu('Magecom_Learning::items');
        $resultPage->getConfig()->getTitle()->prepend(__('Items'));
        $resultPage->addBreadcrumb(__('Magecom'), __('Magecom'));
        $resultPage->addBreadcrumb(__('Learning'), __('Items'));

        Profiler::stop('my_profiler');

        return $resultPage;
    }

    /**
     * Check permission
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Magecom_Learning::items');
    }

}