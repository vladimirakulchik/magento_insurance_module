<?php

class Itransition_Insurance_Model_Observer
{
    const ENABLED = 'enabled';
    const CHECKBOX = 'add_insurance';

    public function checkoutControllerOnepageSaveShippingMethod($observer)
    {
        $quote = $observer->getEvent()->getData('quote');
        $request = $observer->getEvent()->getData('request');
        $status = $request->getPost(self::CHECKBOX);

        $method = $quote->getShippingAddress()->getShippingMethod();
        $helper = Mage::helper('insurance');
        $method = $helper->getCorrectMethodName($method);

        if ($status === self::ENABLED) {
            $helper->updateInsuranceCost($method, $quote);
        } else {
            $quote->setInsurance(null);
        }
    }

    public function salesQuoteItemQtySetAfter($observer)
    {
        $quote = $observer->getEvent()->getData('item')->getQuote();
        $insurance = $quote->getInsurance();

        $method = $quote->getShippingAddress()->getShippingMethod();
        $helper = Mage::helper('insurance');
        $method = $helper->getCorrectMethodName($method);

        if (($method !== null) && ($insurance !== null)) {
            $helper->updateInsuranceCost($method, $quote);
        }
    }
}