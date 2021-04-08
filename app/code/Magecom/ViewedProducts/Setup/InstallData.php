<?php

namespace Magecom\ViewedProducts\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class InstallData implements InstallDataInterface
{
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        /**
         * Install viewed product link type
         */
        $data = [
            ['link_type_id' => \Magecom\ViewedProducts\Model\Product\Link::LINK_TYPE_VIEWED, 'code' => 'viewed']
        ];

        foreach ($data as $bind) {
            $setup->getConnection()
                ->insertForce($setup->getTable('catalog_product_link_type'), $bind);
        }

        /**
         * Install view product link position attribute
         */
        $data = [
            [
                'link_type_id' => \Magecom\ViewedProducts\Model\Product\Link::LINK_TYPE_VIEWED,
                'product_link_attribute_code' => 'position',
                'data_type' => 'int',
            ]
        ];

        $setup->getConnection()
            ->insertMultiple($setup->getTable('catalog_product_link_attribute'), $data);

        /**
         * Install view product link frequency attribute
         */
        $data = [
            [
                'link_type_id' => \Magecom\ViewedProducts\Model\Product\Link::LINK_TYPE_VIEWED,
                'product_link_attribute_code' => 'frequency',
                'data_type' => 'int',
            ]
        ];

        $setup->getConnection()
            ->insertMultiple($setup->getTable('catalog_product_link_attribute'), $data);

        /**
         * Install view product link range attribute
         */
        $data = [
            [
                'link_type_id' => \Magecom\ViewedProducts\Model\Product\Link::LINK_TYPE_VIEWED,
                'product_link_attribute_code' => 'range',
                'data_type' => 'varchar',
            ]
        ];

        $setup->getConnection()
            ->insertMultiple($setup->getTable('catalog_product_link_attribute'), $data);

        /**
         * Install black product link type
         */
        $data = [
            ['link_type_id' => \Magecom\ViewedProducts\Model\Product\Link::LINK_TYPE_BLACK, 'code' => 'black']
        ];

        foreach ($data as $bind) {
            $setup->getConnection()
                ->insertForce($setup->getTable('catalog_product_link_type'), $bind);
        }

        /**
         * Install black product link attribute
         */
        $data = [
            [
                'link_type_id' => \Magecom\ViewedProducts\Model\Product\Link::LINK_TYPE_BLACK,
                'product_link_attribute_code' => 'position',
                'data_type' => 'int',
            ]
        ];

        $setup->getConnection()
            ->insertMultiple($setup->getTable('catalog_product_link_attribute'), $data);
    }
}