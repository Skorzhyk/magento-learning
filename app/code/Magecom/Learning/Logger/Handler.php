<?php

namespace Magecom\Learning\Logger;

use Magento\Framework\Logger\Handler\Base;
use Monolog\Logger;

/**
 * Learning log handler
 *
 * @category Magecom
 * @package Magecom\Learning\Logger
 * @author  Magecom
 */
class Handler extends Base
{
    /**
     * Logging level
     * @var int
     */
    protected $loggerType = Logger::NOTICE;

    /**
     * File name
     * @var string
     */
    protected $fileName = '/var/log/learning.log';
}