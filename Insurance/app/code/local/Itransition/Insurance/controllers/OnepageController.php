<?php
require_once 'Mage/Checkout/controllers/OnepageController.php';

class Itransition_Insurance_OnepageController extends Mage_Checkout_OnepageController
{
    const CHECKBOX = 'add_insurance';

    public function saveCustomStepAction(){
        if ($this->_expireAjax()) {
            return;
        }

        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getPost(self::CHECKBOX);
            $result = $this->getOnepage()->saveCustomStep($data);

            if (!isset($result['error'])) {
                $result['goto_section'] = 'payment';
                $result['update_section'] = array(
                    'name' => 'payment-method',
                    'html' => $this->_getPaymentMethodsHtml()
                );
            }
            $this->_prepareDataJSON($result);
        }
    }

    public function saveShippingMethodAction()
    {
        if ($this->_expireAjax()) {
            return;
        }

        if ($this->isFormkeyValidationOnCheckoutEnabled() && !$this->_validateFormKey()) {
            return;
        }

        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getPost('shipping_method', '');
            $result = $this->getOnepage()->saveShippingMethod($data);

            if (!$result) {
                Mage::dispatchEvent(
                    'checkout_controller_onepage_save_shipping_method',
                    array(
                        'request' => $this->getRequest(),
                        'quote'   => $this->getOnepage()->getQuote()
                    )
                );
                $this->getOnepage()->getQuote()->collectTotals();
                $this->_prepareDataJSON($result);

                $result['goto_section'] = 'customstep';
                $result['update_section'] = array(
                    'name' => 'customstep',
                    'html' => $this->_getCustomstepHtml()
                );
            }
            $this->getOnepage()->getQuote()->collectTotals()->save();
            $this->_prepareDataJSON($result);
        }
    }

    protected function _getCustomstepHtml()
    {
        $layout = $this->getLayout();
        $update = $layout->getUpdate();
        $update->load('checkout_onepage_customstep');
        $layout->generateXml();
        $layout->generateBlocks();
        $output = $layout->getOutput();

        return $output;
    }
}