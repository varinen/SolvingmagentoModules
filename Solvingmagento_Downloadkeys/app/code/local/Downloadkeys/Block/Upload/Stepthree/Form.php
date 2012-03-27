<?php

class Solvingmagento_Downloadkeys_Block_Upload_Stepthree_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * Init form
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('block_form');
        $this->setTitle(Mage::helper('downloadkeys')->__('Continue'));
        $this->_session = Mage::getSingleton('adminhtml/session');
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
        
        $form->addField('step', 'hidden', array(
            'name'  =>  'step',
            'value' =>  3
        ));
        
        $keyData = $this->_session->getDownloadKeyData();
        $this->_session->unset('download_key_data');
        $keyDataSerialized = serialize($keyData);
        
        $form->addField('download_key_data', 'hidden', array(
            'name'  => 'download_key_data',
            'value' =>  $keyDataSerialized
            )
        );
        
        $form->addField('download_key_parts_num', 'hidden', array(
            'name'  => 'download_key_parts_num',
            'value' =>  sizeof($keyData)
            )
        );
        
        $form->addField('download_key_entries_num', 'hidden', array(
            'name'  => 'download_key_entries_num',
            'value' =>  sizeof($keyData[0]['key_entries'])
            )
        );
        
        $form->addField('sku', 'hidden', array(
            'name'  =>  'sku',
            'value' =>  $this->getRequest()->getParam('sku')
        ));
        
        $form->addField('product_id', 'hidden', array(
            'name'  =>  'product_id',
            'value' =>  $this->getRequest()->getParam('product_id')
        ));
        
        $renderer = Mage::getBlockSingleton('solvingmagento_downloadkeys/upload_stepthree_preview_fieldset')
            ->setTemplate('downloadkeys/preview.phtml');

        $fieldset = $form->addFieldset('preview_fieldset', array(
            'legend'=>Mage::helper('downloadkeys')->__('Preview of the first 3 key entries'))
        )->setRenderer($renderer);
        
        
        $form->setHtmlIdPrefix('keys_');
        
        
        
        $form->setUseContainer(true);
        $this->setForm($form);
        return parent::_prepareForm();
    }
    

}
?>
