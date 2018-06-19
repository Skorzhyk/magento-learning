<?php

namespace Magecom\Learning\Block;

use Magecom\Learning\Model\ItemsFactory;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

/**
 * TestDB controller block
 *
 * @category Magecom
 * @package Magecom\Learning\Block
 * @author  Magecom
 */
class Items extends Template
{
    /**
     * @var ItemsFactory
     */
    protected $_modelItemsFactory;

    /**
     * @var ScopeConfigInterface
     */
    protected $_scopeConfig;

    /**
     * Items constructor.
     * @param Context $context
     * @param ItemsFactory $modelItemsFactory
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(Context $context, ItemsFactory $modelItemsFactory, ScopeConfigInterface $scopeConfig)
    {
        $this->_modelItemsFactory = $modelItemsFactory;
        $this->_scopeConfig = $scopeConfig;
        parent::__construct($context);
    }

    /**
     * Render some data from magecom_learning_items table
     */
    public function prepareData()
    {
        if (!$this->_scopeConfig->getValue('learning/general/enable', ScopeInterface::SCOPE_STORE)) {
            echo $this->_scopeConfig->getValue('learning/general/info', ScopeInterface::SCOPE_STORE);

            return;
        }

        $modelItems = $this->_modelItemsFactory->create();
        $items = $modelItems->getCollection()->getData();

        echo "ID | Title | Creation time <br><br>";
        $space = str_repeat("&nbsp", 5);
        foreach ($items as $elem) {
            echo $elem['id'] . $space . $elem['title'] . $space . $elem['creation_time'] . "<br>";
        }
        echo "<br>Number of records: " . count($items);
    }
}