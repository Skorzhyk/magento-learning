<?php

namespace Magecom\Learning\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\DB\Ddl\Table;

/**
 * Magecom Learning upgrade schema class
 *
 * @category Magecom
 * @package Magecom\Learning\Setup
 * @author  Magecom
 */
class UpgradeSchema implements UpgradeSchemaInterface
{
    /**
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     */
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        if (version_compare($context->getVersion(), '0.0.2') < 0) {
            $installer->startSetup();
            $installer->getConnection()->addColumn(
                'magecom_learning_items',
                'status',
                ['type' => Table::TYPE_SMALLINT, 'size' => null, 'nullable' => false, 'default' => 0, 'comment' => 'Status']
            );

            $installer->endSetup();
        }

    }
}
