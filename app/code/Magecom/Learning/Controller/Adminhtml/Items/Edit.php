<?php

namespace Magecom\Learning\Controller\Adminhtml\Items;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Backend\App\Action;
use Magecom\Learning\Model\ItemsFactory;

/**
 * Magecom Learning Items admin controller
 *
 * @category Magecom
 * @package Magecom\Learning\Controller\Adminhtml\Items
 * @author  Magecom
 */
class Edit extends Action
{
    /**
     * @var PageFactory
     */
    protected $_resultPageFactory;

    /**
     * @var ItemsFactory
     */
    protected $_modelItemsFactory;

    /**
     * Edit constructor.
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param ItemsFactory $modelItemsFactory
     */
    public function __construct(Context $context, PageFactory $resultPageFactory, ItemsFactory $modelItemsFactory)
    {
        $this->_resultPageFactory = $resultPageFactory;
        $this->_modelItemsFactory = $modelItemsFactory;
        parent::__construct($context);
    }

    /**
     * Create edit form
     */
    public function execute()
    {
        $this->_view->loadLayout();
        $this->_view->renderLayout();

        $itemData = $this->getRequest()->getParam('item');

        if(is_array($itemData)) {
            $modelItems = $this->_modelItemsFactory->create();
            $modelItems->setData($itemData)->save();
            $resultRedirect = $this->resultRedirectFactory->create();

            return $resultRedirect->setPath('*/*/index');
        }

        return 0;
    }
}