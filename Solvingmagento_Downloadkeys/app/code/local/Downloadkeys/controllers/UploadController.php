<?php

class Solvingmagento_Downloadkeys_UploadController extends Mage_Adminhtml_Controller_Action
{
    protected $_session;
    
    protected function _construct()
    {
        $this->_session = Mage::getSingleton('adminhtml/session');
        parent::_construct();
    }
    
    protected function _initAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('catalog/downloadkeys/upload')
            ->_addBreadcrumb(Mage::helper('adminhtml')
                    ->__('Catalog'), Mage::helper('downloadkeys')->__('Catalog'))
            ->_addBreadcrumb(Mage::helper('downloadkeys')
                    ->__('Download Keys'), Mage::helper('downloadkeys')->__('Download Keys'));
        return $this;
    }
    
    public function indexAction()
    {
        $this->_initAction();
        $this->_title($this->__('Catalog'))
             ->_title($this->__('Download Keys'))
             ->_title($this->__('Upload Keys'));
        $this->renderLayout();
    }
    
    public function saveAction()
    {
        $step = $this->getRequest()->getParam('step');
        
        switch ($step) {
            case '1': $this->_forward('data');
                break;
            case '2': $this->_forward('preview');
                break;
            case '3': $this->_forward('upload');
                break;
        }
    }

    
    public function dataAction()
    {
        $sku = $this->getRequest()->getParam('sku');
        $product = Mage::getModel('catalog/product')->getCollection()
                ->getItemByColumnValue('sku', $sku);
  
        if (!$product) {
            $this->_session->addError(
                    Mage::helper('downloadkeys')->__(
                        'Please supply a SKU'
                    )
                );
            $this->_redirect('slvgmgt_downloadkeys/upload/index/');
            return;
        }
      /*  
       if ($product->getTypeId() != 'downloadable') {
           $this->_session->addError(
                    Mage::helper('downloadkeys')->__(
                        'Product with ID %s is not a downloadable product',
                        $sku
                    )
                );
            $this->_redirect('slvgmgt_downloadkeys/upload/index/');
            return;
        }
        */
        $id = $product->getEntityId();
        
        $this->getRequest()->setParam('product_id', $id);
        
        $partsNum = $this->getRequest()->getParam('parts');
        
        if (((int)$partsNum <= 0) || ((int)$partsNum > 20)) {
            $this->_session->addError(
                    Mage::helper('downloadkeys')->__(
                        'Please enter a valid number of key parts (more than 0, less or equal than 20)'
                    )
                );
            $this->_redirect('slvgmgt_downloadkeys/upload/index/');
            return;
        }
        
        $this->_initAction();
        $this->_title($this->__('Catalog'))
             ->_title($this->__('Download Keys'))
             ->_title($this->__('Upload Keys'));
        
        $this->renderLayout();
    }
    
    public function previewAction()
    {
        
        $this->_session->unsetData('key_form_data');
        
        
        $formData = $this->getRequest()->getParams();
        unset($formData['key']);
        $formData['parts'] = $formData['parts_num'];
        $this->_session->setKeyFormData($formData);
        
        $uploader = Mage::getModel('solvingmagento_donwloadkeys/uploader');
        $uploader->setData($this->getRequest()->getParams());
        
        if (!$uploader->validate()) {
            $this->_redirect('slvgmgt_downloadkeys/upload/data/', $formData );
            return;
        } else {
            $this->_title($this->__('Catalog'))
                 ->_title($this->__('Download Keys'))
                 ->_title($this->__('Preview Keys'));
            
            $product = Mage::getModel('catalog/product')->load(
                    $this->getRequest()->getParam('product_id')
                );
                 
            $preview = Mage::getBlockSingleton(
                'solvingmagento_downloadkeys/upload_stepthree_preview_fieldset'
            );
            $preview->setPreviewData($uploader->getPreviewData())
                    ->setProduct($product)
                    ->setKeyData($uploader->getKeyData());
            
            $this->_session->unset('download_key_data');
            $this->_session->setDownloadKeyData($uploader->getKeyData());
                    

            $this->_initAction();
            $this->renderLayout();
        }
    }
    
    public function uploadAction()
    {
        $this->_session = Mage::getSingleton('adminhtml/session');
        
        $params = $this->getRequest()->getParams();
        $keyData = unserialize($params['download_key_data']);
        
        if (sizeof($keyData) != (int)$params['download_key_parts_num']) {
            $this->_session->addError(
                    Mage::helper('downloadkeys')->__(
                        'Problem uploading form. Data corrupt: number of key '.
                        'parts is not the same as initially entered'
                    )
                );
        }
        foreach ($keyData as $part) {
            if (sizeof($part['key_entries']) != 
                    (int)$params['download_key_entries_num']) {
                $this->_session->addError(
                    Mage::helper('downloadkeys')->__(
                        'Problem uploading form. Data corrupt: number of key '.
                        'entries in part %s is not the same as initially entered',
                        $part['part_num']
                    )
                );
            }
        }
        
        $keys = 
            Solvingmagento_Downloadkeys_Model_Downloadkey::convertPartsToCompleteKeys($keyData);
        
        $counter = 0;
        $success = 0;
        
        foreach ($keys as $key) {
            $counter++;
            $downloadKey = Mage::getModel('solvingmagento_donwloadkeys/downloadkey');
            $downloadKey->setSku($this->getRequest()->getParam('sku'));
            $downloadKey->setDateAdded(date("Y-m-d"));
            $downloadKey->setKeysData(serialize($key));
            
            $downloadKey->getResource()->beginTransaction();
            try {
                $downloadKey->save();
                $downloadKey->getResource()->commit();
                $success++;
                
                $sku = $this->getRequest()->getParam('sku');
                $product = Mage::getModel('catalog/product')->getCollection()
                    ->getItemByColumnValue('sku', $sku);
                
                $stockItem = Mage::getModel('cataloginventory/stock_item');
                $stockItem->loadByProduct($product);
                $stockItem->addQty(1);
                $stockItem->save();
                
            } catch (Exception $e) {
                $downloadKey->getResource()->rollBack();
                $this->_session->addError(
                    Mage::helper('downloadkeys')->__(
                        'Database write exception while saving key entry %d:',
                        $counter
                    ).' '.$e->getMessage()
                );
            }
        }
        
        if ($success > 0) {
            $this->_session->addSuccess(
                    Mage::helper('downloadkeys')->__(
                        '%d keys have been successfully uploaded',
                        $success
                    )
                );
        }
        
        $this->_redirect('slvgmgt_downloadkeys/upload/index/');
    }

}
?>
