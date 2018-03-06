<?php

namespace Magecom\ViewedProducts\Model\Product;

use Magento\Catalog\Model\Product\Link as ProductLink;

class Link extends ProductLink
{
    const LINK_TYPE_VIEWED = 6;

    const LINK_TYPE_BLACK = 7;

    /**
     * @return $this
     */
    public function useViewedLinks()
    {
        $this->setLinkTypeId(self::LINK_TYPE_VIEWED);

        return $this;
    }

    /**
     * @return $this
     */
    public function useBlackLinks()
    {
        $this->setLinkTypeId(self::LINK_TYPE_BLACK);

        return $this;
    }
}
