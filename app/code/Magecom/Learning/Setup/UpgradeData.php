<?php

namespace Magecom\Learning\Setup;

use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magecom\Learning\Model\ItemsFactory;

/**
 * Magecom Learning upgrade data class
 *
 * @category Magecom
 * @package Magecom\Learning\Setup
 * @author  Magecom
 */
class UpgradeData implements UpgradeDataInterface
{
    /**
     * @var ItemsFactory
     */
    protected $_modelItemsFactory;

    /**
     * UpgradeData constructor.
     * @param ItemsFactory $modelItemsFactory
     */
    public function __construct(ItemsFactory $modelItemsFactory)
    {
        $this->_modelItemsFactory = $modelItemsFactory;
    }

    /**
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface $context
     */
    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
//        if (version_compare($context->getVersion(), '0.0.2') < 0) {
//            $items = $this->_modelItemsFactory->create()->getCollection();
//
//            foreach ($items as $elem) {
//                $elem->delete();
//            }
//        }

    }
}

