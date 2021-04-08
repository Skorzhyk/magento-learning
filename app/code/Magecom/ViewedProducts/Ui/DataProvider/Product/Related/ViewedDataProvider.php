<?php

namespace Magecom\ViewedProducts\Ui\DataProvider\Product\Related;

use Magento\Catalog\Ui\DataProvider\Product\Related\AbstractDataProvider;

/**
 * Class ViewedDataProvider
 *
 * @api
 * @since 101.0.0
 */
class ViewedDataProvider extends AbstractDataProvider
{
    /**
     * {@inheritdoc}
     * @since 101.0.0
     */
    protected function getLinkType()
    {
        return 'viewed';
    }
}
