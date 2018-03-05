<?php

namespace Magecom\ViewedProducts\Plugin\Session;

class SessionManager
{
    public function afterStart(\Magento\Framework\Session\SessionManager $subject)
    {
        if (!$subject->getSessionStartTime()) {
            $subject->setSessionStartTime(date('Y-m-d H:i:s'));
        }
    }
}