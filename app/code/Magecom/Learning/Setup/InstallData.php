<?php

namespace Magecom\Learning\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

/**
 * Magecom Learning install data class
 *
 * @category Magecom
 * @package Magecom\Learning\Setup
 * @author  Magecom
 */
class InstallData implements InstallDataInterface
{
    /**
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface $context
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $data = [
            [
                'title' => 'item1',
                'content' => 'hndsjfjfdshj',
                'url_key' => '/item1',
            ],
            [
                'title' => 'item2',
                'content' => 'dklamfewfhuew',
                'url_key' => '/item2',
            ],
            [
                'title' => 'item3',
                'content' => 'vxjciovoisfjewmfwe',
                'url_key' => '/item3',
            ]
        ];

        foreach ($data as $elem) {
            $setup->getConnection()->insert('magecom_learning_items', $elem);
        }
    }
}
