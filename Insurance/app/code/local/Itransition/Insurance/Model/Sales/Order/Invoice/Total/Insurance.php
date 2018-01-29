<?php

class Itransition_Insurance_Model_Sales_Order_Invoice_Total_Insurance extends Mage_Sales_Model_Order_Invoice_Total_Abstract
{
    public function collect(Mage_Sales_Model_Order_Invoice $invoice)
    {
        $order = $invoice->getOrder();
        $helper = Mage::helper('insurance');
        $insurance = $order->getInsurance();
        if ($helper->isAddInsurance($insurance)) {
            $invoice->setGrandTotal($invoice->getGrandTotal() + $insurance);
            $invoice->setBaseGrandTotal($invoice->getBaseGrandTotal() + $insurance);
        }
        return $this;
    }
}