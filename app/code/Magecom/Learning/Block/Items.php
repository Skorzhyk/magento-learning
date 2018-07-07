<?php

namespace Magecom\Learning\Block;

use Magecom\Learning\Model\ItemsFactory as ItemsModelFactory;
use Magecom\Learning\Model\ResourceModel\ItemsFactory as ItemsResourceModelFactory;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Catalog\Model\ProductRepository;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;

class Items extends Template
{
    protected $_itemsResourceModelFactory;

    protected $_itemsModelFactory;

    protected $_scopeConfig;

    protected $_searchCriteriaBuilder;

    protected $_searchResults;

    protected $_productRepository;

    protected $_collectionProcessor;

    protected $_filterBuilder;

    protected $_filterGroupBuilder;

    public function __construct(
        Context $context,
        ItemsResourceModelFactory $itemsResourceModelFactory,
        ItemsModelFactory $itemsModelFactory,
        ScopeConfigInterface $scopeConfig,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        ProductRepository $productRepository,
        CollectionProcessorInterface $collectionProcessor,
        \Magento\Framework\Api\FilterBuilder $filterBuilder,
        \Magento\Framework\Api\Search\FilterGroupBuilder $filterGroupBuilder

    )
    {
        $this->_itemsResourceModelFactory = $itemsResourceModelFactory;
        $this->_itemsModelFactory = $itemsModelFactory;
        $this->_scopeConfig = $scopeConfig;
        $this->_searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->_productRepository = $productRepository;
        $this->_collectionProcessor = $collectionProcessor;
        $this->_filterBuilder = $filterBuilder;
        $this->_filterGroupBuilder = $filterGroupBuilder;
        parent::__construct($context);
    }

    public function prepareData()
    {
        if (!$this->_scopeConfig->getValue('learning/general/enable', ScopeInterface::SCOPE_STORE)) {
            echo $this->_scopeConfig->getValue('learning/general/info', ScopeInterface::SCOPE_STORE);

            return;
        }

        $collection = $this->_itemsModelFactory->create()->getCollection();
        $searchCriteria = $this->_searchCriteriaBuilder->addFilter('title', 'item2', 'eq')->create();
        $this->_collectionProcessor->process($searchCriteria, $collection);
        $collection->load();

//        $items = $modelItems->getCollection()->getData();
//
//        echo "ID | Title | Creation time <br><br>";
//        $space = str_repeat("&nbsp", 5);
//        foreach ($items as $elem) {
//            echo $elem['id'] . $space . $elem['title'] . $space . $elem['creation_time'] . "<br>";
//        }
//        echo "<br>Number of records: " . count($items);
    }
}