<?php

$installer = $this;
$installer->startSetup();
$installer->getConnection()
    ->addColumn(
        $installer->getTable('sales/quote'),
        'insurance',
        array(
            'type' => Varien_Db_Ddl_Table::TYPE_DECIMAL,
            'nullable' => true,
            'scale' => 4,
            'precision' => 12,
            'comment' => 'Insurance'
        )
    );
$installer->getConnection()
    ->addColumn(
        $installer->getTable('sales/order'),
        'insurance',
        array(
            'type' => Varien_Db_Ddl_Table::TYPE_DECIMAL,
            'nullable' => true,
            'scale' => 4,
            'precision' => 12,
            'comment' => 'Insurance'
        )
    );
$installer->endSetup();
