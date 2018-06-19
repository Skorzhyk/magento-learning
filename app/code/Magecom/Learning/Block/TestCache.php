<?php

namespace Magecom\Learning\Block;

use Magento\Framework\View\Element\Template;
use Magecom\Learning\Model\Cache;
use Magento\Framework\View\Element\Template\Context;

/**
 * TestCache controller block
 *
 * @category Magecom
 * @package Magecom\Learning\Block
 * @author  Magecom
 */
class TestCache extends Template
{
    /**
     * @var \Magecom\Learning\Model\Cache
     */
    protected $_cache;

    /**
     * TestCache constructor.
     * @param Context $context
     * @param \Magecom\Learning\Model\Cache $cache
     */
    public function __construct(Context $context, Cache $cache)
    {
        parent::__construct($context);
        $this->_cache = $cache;
    }

    /**
     * Fill learning cache
     *
     * @return bool|string
     */
    public function fillCache()
    {
        $cacheId = 'learning';
        $pageInfo = "<h1> Just a header </h1>
            <p> Some text <p>
            <a href='http://google.com'>It's Google!</a>";
        $this->_cache->save($pageInfo, $cacheId);

        return $this->_cache->load($cacheId);
    }

    /**
     * Prepare frontend page
     *
     * @return bool|string
     */
    public function getPage()
    {
        $cacheId = 'learning';
        $pageInfo = $this->_cache->load($cacheId);


        if (!$pageInfo) {
            $pageInfo = $this->fillCache();
        }

        return $pageInfo;
    }
}