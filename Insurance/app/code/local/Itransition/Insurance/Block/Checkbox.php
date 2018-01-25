<?php

class Itransition_Insurance_Block_Checkbox extends Mage_Core_Block_Template
{
    public function isModuleEnable()
    {
        return Mage::helper('insurance')->isInsuranceModuleEnable();
    }

    public function getShippingMethods()
    {
        $helper = Mage::helper('insurance');
        $shipMethods = array();
        $methods = Mage::getSingleton('shipping/config')->getActiveCarriers();
        foreach ($methods as $shippingCode => $shippingModel) {
            if ($helper->isShippingMethodEnable($shippingCode)) {
                $shipMethods[] = $shippingCode;
            }
        }
        return $shipMethods;
    }

    public function getInsuranceCost($method)
    {
        $helper = Mage::helper('insurance');
        $subtotal = $helper->getSubtotal();
        return $helper->getInsuranceCost($method, $subtotal);
    }
}