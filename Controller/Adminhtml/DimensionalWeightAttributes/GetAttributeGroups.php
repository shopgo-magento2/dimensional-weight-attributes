<?php
/**
 * Copyright © 2016 ShopGo. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace ShopGo\DimensionalWeightAttributes\Controller\Adminhtml\DimensionalWeightAttributes;

use ShopGo\DimensionalWeightAttributes\Model\DimensionalWeightAttributes;
use ShopGo\DimensionalWeightAttributes\Model\System\Config\Source\Attribute\Group as AttributeGroupSource;

class GetAttributeGroups extends \ShopGo\DimensionalWeightAttributes\Controller\Adminhtml\DimensionalWeightAttributes
{
    /**
     * Dimensional weight attributes model
     *
     * @var DimensionalWeightAttributes
     */
    protected $dwa;

    /**
     * Attribute group source model
     *
     * @var AttributeGroupSource
     */
    protected $attributeGroupSource;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param DimensionalWeightAttributes $dwa
     * @param AttributeGroupSource $attributeGroupSource
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        DimensionalWeightAttributes $dwa,
        AttributeGroupSource $attributeGroupSource
    ) {
        $this->dwa = $dwa;
        $this->attributeGroupSource = $attributeGroupSource;
        parent::__construct($context);
    }

    /**
     * Get dimensional weight attribute set groups action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $params = $this->getRequest()->getParams();
        $response = $this->getResponse()->setHeader(
            'content-type',
            'application/json; charset=utf-8'
        );

        $result = [
            'status' => 0,
            'description' => __('An unknown error has occurred! Please report this issue to the module author.')
        ];

        if (!isset($params['attribute_set'])) {
            $result['description'] = __('Could not retrieve attribute groups! Please specify an attribute set.');
            $response->setBody(json_encode($result));

            return;
        }

        $attributeGroups = $this->attributeGroupSource->toOptionArray($params['attribute_set']);

        if (!empty($attributeGroups)) {
            $result = [
                'status' => 1,
                'description' => __('Attribute groups list has been retrieved successfully.'),
                'data' => $attributeGroups
            ];
        } else {
            $result['description'] = __('Could not retrieve the attribute groups for the specified attribute set!');
        }

        $response->setBody(json_encode($result));
    }
}
