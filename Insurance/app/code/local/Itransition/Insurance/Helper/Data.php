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
    const INSURANCE_LABEL = 'Insurance';

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

    public function updateInsuranceCost($method, $quote)
    {
        if (($this->isInsuranceModuleEnable()) &&
                ($this->isShippingMethodEnable($method))) {
            $insuranceCost = $this->getInsuranceCost($method, $quote->getSubtotal());
            $quote->setInsurance($insuranceCost);
        } else {
            $quote->setInsurance(null);
        }
    }

    public function isAddInsurance($insurance)
    {
        return $insurance != null;
    }

    public function addInsuranceToTotals($block)
    {
        $insurance = $block->getOrder()->getInsurance();
        if ($this->isAddInsurance($insurance)) {
            $block->addTotal(new Varien_Object(array(
                'code' => $block->getCode(),
                'value' => $insurance,
                'base_value' => $insurance,
                'label' => $this->__(self::INSURANCE_LABEL)
            )));
        }
    }

    public function getCorrectMethodName($method)
    {
        return explode('_', $method)[0];
    }
}