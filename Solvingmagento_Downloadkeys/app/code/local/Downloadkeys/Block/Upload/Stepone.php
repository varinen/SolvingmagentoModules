<?php

class Solvingmagento_Downloadkeys_Block_Upload_Stepone extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        $this->_controller = 'upload';
        $this->_blockGroup = 'solvingmagento_downloadkeys';
        $this->_mode = 'stepone';
        parent::__construct();
        $this->_updateButton('save', 'label', Mage::helper('downloadkeys')->__('Insert Key Data'));
        $this->_updateButton('save', 'onclick', 'parts_form.submit();');
    }
    
    /**
     * Get edit form container header text
     *
     * @return string
     */
    public function getHeaderText()
    {
        return Mage::helper('downloadkeys')->__('Step 1. Set the Number of Key Parts');
    }
}
?>