<?php
/**
 * Copyright © 2016 ShopGo. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace ShopGo\DimensionalWeightAttributes\Block\Adminhtml\System\Config\DimensionalWeightAttributes;

class SetAttributes extends \Magento\Config\Block\System\Config\Form\Field
{
    /**
     * Set DWA Button Label
     *
     * @var string
     */
    protected $_buttonLabel = 'Set Attributes';

    /**
     * Set template to itself
     *
     * @return \Magento\Customer\Block\Adminhtml\System\Config\Validatevat
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        if (!$this->getTemplate()) {
            $this->setTemplate('system/config/dimensional_weight_attributes/set_attributes.phtml');
        }
        return $this;
    }

    /**
     * Get New URL Field Name
     *
     * @return string
     */
    public function getAttributeGroupsGetterAjaxUrl()
    {
        return $this->_urlBuilder->getUrl('shopgo_dwa/dimensionalweightattributes/getattributegroups');
    }

    /**
     * Unset some non-related element parameters
     *
     * @param \Magento\Framework\Data\Form\Element\AbstractElement $element
     * @return string
     */
    public function render(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        $element->unsScope()->unsCanUseWebsiteValue()->unsCanUseDefaultValue();
        return parent::render($element);
    }

    /**
     * Get the button and scripts contents
     *
     * @param \Magento\Framework\Data\Form\Element\AbstractElement $element
     * @return string
     */
    protected function _getElementHtml(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        $this->addData([
            'button_label' => __($this->_buttonLabel),
            'html_id' => $element->getHtmlId(),
            'ajax_url' => $this->_urlBuilder->getUrl('shopgo_dwa/dimensionalweightattributes/setattributes'),
        ]);

        return $this->_toHtml();
    }
}
