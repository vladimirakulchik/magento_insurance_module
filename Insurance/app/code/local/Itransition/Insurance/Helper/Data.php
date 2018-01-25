<?php

class Itransition_Insurance_Helper_Data extends Mage_Core_Helper_Abstract
{
    const INSURANCE_MODULE_ENABLED = 'insurance/settings/enabled';
    const MODULE_CONFIG = 'insurance/';
    const ENABLED = '/enabled';
    const VALUE = '/value';
    const TYPE = '/type';
    const ENABLE = '1';
    const DISABLE = '0';
    const PERCENT = 100;

    public function isInsuranceModuleEnable()
    {
        $state = Mage::getStoreConfig(self::INSURANCE_MODULE_ENABLED);
        return $state === self::ENABLE;
    }

    public function isShippingMethodEnable($method)
    {
        $state = Mage::getStoreConfig(self::MODULE_CONFIG . $method . self::ENABLED);
        return $state === self::ENABLE;
    }

    public function getTypeOfInsurance($method)
    {
        return Mage::getStoreConfig(self::MODULE_CONFIG . $method . self::TYPE);
    }

    public function getValueOfInsurance($method)
    {
        return Mage::getStoreConfig(self::MODULE_CONFIG . $method . self::VALUE);
    }

    public function getSubtotal()
    {
        $subtotal = Mage::getModel('checkout/session')->getQuote()->getSubtotal();
        return (double)$subtotal;
    }

    public function getInsuranceCost($method, $subtotal)
    {
        $insuranceTypeModel = Mage::getModel('insurance/source_type');
        $value = $this->getValueOfInsurance($method);
        $type = $this->getTypeOfInsurance($method);
        switch ($type) {
            case $insuranceTypeModel::ABSOLUTE_TYPE:
                $insuranceCost = (double)$value;
                break;
            case $insuranceTypeModel::PERCENT_TYPE:
                $insuranceCost = $subtotal * $value / self::PERCENT;
                break;
        }
        return $insuranceCost;
    }
}