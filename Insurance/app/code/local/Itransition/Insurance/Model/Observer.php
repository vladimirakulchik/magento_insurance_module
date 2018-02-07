<?php

class Itransition_Insurance_Model_Observer
{
    public function salesQuoteItemQtySetAfter($observer)
    {
        $quote = $observer->getEvent()->getData('item')->getQuote();
        $insurance = $quote->getInsurance();

        $helper = Mage::helper('insurance');
        $method = $helper->getShippingMethod($quote);

        if (($method !== null) && ($insurance !== null)) {
            $helper->updateInsuranceCost($method, $quote);
        }
    }
}