<?php

class Solvingmagento_Downloadkeys_Block_Upload_Steptwo_Form extends Mage_Adminhtml_Block_Widget_Form
{
    
    protected $_session;
    protected $_formData;
    
    /**
     * Init form
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('block_form');
        $this->setTitle(Mage::helper('downloadkeys')->__('Continue'));
        $this->_session = Mage::getSingleton('adminhtml/session');
        $this->_formData = $this->_session->getKeyFormData();
    }
    
    protected function _prepareForm()
    {
        $step = $this->getRequest()->getParam('step');
        $partsNum = (int) $this->getRequest()->getParam('parts');
        
        $form = new Varien_Data_Form(
            array(
                'id' => 'data_form', 
                'name' => 'data_form', 
                'action' => $this->getData('action'), 
                'method' => 'post'
            )
        );
        
        for ($i = 1; $i <= $partsNum; $i++) {
            $this->_addDataFieldset($form, $i);
        }
        
        $form->addField('step', 'hidden', array(
            'name'  =>  'step',
            'value' =>  2
        ));
        
        $form->addField('parts_num', 'hidden', array(
            'name'  =>  'parts_num',
            'value' =>  $partsNum
        ));
        
        $form->addField('product_id', 'hidden', array(
            'name'  =>  'product_id',
            'value' =>  $this->getRequest()->getParam('product_id')
        ));
        
        $form->addField('sku', 'hidden', array(
            'name'  =>  'sku',
            'value' =>  $this->getRequest()->getParam('sku')
        ));
        
        
        $form->setHtmlIdPrefix('keys_');
        
        $this->_session->unsetData('key_form_data');
        $form->setUseContainer(true);
        $this->setForm($form);
        return parent::_prepareForm();
    }
    
    protected function _addDataFieldset($form, $id) 
    {
        $fieldset = $form->addFieldset(
            'base_fieldset_'.$id, 
            array('class' => 'fieldset-left')
        );
        
        $label = new Varien_Data_Form_Element_Label(
            array(
                'value' =>  Mage::helper('downloadkeys')->__('Insert data for key part %d', $id)
            )
        );
        $label->setId('label_keys_'.$id);
        
        $fieldset->addElement($label);
        
        $captionValue = Mage::helper('downloadkeys')->__('Product key');
        $keysValue = '';
        
        if (isset($this->_formData)) {
            if (isset($this->_formData['caption'][($id-1)])) {
                $captionValue = $this->_formData['caption'][($id-1)];
            }
            
            if (isset($this->_formData['keys'][($id-1)])) {
                $keysValue = $this->_formData['keys'][($id-1)];
            }
            
        }
        
        $fieldset->addField('caption_'.$id, 'text', array(
            'name'      =>  'caption[]',
            'label'     =>  Mage::helper('downloadkeys')->__('Key caption'),
            'title'     =>  Mage::helper('downloadkeys')->__('Key caption'),
            'required'  =>  true,
            'value'     =>  $captionValue
        ));
        
        $fieldset->addField('keys_'.$id, 'textarea', array(
            'name'      =>  'keys[]',
            'label'     =>  Mage::helper('downloadkeys')->__('Key entries for part %d', $id),
            'title'     =>  Mage::helper('downloadkeys')->__('Key entries for part %d', $id),
            'required'  =>  false,
            'value'     =>  $keysValue
        ));
        
        
    }


}
?>