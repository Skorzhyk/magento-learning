<?php

namespace Magecom\Learning\Model;

use Magento\Framework\Cache\Frontend\Decorator\TagScope;
use Magento\Framework\App\Cache\Type\FrontendPool;

/**
 * Learning cache model
 *
 * @category Magecom
 * @package Magecom\Learning\Model
 * @author  Magecom
 */
class Cache extends TagScope
{
    const TYPE_IDENTIFIER = 'magecom_learning';

    const CACHE_TAG = 'LEARNING';

    /**
     * Cache constructor.
     * @param FrontendPool $cacheFrontendPool
     */
    public function __construct(FrontendPool $cacheFrontendPool)
    {
        parent::__construct($cacheFrontendPool->get(self::TYPE_IDENTIFIER), self::CACHE_TAG);
    }
}