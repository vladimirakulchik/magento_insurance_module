<?php

class Itransition_Insurance_Model_Checkout_Type_Onepage extends Mage_Checkout_Model_Type_Onepage
{
    const ENABLED = 'enabled';

    public function saveInsurance($data)
    {
        $helper = Mage::helper('insurance');
        $quote = $this->getQuote();
        $method = $helper->getShippingMethod($quote);

        if ($data === self::ENABLED) {
            $helper->updateInsuranceCost($method, $quote);
        } else {
            $quote->setInsurance(null);
        }

        $quote->save();

        $this->getCheckout()
            ->setStepData('insurance', 'allow', true)
            ->setStepData('insurance', 'complete', true)
            ->setStepData('payment', 'allow', true);

        return array();
    }
}