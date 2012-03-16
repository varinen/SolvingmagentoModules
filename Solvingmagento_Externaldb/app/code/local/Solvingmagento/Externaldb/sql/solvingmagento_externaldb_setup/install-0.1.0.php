<?php

$this->startSetup();

$table = $this->getConnection()
    ->newTable($this->getTable('solvingmagento_externaldb/external_data'));

$table->addColumn(
    'id', 
    Varien_Db_Ddl_Table::TYPE_INTEGER,
    null,
    array(
        'identity'  =>  true,
        'primary'   =>  true     
    )
);
$table->addColumn(
    'created_at', 
    Varien_Db_Ddl_Table::TYPE_DATETIME,
    null,
    array(
        'nullable'  =>  false    
    )
)->addColumn(
    'name', 
    Varien_Db_Ddl_Table::TYPE_VARCHAR,
    255,
    array(
        'nullable'  =>  false    
    )

);


$this->getConnection()->createTable($table);

$this->endSetup();
?>
