<?php
class Solvingmagento_Downloadkeys_Block_Upload_Stepone_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected $_session;
    /**
     * Init form
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('block_form');
        $this->setTitle(Mage::helper('downloadkeys')->__('Continue'));
        $this->_session = Mage::getSingleton('adminhtml/session');
        $this->_session->unsetData('key_form_data');
    }
    
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form(
            array(
                'id' => 'parts_form',
                'name' => 'parts_form', 
                'action' => $this->getData('action'), 
                'method' => 'get'
            )
        );
        
        $form->setHtmlIdPrefix('keys_');
        
        $fieldset = $form->addFieldset(
            'base_fieldset', 
            array(
                'legend'=>Mage::helper('downloadkeys')->__('Set number of key parts'), 
                'class' => 'fieldset-wide'
            )
        );
        
        $fieldset->addField('sku', 'text', array(
            'name'      => 'sku',
            'label'     => Mage::helper('downloadkeys')->__('Product ID (SKU)'),
            'title'     => Mage::helper('downloadkeys')->__('Product ID (SKU)'),
            'required'  => true
        ));
        
        
        $fieldset->addField('parts', 'text', array(
            'name'      => 'parts',
            'label'     => Mage::helper('downloadkeys')->__('Number of key parts'),
            'title'     => Mage::helper('downloadkeys')->__('Number of key parts'),
            'value'     => 1,
            'required'  => false
        ));
        
        
        
        $fieldset->addField('step', 'hidden', array(
            'name'  =>  'step',
            'value' =>  1
        ));
        
        $form->setUseContainer(true);
        $this->setForm($form);
        return parent::_prepareForm();
    }


}
?>