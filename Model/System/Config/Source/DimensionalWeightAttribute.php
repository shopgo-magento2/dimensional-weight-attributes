<?php
/**
 * Copyright © 2016 ShopGo. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace ShopGo\DimensionalWeightAttributes\Model\System\Config\Source;

use Magento\Framework\Option\ArrayInterface;
use Magento\Catalog\Model\ResourceModel\Product\Attribute\CollectionFactory as ProductAttributeCollectionFactory;

class DimensionalWeightAttribute implements ArrayInterface
{
    /**
     * Product attribute collection
     *
     * @var ProductAttributeCollectionFactpry
     */
    protected $productAttributeCollectionFactory;

    /**
     * DB Helper
     *
     * @var \Magento\Framework\DB\Helper
     */
    protected $dbHelper;

    /**
     * Dimensional weight attribute name
     *
     * @var string
     */
    protected $attributeName;

    /**
     * @param ProductAttributeCollectionFactory $productAttributeCollectionFactory
     * @param \Magento\Framework\DB\Helper $dbHelper
     * @param string $attributeName
     */
    public function __construct(
        ProductAttributeCollectionFactory $productAttributeCollectionFactory,
        \Magento\Framework\DB\Helper $dbHelper,
        $attributeName = ''
    ) {
        $this->productAttributeCollectionFactory = $productAttributeCollectionFactory;
        $this->dbHelper = $dbHelper;
        $this->attributeName = $attributeName;
    }

    /**
     * {@inheritdoc}
     *
     * @codeCoverageIgnore
     */
    public function toOptionArray()
    {
        $likeExpression = [
            'like' => $this->dbHelper->addLikeEscape($this->attributeName, ['position' => 'any'])
        ];

        //@TODO: This is not the best way to implement this.
        // Because, the whole collection will be loaded
        // without any limiter or pager.
        // Will look for a better way to implement it, later.
        $heightAttributes = $this->productAttributeCollectionFactory->create()
            ->setEntityTypeFilter(\Magento\Catalog\Model\Product::ENTITY)
            ->addFieldToFilter('attribute_code', $likeExpression);

        $options = [
            [
                'value' => '',
                'label' => __('--Please Select--')
            ]
        ];

        foreach ($heightAttributes as $heightAttribute) {
            $options[] = [
                'value' => $heightAttribute->getAttributeCode(),
                'label' => $heightAttribute->getFrontendLabel() . ' (' . $heightAttribute->getAttributeCode() . ')'
            ];
        }

        return $options;
    }
}
