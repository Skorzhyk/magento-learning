<?php

namespace Magecom\Learning\Controller\Adminhtml\Items;

use Magento\Backend\App\Action\Context;
use Magento\Backend\App\Action;
use Magecom\Learning\Model\ItemsFactory;

/**
 * Magecom Learning Items admin controller
 *
 * @category Magecom
 * @package Magecom\Learning\Controller\Adminhtml\Items
 * @author  Magecom
 */
class Delete extends Action
{
    /**
     * @var ItemsFactory
     */
    protected $_modelItemsFactory;

    /**
     * Delete constructor.
     * @param Context $context
     * @param ItemsFactory $modelItemsFactory
     */
    public function __construct(Context $context, ItemsFactory $modelItemsFactory)
    {
        $this->_modelItemsFactory = $modelItemsFactory;
        parent::__construct($context);
    }

    /**
     * Delete action
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('id');

        if ($item = $this->_modelItemsFactory->create()->load($id)) {
            $item->delete();
        }

        $resultRedirect = $this->resultRedirectFactory->create();

        return $resultRedirect->setPath('*/*/index', array('_current' => true));
    }
}
