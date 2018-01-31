<?php

class Itransition_Insurance_Model_Sales_Order_Creditmemo_Total_Insurance extends Mage_Sales_Model_Order_Creditmemo_Total_Abstract
{
    public function collect(Mage_Sales_Model_Order_Creditmemo $creditmemo)
    {
        $order = $creditmemo->getOrder();
        $helper = Mage::helper('insurance');
        $insurance = $order->getInsurance();

        if ($helper->isAddInsurance($insurance)) {
            $creditmemo->setGrandTotal($creditmemo->getGrandTotal() + $insurance);
            $creditmemo->setBaseGrandTotal($creditmemo->getBaseGrandTotal() + $insurance);
        }

        return $this;
    }
}