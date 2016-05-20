<?php
/**
 * Copyright © 2016 ShopGo. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace ShopGo\DimensionalWeightAttributes\Model\System\Config\Source\Attribute;

use Magento\Eav\Model\ResourceModel\Entity\Attribute\Group\Collection as AttributeGroupCollection;

class Group
{
    /**
     * Dimensional weight attributes attribute set XML path
     */
    const XML_PATH_ATTRIBUTE_SET = 'dimensional_weight_attributes/general/attribute_set';

    /**
     * Attribute group collection
     *
     * @var AttributeGroupCollection
     */
    protected $attributeGroupCollection;

    /**
     * Shipping Core Helper Data
     *
     * @var \ShopGo\ShippingCore\Helper\Data
     */
    protected $helper;

    /**
     * @param AttributeGroupCollection $attributeGroupCollection
     * @param \ShopGo\DimensionalWeightAttributes\Helper\Data $helper
     */
    public function __construct(
        AttributeGroupCollection $attributeGroupCollection,
        \ShopGo\DimensionalWeightAttributes\Helper\Data $helper
    ) {
        $this->attributeGroupCollection = $attributeGroupCollection;
        $this->helper = $helper;
    }

    /**
     * Get attribute groups options
     *
     * @param int $attributeSet
     * @return array
     * @codeCoverageIgnore
     */
    public function toOptionArray($attributeSet = null)
    {
        $attributeGroups = [
            [
                'value' => '',
                'label' => __('--Not Specified--')
            ]
        ];

        if (empty($attributeSet)) {
            $attributeSet = $this->helper->getConfig()->getValue(self::XML_PATH_ATTRIBUTE_SET);

            if (empty($attributeSet)) {
                return $attributeGroups;
            }
        }

        //@TODO: This is not the best way to implement this.
        // Because, the whole collection will be loaded
        // without any limiter or pager.
        // Will look for a better way to implement it, later.
        $attributeGroupsCollection = $this->attributeGroupCollection
            ->setAttributeSetFilter($attributeSet)
            ->setSortOrder()
            ->getItems();

        foreach ($attributeGroupsCollection as $attributeGroup) {
            $attributeGroups[] = [
                'value' => $attributeGroup->getAttributeGroupName(),
                'label' => $attributeGroup->getAttributeGroupName()
            ];
        }

        return $attributeGroups;
    }
}
