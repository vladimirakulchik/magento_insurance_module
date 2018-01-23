<?php

class Itransition_Insurance_Block_Checkbox extends Mage_Core_Block_Template
{
    public function isModuleEnable()
    {
        $moduleEnabled = Mage::getStoreConfigFlag('insurance/settings/enabled');
        var_dump($moduleEnabled);
        return $moduleEnabled;
    }
}