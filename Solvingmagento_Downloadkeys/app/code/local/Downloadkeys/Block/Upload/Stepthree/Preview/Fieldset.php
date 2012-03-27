<?php

class Solvingmagento_Downloadkeys_Block_Upload_Stepthree_Preview_Fieldset 
    extends Mage_Adminhtml_Block_Template 
    implements Varien_Data_Form_Element_Renderer_Interface
{
    protected $_element;

    protected function _construct()
    {
        $this->setTemplate('widget/form/renderer/fieldset.phtml');
    }

    public function getElement()
    {
        return $this->_element;
    }

    public function render(Varien_Data_Form_Element_Abstract $element)
    {
        $this->_element = $element;
        return $this->toHtml();
    }
}
?>
