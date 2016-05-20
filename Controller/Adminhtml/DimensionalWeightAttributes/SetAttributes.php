<?php
/**
 * Copyright © 2016 ShopGo. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace ShopGo\DimensionalWeightAttributes\Controller\Adminhtml\DimensionalWeightAttributes;

use ShopGo\DimensionalWeightAttributes\Model\DimensionalWeightAttributes;

class SetAttributes extends \ShopGo\DimensionalWeightAttributes\Controller\Adminhtml\DimensionalWeightAttributes
{
    /**
     * Dimensional weight attributes model
     *
     * @var DimensionalWeightAttributes
     */
    protected $dwa;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param DimensionalWeightAttributes $dwa
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        DimensionalWeightAttributes $dwa
    ) {
        $this->dwa = $dwa;
        parent::__construct($context);
    }

    /**
     * Set dimensional weight attributes action
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

        if (empty($params['attribute_set'])) {
            $result['description'] = __(
                'Could not set dimensional weight attributes! Please select an attribute set.'
            );

            return $response->setBody(json_encode($result));
        }

        $setAttributesResult = $this->dwa->setAttributes(
            $params['attribute_set'],
            $params['attribute_group']
        );

        if ($setAttributesResult) {
            $result = [
                'status' => 1,
                'description' => __(
                    'Dimensional weight attributes have been set successfully. '
                    . 'The page will be refreshed once you close this message box.'
                )
            ];
        } else {
            $result['description'] = __(
                'Could not set dimensional weight attributes! Please try to set them manually.'
            );
        }

        $response->setBody(json_encode($result));
    }
}
