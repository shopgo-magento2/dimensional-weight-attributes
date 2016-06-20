<?php
/**
 * Copyright © 2016 ShopGo. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace ShopGo\DimensionalWeightAttributes\Setup;

use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

/**
 * @codeCoverageIgnore
 */
class InstallData implements InstallDataInterface
{
    /**
     * EAV setup factory
     *
     * @var EavSetupFactory
     */
    private $eavSetupFactory;

    /**
     * Dimensional weight attributes model
     *
     * @var \ShopGo\DimensionalWeightAttributes\Model\DimensionalWeightAttributes
     */
    private $dimensionalWeightAttributes;

    /**
     * @param EavSetupFactory $eavSetupFactory
     */
    public function __construct(
        EavSetupFactory $eavSetupFactory,
        \ShopGo\DimensionalWeightAttributes\Model\DimensionalWeightAttributes $dimensionalWeightAttributes
    ) {
        $this->eavSetupFactory = $eavSetupFactory;
        $this->dimensionalWeightAttributes = $dimensionalWeightAttributes;
    }

    /**
     * {@inheritdoc}
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        /** @var EavSetup $eavSetup */
        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);

        // Set dimensional weight attributes
        $this->dimensionalWeightAttributes->setAttributes('', '', $eavSetup);
    }
}
