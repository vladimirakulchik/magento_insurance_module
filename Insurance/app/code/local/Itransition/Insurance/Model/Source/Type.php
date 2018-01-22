<?php

class Itransition_Insurance_Model_Source_Type
{
    const ABSOLUTE_TYPE = 0;
    const PERCENT_TYPE = 1;
    const ABSOLUTE_TYPE_LABEL = 'Absolute value';
    const PERCENT_TYPE_LABEL = 'Percent from order cost';

    public function toOptionArray()
    {
        return array(
            array(
                'value' => self::ABSOLUTE_TYPE,
                'label'=>Mage::helper('insurance')->__(self::ABSOLUTE_TYPE_LABEL)
            ),
            array(
                'value' => self::PERCENT_TYPE,
                'label'=>Mage::helper('insurance')->__(self::PERCENT_TYPE_LABEL)
            ),
        );
    }

    public function toArray()
    {
        return array(
            self::ABSOLUTE_TYPE => Mage::helper('insurance')->__(self::ABSOLUTE_TYPE_LABEL),
            self::PERCENT_TYPE => Mage::helper('insurance')->__(self::PERCENT_TYPE_LABEL),
        );
    }
}
