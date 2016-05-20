<?php
/**
 * Copyright © 2016 ShopGo. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace ShopGo\DimensionalWeightAttributes\Controller\Adminhtml;

/**
 * Dimensional weight attributes controller
 */
abstract class DimensionalWeightAttributes extends \Magento\Backend\App\Action
{
    /**
     * Check the permission to run it
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('ShopGo_DimensionalWeightAttributes::config_dimensional_weight_attributes');
    }
}
