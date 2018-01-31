<?php

class Itransition_Insurance_Model_Sales_Order_Pdf_Total_Insurance extends Mage_Sales_Model_Order_Pdf_Total_Default
{
    public function getTotalsForDisplay()
    {
        $result = array();
        $insurance = $this->getOrder()->getInsurance();
        $helper = Mage::helper('insurance');

        if ($helper->isAddInsurance($insurance)) {
            $result[] = array(
              'amount' => sprintf('%.2f', $insurance),
              'label' => $helper->__($helper::INSURANCE_LABEL),
              'font_size' => $this->getFontSize()
            );
        }

        return $result;
    }
}