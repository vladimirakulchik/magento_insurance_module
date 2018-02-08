<?php

class Itransition_Insurance_Block_Checkout_Onepage_Customstep extends Mage_Checkout_Block_Onepage_Abstract
{
    protected function _construct()
    {
        $this->getCheckout()->setStepData(
            'customstep',
            array(
                'label'     => Mage::helper('insurance')->__('Insurance'),
                'is_show'   => $this->isShow()
            )
        );

        parent::_construct();
    }

    public function isModuleEnable()
    {
        return Mage::helper('insurance')->isInsuranceModuleEnable();
    }

    public function getShippingMethod()
    {
        return Mage::helper('insurance')->getShippingMethod($this->getQuote());
    }

    public function isShippingMethodEnable($method)
    {
        return Mage::helper('insurance')->isShippingMethodEnable($method);
    }

    public function getInsuranceCost($method)
    {
        $helper = Mage::helper('insurance');
        $subtotal = $helper->getSubtotal();

        return $helper->getInsuranceCost($method, $subtotal);
    }
}