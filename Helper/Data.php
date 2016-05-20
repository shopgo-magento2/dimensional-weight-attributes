<?php
/**
 * Copyright © 2016 ShopGo. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace ShopGo\DimensionalWeightAttributes\Helper;

use ShopGo\DimensionalWeightAttributes\Model\DimensionalWeightAttributesFactory;

class Data extends \ShopGo\Core\Helper\AbstractHelper
{
    /**
     * @var DimensionalWeightAttributesFactory
     */
    protected $dimensionalWeightAttributesFactory;

    /**
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \ShopGo\Core\Helper\Utility $utility
     * @param DimensionalWeightAttributesFactory $dimensionalWeightAttributesFactory
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \ShopGo\Core\Helper\Utility $utility,
        DimensionalWeightAttributesFactory $dimensionalWeightAttributesFactory
    ) {
        $this->dimensionalWeightAttributesFactory = $dimensionalWeightAttributesFactory;
        parent::__construct($context, $utility);
    }

    /**
     * Get dimensional weight attributes codes
     *
     * @return array
     */
    public function getDimensionalWeightAttributes()
    {
        $result = [];
        $dwa = $this->dimensionalWeightAttributesFactory->create();
        $attributes = $dwa->getAttributes();

        foreach ($attributes as $attribute) {
            $result[$attribute['code']] = $attribute['config_value'];
        }

        return $result;
    }
}
