<?php

class Solvingmagento_Downloadkeys_Model_Resource_Downloadkey extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        $this->_init('solvingmagento_donwloadkeys/downloadkeys', 'id');
    }
}
?>
