<?php

namespace Magecom\ViewedProducts\Ui\DataProvider\Product\Form\Modifier;

use Magento\Ui\Component\Form\Fieldset;
use Magento\Catalog\Ui\DataProvider\Product\Form\Modifier\Related as UiRelated;

class Related extends UiRelated
{
    const DATA_SCOPE_VIEWED = 'viewed';

    const DATA_SCOPE_BLACK = 'black';

    /**
     * @var string
     */
    private static $previousGroup = 'search-engine-optimization';

    /**
     * @var int
     */
    private static $sortOrder = 90;

    public function modifyMeta(array $meta)
    {
        $meta = array_replace_recursive(
            $meta,
            [
                static::GROUP_RELATED => [
                    'children' => [
                        $this->scopePrefix . static::DATA_SCOPE_RELATED => $this->getRelatedFieldset(),
                        $this->scopePrefix . static::DATA_SCOPE_UPSELL => $this->getUpSellFieldset(),
                        $this->scopePrefix . static::DATA_SCOPE_CROSSSELL => $this->getCrossSellFieldset(),
                        $this->scopePrefix . static::DATA_SCOPE_VIEWED => $this->getViewedFieldset(),
                        $this->scopePrefix . static::DATA_SCOPE_BLACK => $this->getBlackFieldset(),
                    ],
                    'arguments' => [
                        'data' => [
                            'config' => [
                                'label' => __('Related Products, Up-Sells, Cross-Sells and Viewed'),
                                'collapsible' => true,
                                'componentType' => Fieldset::NAME,
                                'dataScope' => static::DATA_SCOPE,
                                'sortOrder' =>
                                    $this->getNextGroupSortOrder(
                                        $meta,
                                        self::$previousGroup,
                                        self::$sortOrder
                                    ),
                            ],
                        ],

                    ],
                ],
            ]
        );

        return $meta;
    }

    protected function getDataScopes()
    {
        return [
            static::DATA_SCOPE_RELATED,
            static::DATA_SCOPE_CROSSSELL,
            static::DATA_SCOPE_UPSELL,
            static::DATA_SCOPE_VIEWED,
            static::DATA_SCOPE_BLACK
        ];
    }

    /**
     * Prepares config for the Viewed products fieldset
     *
     * @return array
     * @since 101.0.0
     */
    protected function getViewedFieldset()
    {
        $content = __(
            'Viewed products are shown to customers in addition to the item the customer is looking at.'
        );

        return [
            'children' => [
                'description' => [
                    'arguments' => [
                        'data' => [
                            'config' => [
                                'formElement' => 'container',
                                'componentType' => 'container',
                                'label' => false,
                                'content' => $content,
                                'template' => 'ui/form/components/complex',
                            ],
                        ],
                    ]
                ],
                static::DATA_SCOPE_VIEWED => $this->getGrid($this->scopePrefix . static::DATA_SCOPE_VIEWED),
            ],
            'arguments' => [
                'data' => [
                    'config' => [
                        'additionalClasses' => 'admin__fieldset-section',
                        'label' => __('Viewed Products'),
                        'collapsible' => false,
                        'componentType' => Fieldset::NAME,
                        'dataScope' => '',
                        'sortOrder' => 5,
                    ],
                ],
            ]
        ];
    }

    /**
     * Prepares config for the Black products fieldset
     *
     * @return array
     * @since 101.0.0
     */
    protected function getBlackFieldset()
    {
        $content = __(
            'Products are not displaying as Viewed with current product.'
        );

        return [
            'children' => [
                'button_set' => $this->getButtonSet(
                    $content,
                    __('Add Products to Blacklist'),
                    $this->scopePrefix . static::DATA_SCOPE_BLACK
                ),
                'modal' => $this->getGenericModal(
                    __('Add Products to Blacklist'),
                    $this->scopePrefix . static::DATA_SCOPE_BLACK
                ),
                static::DATA_SCOPE_BLACK => $this->getGrid($this->scopePrefix . static::DATA_SCOPE_BLACK),
            ],
            'arguments' => [
                'data' => [
                    'config' => [
                        'additionalClasses' => 'admin__fieldset-section',
                        'label' => __('Viewed Blacklist'),
                        'collapsible' => false,
                        'componentType' => Fieldset::NAME,
                        'dataScope' => '',
                        'sortOrder' => 7,
                    ],
                ],
            ]
        ];
    }
}