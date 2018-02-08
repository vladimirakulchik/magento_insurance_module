<?php

class Itransition_Insurance_Block_Adminhtml_Order_Invoice_Totals extends Mage_Sales_Block_Order_Invoice_Totals
{
    protected $_code = 'insurance';

    protected function _initTotals()
    {
        parent::_initTotals();
        Mage::helper('insurance')->addInsuranceToTotals($this);

        return $this;
    }
}