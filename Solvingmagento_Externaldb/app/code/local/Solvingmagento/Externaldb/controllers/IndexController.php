<?php

class Solvingmagento_Externaldb_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
        $externalDataWrite = Mage::getModel('solvingmagento_externaldb/externaldata');
        
        $externalDataWrite->setCreatedAt(date("Y-m-d H:i:s"));
        $externalDataWrite->setName('Name');
        $result = $externalDataWrite->save();
        
        $id = $result->getId();
        
        $externalDataRead = Mage::getModel('solvingmagento_externaldb/externaldata');
        $externalDataRead->load($id);
        
        echo '<pre>';
        print_r($externalDataRead->getData());
        echo '</pre>';
        
        
        
    }
}
?>
