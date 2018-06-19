<?php

namespace Magecom\Learning\Model\Items;

use Magecom\Learning\Model\ResourceModel\Items\CollectionFactory;
use Magento\Ui\DataProvider\AbstractDataProvider;
use Magento\Framework\App\RequestInterface;

/**
 * Items data provider
 *
 * @category Magecom
 * @package Magecom\Learning\Model\Items
 * @author  Magecom
 */
class DataProvider extends AbstractDataProvider
{
    protected $_request;

    public function __construct($name, $primaryFieldName, $requestFieldName, CollectionFactory $itemsCollectionFactory, RequestInterface $request, array $meta = [], array $data = [])
    {
        $this->collection = $itemsCollectionFactory->create();
        $this->_request = $request;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }

        $items = $this->collection->getItems();
        $this->loadedData = array();

        foreach ($items as $item) {
            $this->loadedData[$item->getId()]['item'] = $item->getData();
        }

        return $this->loadedData;
    }
}
