<?php
/**
 * Mage_Core_Model_Resource_Setup
 */
$this->startSetup();

/*
 * get table object
 */
$table = $this->getConnection()->newTable(
        $this->getTable('solvingmagento_donwloadkeys/solvingmagento_downloadkey'));

$table->addColumn(
        'id',
        Varien_Db_Ddl_Table::TYPE_INTEGER,
        null,
        array(
            'identity'  =>  true,
            'primary'   =>  true,
            'auto_increment'    => true,
            'nullable'  => false
        )
    )->addColumn(
        'sku',
        Varien_Db_Ddl_Table::TYPE_VARCHAR,
        null,
        array(
            'nullable'  =>  false,
            'length'    => 32
        )
   )->addColumn(
        'date_added',
        Varien_Db_Ddl_Table::TYPE_DATE,
        null,
        array(
            'nullable'  =>  false
        )
    )->addColumn(
        'date_shipped',
        Varien_Db_Ddl_Table::TYPE_DATE,
        null,
        array(
            'nullable'  =>  true
        )
    )->addColumn(
        'active',
        Varien_Db_Ddl_Table::TYPE_INTEGER,
        null,
        array(
            'nullable'  =>  false,
            'default'   =>  1
        )
    )->addColumn(
        'keys_data',
        Varien_Db_Ddl_Table::TYPE_LONGVARCHAR,
        null,
        array(
            'nullable'  =>  true
        )
    );
 
$this->getConnection()->createTable($table);
$this->getConnection()->query(
    'alter table '.$this->getTable('solvingmagento_donwloadkeys/solvingmagento_downloadkey').
     ' modify column sku varchar(32)');
$this->getConnection()->query(
   'CREATE INDEX part_of_name ON '.
        $this->getTable('solvingmagento_donwloadkeys/solvingmagento_downloadkey').
        ' (sku)');

  
$this->endSetup();
?>