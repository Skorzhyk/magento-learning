<?php

namespace Magecom\Learning\Controller\Adminhtml\Items;

use Magento\Backend\App\Action;
use Magecom\Learning\Model\ItemsFactory;
use Magento\Backend\App\Action\Context;

/**
 * Magecom Learning Items admin controller
 *
 * @category Magecom
 * @package Magecom\Learning\Controller\Adminhtml\Items
 * @author  Magecom
 */
class MassDelete extends Action
{
    /**
     * @var ItemsFactory
     */
    protected $_modelItemsFactory;

    /**
     * MassDelete constructor.
     * @param Context $context
     * @param ItemsFactory $modelItemsFactory
     */
    public function __construct(Context $context, ItemsFactory $modelItemsFactory)
    {
        $this->_modelItemsFactory = $modelItemsFactory;
        parent::__construct($context);
    }

    /**
     * MassDelete action
     */
    public function execute()
    {
        $ids = $this->getRequest()->getParam('selected', []);
        if (!is_array($ids) || !count($ids)) {
            $resultRedirect = $this->resultRedirectFactory->create();
            return $resultRedirect->setPath('*/*/index', array('_current' => true));
        }
        foreach ($ids as $id) {
            if ($item = $this->_modelItemsFactory->create()->load($id)) {
                $item->delete();
            }
        }
        $this->messageManager->addSuccess(__('A total of %1 record(s) have been deleted.', count($ids)));

        $resultRedirect = $this->resultRedirectFactory->create();
        return $resultRedirect->setPath('*/*/index', array('_current' => true));
    }
}