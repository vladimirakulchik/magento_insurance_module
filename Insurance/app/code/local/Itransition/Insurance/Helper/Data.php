<?php

class Itransition_Insurance_Helper_Data extends Mage_Core_Helper_Abstract
{
    const CONF_PATH_ENABLED = 'insurance/settings/enabled';
    const CONF_PATH_MODULE = 'insurance/';
    const CONF_PATH_INSURANCE_ENABLED = '/enabled';
    const CONF_PATH_INSURANCE_VALUE = '/value';
    const CONF_PATH_INSURANCE_TYPE = '/type';
    const ENABLED = '1';
    const DISABLED = '0';
    const INSURANCE_LABEL = 'Insurance';

    public function isInsuranceModuleEnable()
    {
        return Mage::getStoreConfig(self::CONF_PATH_ENABLED) === self::ENABLED;
    }

    public function isShippingMethodEnable($method)
    {
        return Mage::getStoreConfig(self::CONF_PATH_MODULE . $method . self::CONF_PATH_INSURANCE_ENABLED) === self::ENABLED;
    }

    public function getTypeOfInsurance($method)
    {
        return Mage::getStoreConfig(self::CONF_PATH_MODULE . $method . self::CONF_PATH_INSURANCE_TYPE);
    }

    public function getValueOfInsurance($method)
    {
        return Mage::getStoreConfig(self::CONF_PATH_MODULE . $method . self::CONF_PATH_INSURANCE_VALUE);
    }

    public function getSubtotal()
    {
        return (double)Mage::getModel('checkout/session')->getQuote()->getSubtotal();
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
                $insuranceCost = $subtotal * $value / 100;
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
        return $insurance !== null;
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

    public function getShippingMethod($quote)
    {
        $method = $quote->getShippingAddress()->getShippingMethod();

        return $this->getCorrectMethodName($method);
    }
}