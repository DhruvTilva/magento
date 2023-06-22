<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magento.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magento.com for more information.
 *
 * @category    Mage
 * @package     Mage_Adminhtml
 * @copyright  Copyright (c) 2006-2020 Magento, Inc. (http://www.magento.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Catalog product gallery controller
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class DT_Brand_Adminhtml_BrandController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        // echo "string"; die();
        $this->_title($this->__('Brand'))
             ->_title($this->__('Manage Brands'));
        $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('brand/adminhtml_brand'));
        $this->renderLayout();
    }

    protected function _initAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('brand/brand')
            ->_addBreadcrumb(Mage::helper('brand')->__('Brand Manager'), Mage::helper('brand')->__('Brand Manager'))
            ->_addBreadcrumb(Mage::helper('brand')->__('Manage brand'), Mage::helper('brand')->__('Manage brand'))
        ;
        return $this;
    }

    public function newAction()
    {
        $this->_forward('edit');
        
    }

    public function editAction()
    {
        $this->_title($this->__('Brand'))
             ->_title($this->__('Brands'))
             ->_title($this->__('Edit Brands'));
     

        $id = $this->getRequest()->getParam('brand_id');
        $model = Mage::getModel('brand/brand');

        if ($id) {
            $model->load($id);
            if (! $model->getId()) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('brand')->__('This page no longer exists.'));
                $this->_redirect('*/*/');
                return;
        //         echo "<pre>";
        // print_r($model); die();
            }
        }
        $this->_title($model->getId() ? $model->getTitle() : $this->__('New Brand'));

        $data = Mage::getSingleton('adminhtml/session')->getFormData(true);

        if (!empty($data)) 
        {
            $model->setData($data);
        }

        Mage::register('brand_edit',$model);

        $this->_initAction()
            ->_addBreadcrumb(
                $id ? Mage::helper('brand')->__('Edit Brand')
                    : Mage::helper('brand')->__('New Brand'),
                $id ? Mage::helper('brand')->__('Edit Brand')
                    : Mage::helper('brand')->__('New Brand'));

        $this->_addContent($this->getLayout()->createBlock('brand/adminhtml_brand_edit'))
                ->_addLeft($this->getLayout()->createBlock('brand/adminhtml_brand_edit_tabs'));

        $this->renderLayout();
    }

    public function saveAction()
    {
        try {
            $model = Mage::getModel('brand/brand');
            $data = $this->getRequest()->getPost('brand');

            $brandId = $this->getRequest()->getParam('id');
            if (!$brandId)
            {
                $brandId = $this->getRequest()->getParam('brand_id');
            }

            $model->setData($data)->setId($brandId);
            if ($model->getCreatedTime == NULL || $model->getUpdateTime() == NULL)
            {
                $model->setCreatedTime(now())->setUpdateTime(now());
            } 
            else {
                $model->setUpdateTime(now());
            }
            $model->save();

           if (isset($_FILES['image']['name']) && ($_FILES['image']['name'] != ''))
            {
                try {
                    $uploader = new Varien_File_Uploader('image');
                    $uploader->setAllowedExtensions(array('jpg', 'jpeg', 'gif', 'png', 'webp'));
                    $uploader->setAllowRenameFiles(false);
                    $uploader->setFilesDispersion(false);
                    
                    $path = Mage::getBaseDir('media') . DS . 'brand' . DS;
                    $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                    if ($uploader->save($path, $model->getId().'.'.$extension)) {
                        $model->image = 'brand/'.$model->getId().".".$extension;
                        $model->save();
                        Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('brand')->__('Image was successfully uploaded'));
                    }
                    
                    // $imageName = $uploader->getUploadedFileName();

                } catch (Exception $e) {
                    Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                }
            }

            if (isset($_FILES['banner']['name']) && ($_FILES['banner']['name'] != '')) 
            {
                try {
                    // echo 111; die();
                    $uploader = new Varien_File_Uploader('banner');
                    // print_r($uploader); die();
                    $uploader->setAllowedExtensions(array('jpg', 'jpeg', 'gif', 'png', 'webp'));
                    $uploader->setAllowRenameFiles(false);
                    $uploader->setFilesDispersion(false);
                    
                    $path = Mage::getBaseDir('media') . DS . 'brand' . DS . 'banner' . DS;
                    $extension = pathinfo($_FILES['banner']['name'], PATHINFO_EXTENSION);
                   // echo  $model->getId(); die();
                    if ($uploader->save($path, $model->getId().'.'.$extension)) {
                        // echo 111; die;
                        $model->banner_image = "brand/banner/".$model->getId().".".$extension;
                        $model->save();
                        Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('brand')->__('Banner Image was successfully uploaded'));
                    }
                } catch (Exception $e) {
                    Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                }
            }

            Mage::dispatchEvent('brand_save_after', array('brand' => $model));

            Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('brand')->__('Brand was successfully saved'));
            Mage::getSingleton('adminhtml/session')->setFormData(false);
             
            if ($this->getRequest()->getParam('back')) {
                $this->_redirect('*/*/edit', array('id' => $model->getId()));
                return;
            }
            $this->_redirect('*/*/');
            return;
        } catch (Exception $e) {
            Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            Mage::getSingleton('adminhtml/session')->setFormData($data);
            $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('brand_id')));
            return;
        }

        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('brand')->__('Unable to find brand to save'));
        $this->_redirect('*/*/');
    }

    public function deleteAction()
    {
        if( $this->getRequest()->getParam('brand_id') > 0 ) {
            try {
                $model = Mage::getModel('brand/brand');
                 
                $model->setId($this->getRequest()->getParam('brand_id'))
                ->delete();
                 
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Brand was successfully deleted'));
                $this->_redirect('*/*/');
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('brand_id')));
            }
        }
        $this->_redirect('*/*/');
    }
    public function massDeleteAction()
    {
        $customersIds = $this->getRequest()->getParam('brand');
        if(!is_array($customersIds)) {
             Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select brand(s).'));
        } else {
            try {
                $customer = Mage::getModel('brand/brand');
                foreach ($customersIds as $customerId) {
                    $customer->reset()
                        ->load($customerId)
                        ->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__('Total of %d record(s) were deleted.', count($customersIds))
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }

        $this->_redirect('*/*/index');
    }
}




 