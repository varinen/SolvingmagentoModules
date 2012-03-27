<?php

class Solvingmagento_Downloadkeys_Block_Upload_Stepthree extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        $this->_controller = 'upload';
        $this->_blockGroup = 'solvingmagento_downloadkeys';
        $this->_mode = 'stepthree';
        parent::__construct();
        $this->_updateButton('save', 'label', Mage::helper('downloadkeys')->__('Upload keys'));
        $this->_updateButton('save', 'onclick', 'data_form.submit();');
    }
    
    /**
     * Get edit form container header text
     *
     * @return string
     */
    public function getHeaderText()
    {
        return Mage::helper('downloadkeys')->__('Step 3. Preview Key Data');
    }
}
?>
