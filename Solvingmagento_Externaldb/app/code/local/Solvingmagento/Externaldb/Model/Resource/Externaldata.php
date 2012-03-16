<?php

class Solvingmagento_Externaldb_Model_Resource_Externaldata extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        $this->_init('solvingmagento_externaldb/external_data', 'id');
    }
}
?>
