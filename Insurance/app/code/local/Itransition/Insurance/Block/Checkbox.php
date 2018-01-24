<?php

class Itransition_Insurance_Block_Checkbox extends Mage_Core_Block_Template
{
    public function isModuleEnable()
    {
        $moduleEnabled = Mage::getStoreConfigFlag('insurance/settings/enabled');
        return $moduleEnabled;
    }

    public function getShippingMethods()
    {
        $methods = Mage::getSingleton('shipping/config')->getActiveCarriers();
        $shipMethods = array();
        foreach ($methods as $shippingCode => $shippingModel)
        {
            $shipMethods[] = $shippingCode;
        }
        return $shipMethods;
    }
}