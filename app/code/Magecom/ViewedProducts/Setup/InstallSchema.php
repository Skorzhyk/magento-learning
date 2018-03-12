<?php

namespace Magecom\ViewedProducts\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;

        $table = $installer->getConnection()->newTable($installer->getTable('magecom_all_viewed_products')
        )->addColumn(
            'id',
            Table::TYPE_INTEGER,
            null,
            ['identity' => true, 'nullable' => false, 'primary' => true],
            'ID'
        )->addColumn(
            'session_id',
            Table::TYPE_TEXT,
            255,
            ['nullable' => false],
            'Session ID'
        )->addColumn(
            'product_id',
            Table::TYPE_INTEGER,
            null,
            ['nullable' => false],
            'Product ID'
        )->addColumn(
            'processed',
            Table::TYPE_INTEGER,
            null,
            ['nullable' => false, 'default' => 0],
            'If record processed'
        )->setComment('All viewed products');

        $installer->getConnection()->createTable($table);

        $installer->endSetup();
    }
}