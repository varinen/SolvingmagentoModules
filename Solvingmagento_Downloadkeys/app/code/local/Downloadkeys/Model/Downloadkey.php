<?php

class Solvingmagento_Downloadkeys_Model_Downloadkey extends Mage_Core_Model_Abstract
{
    protected function _construct() 
    {
        $this->_init('solvingmagento_donwloadkeys/downloadkey');
    }
    
    public static function populateKeyParts($data) 
    {
        $keys = $data['keys'];
        $captions = $data['caption'];
        
        $keyParts = array();
        
        foreach ($keys as $key=>$value) {
            $notRefined = explode("\n", $value);
            $refined = array();
            foreach ($notRefined as $entry) {
                if (strlen(trim($entry))) {
                    $refined[] = trim($entry);
                }
            }
            $partCaption = trim($captions[$key]);
            $keyParts[] =  array(
                'part_num'      =>  ($key+1),
                'caption'       =>  $partCaption,
                'key_entries'   =>  $refined
            );
        }
        
        return $keyParts;
    }
    
    public static function convertPartsToCompleteKeys($keyData) 
    {
        $keyCompleteArray = array();
        
        $entriesNumber = sizeof($keyData[0]['key_entries']);
        $partsNumber = sizeof($keyData);
        
        for ($i = 0; $i < $entriesNumber; $i++) {
            $keyComplete = array();
            for ($j = 0; $j < $partsNumber; $j++) {
                $entry = new Varien_Object();
                $entry->setCaption($keyData[$j]['caption']);
                $entry->setPartNum($keyData[$j]['part_num']);
                $entry->setKeyEntry($keyData[$j]['key_entries'][$i]);
                $keyComplete[] = $entry;
            }
            $keyCompleteArray[] = $keyComplete;
            
        }
        return $keyCompleteArray;
    }
    
    public function getNumberOfParts()
    {
        $keysData = $this->getKeysData();
        return sizeof($keysData);
    }
    
    public function toString($format = '')
    {
        $partsNum = $this->getNumberOfParts();
        $keysData = $this->getKeysData();
        
        $stringResult = '';
        
        for ($i = 0; $i < $partsNum; $i++) {
            $keyPart = $keysData[$i];
            $stringResult .= $keyPart->getCaption().': '.$keyPart->getKeyEntry().
                    $this->_separator;
        }
        
        return $stringResult;
        
    }
    
    public function setSeparator($value) 
    {
        $this->_separator = $value;
    }
}
?>
