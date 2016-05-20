<?php
/**
 * Copyright © 2016 ShopGo. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace ShopGo\DimensionalWeightAttributes\Model\System\Config\Source\Attribute;

use Magento\Framework\Option\ArrayInterface;
use Magento\Eav\Model\ResourceModel\Entity\Attribute\Set\Collection as AttributeSetCollection;
use Magento\Eav\Setup\EavSetupFactory;

class Set implements ArrayInterface
{
    /**
     * Attribute set collection
     *
     * @var AttributeSetCollection
     */
    protected $attributeSetCollection;

    /**
     * EAV setup factory
     *
     * @var EavSetupFactory
     */
    protected $eavSetupFactory;

    /**
     * @param AttributeSetCollection $attributeSetCollection
     * @param EavSetupFactory $eavSetupFactory
     */
    public function __construct(
        AttributeSetCollection $attributeSetCollection,
        EavSetupFactory $eavSetupFactory
    ) {
        $this->attributeSetCollection = $attributeSetCollection;
        $this->eavSetupFactory = $eavSetupFactory;
    }

    /**
     * {@inheritdoc}
     *
     * @codeCoverageIgnore
     */
    public function toOptionArray()
    {
        $entityTypeId = $this->eavSetupFactory->create()->getEntityTypeId(
            \Magento\Catalog\Model\Product::ENTITY
        );

        //@TODO: This is not the best way to implement this.
        // Because, the whole collection will be loaded
        // without any limiter or pager.
        // Will look for a better way to implement it, later.
        $attributeSets = $this->attributeSetCollection
            ->setEntityTypeFilter($entityTypeId)
            ->toOptionArray();

        $defaultOption = [
            [
                'value' => '',
                'label' => __('--Please Select--')
            ]
        ];

        $attributeSets = array_merge($defaultOption, $attributeSets);

        return $attributeSets;
    }
}
