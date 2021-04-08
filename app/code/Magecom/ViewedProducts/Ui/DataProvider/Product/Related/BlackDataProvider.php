<?php

namespace Magecom\ViewedProducts\Ui\DataProvider\Product\Related;

use Magento\Catalog\Ui\DataProvider\Product\Related\AbstractDataProvider;

/**
 * Class BlackDataProvider
 *
 * @api
 * @since 101.0.0
 */
class BlackDataProvider extends AbstractDataProvider
{
    /**
     * {@inheritdoc}
     * @since 101.0.0
     */
    protected function getLinkType()
    {
        return 'black';
    }
}
