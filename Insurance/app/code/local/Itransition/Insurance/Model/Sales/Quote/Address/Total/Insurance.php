<?php

class Itransition_Insurance_Model_Sales_Quote_Address_Total_Insurance extends Mage_Sales_Model_Quote_Address_Total_Abstract
{
    protected $_code = 'insurance';

    public function collect(Mage_Sales_Model_Quote_Address $address)
    {
        parent::collect($address);

        $this->_setAmount(0);
        $this->_setBaseAmount(0);
        $items = $this->_getAddressItems($address);

        if (!count($items)) {
            return $this;
        }

        $quote = $address->getQuote();
        $insurance = $quote->getInsurance();
        $helper = Mage::helper('insurance');

        if ($helper->isAddInsurance($insurance)) {
            $address->setGrandTotal($address->getGrandTotal() + $insurance);
            $address->setBaseGrandTotal($address->getBaseGrandTotal() + $insurance);
        }

        return $this;
    }

    public function fetch(Mage_Sales_Model_Quote_Address $address)
    {
        $items = $this->_getAddressItems($address);

        if (!count($items)) {
            return $this;
        }

        $quote = $address->getQuote();
        $insurance = $quote->getInsurance();
        $helper = Mage::helper('insurance');

        if ($helper->isAddInsurance($insurance)) {
            $address->addTotal(array(
                'code' => $this->getCode(),
                'title' => $helper->__($helper::INSURANCE_LABEL),
                'value' => $insurance
            ));
        }

        return $this;
    }
}