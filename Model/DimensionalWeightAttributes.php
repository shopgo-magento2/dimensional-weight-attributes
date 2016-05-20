<?php
/**
 * Copyright © 2016 ShopGo. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace ShopGo\DimensionalWeightAttributes\Model;

use Magento\Eav\Setup\EavSetupFactory;
use Magento\Catalog\Model\Product\Type as ProductType;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;

/**
 * Dimensional Weight Attributes model
 */
class DimensionalWeightAttributes
{
    /**
     * Dimensional weight attributes XML paths
     */
    const XML_PATH_ATTRIBUTE_LENGTH = 'dimensional_weight_attributes/general/length';
    const XML_PATH_ATTRIBUTE_WIDTH  = 'dimensional_weight_attributes/general/width';
    const XML_PATH_ATTRIBUTE_HEIGHT = 'dimensional_weight_attributes/general/height';

    /**
     * Default attribute group
     */
    const DEFAULT_ATTRIBUTE_GROUP = 'Product Details';

    /**
     * Dimensional weight attributes codes and labels
     */
    const ATTRIBUTE_LENGTH_CODE  = 'length';
    const ATTRIBUTE_LENGTH_LABEL = 'Length';
    const ATTRIBUTE_WIDTH_CODE   = 'width';
    const ATTRIBUTE_WIDTH_LABEL  = 'Width';
    const ATTRIBUTE_HEIGHT_CODE  = 'height';
    const ATTRIBUTE_HEIGHT_LABEL = 'Height';

    /**
     * EAV setup factory
     *
     * @var EavSetupFactory
     */
    protected $eavSetupFactory;

    /**
     * Module data setup
     *
     * @var \Magento\Setup\Module\DataSetup
     */
    protected $setup;

    /**
     * EAV config
     *
     * @var \Magento\Eav\Model\Config
     */
    protected $eavConfig;

    /**
     * Attribute group
     *
     * @var \Magento\Eav\Model\Entity\Attribute\Group
     */
    protected $attributeGroupFactory;

    /**
     * Shipping Core Helper Data
     *
     * @var \ShopGo\ShippingCore\Helper\Data
     */
    protected $helper;

    /**
     * Dimensional weight attributes data
     *
     * @var array
     */
    protected $attributes = [
        [
            'code'  => self::ATTRIBUTE_LENGTH_CODE,
            'label' => self::ATTRIBUTE_LENGTH_LABEL,
            'config_xpath' => self::XML_PATH_ATTRIBUTE_LENGTH
        ],
        [
            'code'  => self::ATTRIBUTE_WIDTH_CODE,
            'label' => self::ATTRIBUTE_WIDTH_LABEL,
            'config_xpath' => self::XML_PATH_ATTRIBUTE_WIDTH
        ],
        [
            'code'  => self::ATTRIBUTE_HEIGHT_CODE,
            'label' => self::ATTRIBUTE_HEIGHT_LABEL,
            'config_xpath' => self::XML_PATH_ATTRIBUTE_HEIGHT
        ]
    ];

    /**
     * @param EavSetupFactory $eavSetupFactory
     * @param \Magento\Setup\Module\DataSetup $setup
     * @param \Magento\Eav\Model\Config $eavConfig
     * @param \Magento\Eav\Model\Entity\Attribute\GroupFactory $attributeGroupFactory
     * @param \ShopGo\DimensionalWeightAttributes\Helper\Data $helper
     */
    public function __construct(
        EavSetupFactory $eavSetupFactory,
        \Magento\Setup\Module\DataSetup $setup,
        \Magento\Eav\Model\Config $eavConfig,
        \Magento\Eav\Model\Entity\Attribute\GroupFactory $attributeGroupFactory,
        \ShopGo\DimensionalWeightAttributes\Helper\Data $helper
    ) {
        $this->eavSetupFactory = $eavSetupFactory;
        $this->setup = $setup;
        $this->eavConfig = $eavConfig;
        $this->attributeGroupFactory = $attributeGroupFactory;
        $this->helper = $helper;
    }

    /**
     * Add attribute
     *
     * @param array $data
     * @param string|int $attributeSet
     * @param string $attributeGroup
     * @param EavSetup|null $eavSetup
     * @return bool
     */
    protected function addAttribute(
        $data,
        $attributeSet = '',
        $attributeGroup = '',
        $eavSetup = null
    ) {
        $result = true;
        $entityTypeId = \Magento\Catalog\Model\Product::ENTITY;

        if (is_numeric($attributeGroup)) {
            $attributeGroupModel = $this->attributeGroupFactory->create()->load($attributeGroup);
            $attributeGroup = $attributeGroupModel->getAttributeGroupName();
        }
        if (!$attributeGroup) {
            $attributeGroup = self::DEFAULT_ATTRIBUTE_GROUP;
        }

        $attribute = $this->eavConfig->getAttribute($entityTypeId, $data['code']);

        if ($attribute->getAttributeId()) {
            $this->helper->getConfig()->setValue($data['config_xpath'], $data['code']);

            return $result;
        }

        if (!$eavSetup) {
            /** @var \Magento\Eav\Setup\EavSetup $eavSetup */
            $eavSetup = $this->eavSetupFactory->create(['setup' => $this->setup]);
        }

        $productTypes = [
            ProductType::TYPE_SIMPLE,
            ProductType::TYPE_BUNDLE
        ];
        $productTypes = join(',', $productTypes);

        $attributeData = [
            'type' => 'decimal',
            'label' => $data['label'],
            'input' => 'text',
            'required' => false,
            'global' => ScopedAttributeInterface::SCOPE_GLOBAL,
            'frontend_class' => 'validate-number',
            'used_for_promo_rules' => true,
            'comparable' => true,
            'system' => false,
            'user_defined' => true,
            'visible' => true,
            'apply_to' => $productTypes
        ];

        if (!$attributeSet) {
            $attributeData['group'] = $attributeGroup;
        }

        try {
            $eavSetup->addAttribute($entityTypeId, $data['code'], $attributeData);

            if ($attributeSet) {
                $eavSetup->addAttributeGroup($entityTypeId, $attributeSet, $attributeGroup);
                $eavSetup->addAttributeToSet(
                    $entityTypeId,
                    $attributeSet,
                    $attributeGroup,
                    $data['code']
                );
            }

            $this->helper->getConfig()->setValue($data['config_xpath'], $data['code']);
        } catch (\Exception $e) {
            $result = false;
        }

        return $result;
    }

    /**
     * Set dimensional weight attributes
     *
     * @param string|int $attributeSet
     * @param string $attributeGroup
     * @param \Magento\Framework\Setup\InstallDataInterface|null $eavSetup
     * @return bool
     */
    public function setAttributes(
        $attributeSet = '',
        $attributeGroup = '',
        $eavSetup = null
    ) {
        $result = true;

        foreach ($this->attributes as $attributeData) {
            $result = $result & $this->addAttribute(
                $attributeData,
                $attributeSet,
                $attributeGroup,
                $eavSetup
            );
        }

        return $result;
    }

    /**
     * Get dimensional weight attributes
     *
     * @return array
     */
    public function getAttributes()
    {
        foreach ($this->attributes as $i => $attribute) {
            $this->attributes[$i]['config_value'] = $this->helper->getConfig()->getValue(
                $attribute['config_xpath']
            );
        }

        return $this->attributes;
    }
}
