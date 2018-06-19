<?php

namespace Magecom\Comment\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Ddl\Table;

/**
 * Class add comment field to order and quote tables
 *
 * @category Magecom
 * @package Magecom\Comment\Setup
 * @author  Magecom
 */
class InstallSchema implements InstallSchemaInterface
{
    /**
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;

        $installer->getConnection()
            ->addColumn(
                $setup->getTable('quote'),
                'comment',
                [
                    'type' => Table::TYPE_TEXT,
                    'length' => 255,
                    'comment' =>'Comment'
                ]
            );

        $installer->getConnection()
            ->addColumn(
                $setup->getTable('sales_order'),
                'comment',
                [
                    'type' => Table::TYPE_TEXT,
                    'length' => 255,
                    'comment' =>'Comment'
                ]
            );

        $installer->endSetup();
    }
}