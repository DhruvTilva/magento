<?php


class Ccc_Category_Adminhtml_CategoryController extends Mage_Adminhtml_Controller_Action
{
    function indexAction()
    {
        // $this->loadLayout();
        // $block = $this->getLayout()->createBlock('vendor/test');
        // $this->getLayout()->createBlock('vendor/test','test')->getBlock('content');
        // // print_r(get_class_methods($r));
    
        // // print_r(get_class($block));

        // $this->renderLayout();
        // // echo $block->toHtml();
        // echo "Controller Working...";
        $this->_title($this->__('Category'))->_title($this->__('Manage Categories'));
        $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('category/adminhtml_category'));
        $this->renderLayout();



       // $vendor = Mage::getModel('vendor/vendor');
       // $vendor->name = "dhruv";
       // $vendor->email = "dhruv@gmail.com";
       // $vendor->mobile = "111";

       // print_r($vendor->save());
       // die();
        



        // $model = Mage::getModel('vendor/test');

        // print_r($model);

        // $helper = Mage::helper('vendor/test');
        // print_r($helper);

        // $helperData = Mage::helper('vendor/data');
        // print_r($helperData);

         

         // die;
    }

    protected function _initAction()
    {
        // load layout, set active menu and breadcrumbs
        $this->loadLayout()
            ->_setActiveMenu('category/category')
            ->_addBreadcrumb(Mage::helper('category')->__('category Manager'), Mage::helper('category')->__('category Manager'))
            ->_addBreadcrumb(Mage::helper('category')->__('Manage category'), Mage::helper('category')->__('Manage category'))
        ;
        return $this;
    }

    public function editAction()
    {
        $this->_title($this->__('category'))
             ->_title($this->__('category'))
             ->_title($this->__('Edit category'));

        $id = $this->getRequest()->getParam('category_id');
        $model = Mage::getModel('category/category');
        if ($id) {
            $model->load($id);
            if (! $model->getId()) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('category')->__('This page no longer exists.'));
                $this->_redirect('*/*/');
                return;
            }
        }
        // echo "<pre>";print_r($model->load($id));die;
        $this->_title($model->getId() ? $model->getTitle() : $this->__('New category'));

        $data = Mage::getSingleton('adminhtml/session')->getFormData(true);

        if (!empty($data)) 
        {
            $model->setData($data);
        }

        Mage::register('category_edit',$model);

        $this->_initAction()
            ->_addBreadcrumb(
                $id ? Mage::helper('category')->__('Edit category')
                    : Mage::helper('category')->__('New category'),
                $id ? Mage::helper('category')->__('Edit category')
                    : Mage::helper('category')->__('New category'));

        $this->_addContent($this->getLayout()->createBlock('category/adminhtml_category_edit'))
                ->_addLeft($this->getLayout()
                ->createBlock('category/adminhtml_category_edit_tabs'));

        $this->renderLayout();
    }

    public function newAction()
    {
        $this->_forward('edit');
    }


    public function saveAction()
    {
        try {
            // $model = Mage::getModel('vendor/vendor');
            // $data = $this->getRequest()->getPost();
            // // print_r($data); die();
            // if (!$this->getRequest()->getParam('id'))
            // {
            //     $model->setData($data)->setId($this->getRequest()->getParam('vendor_id'));
            // }
            // // echo "<pre>";
            // // print_r($model->setData($data));

            // $model->setData($data)->setId($this->getRequest()->getParam('id'));
            // // die();
            // // if ($model->getCreatedTime == NULL || $model->getUpdateTime() == NULL)
            // // {
            // //     $model->setCreatedTime(now())->setUpdateTime(now());
            // // } 
            // // else {
            // //     $model->setUpdateTime(now());
            // // }
            // $model->save();

            $model = Mage::getModel('category/category');
            $data = $this->getRequest()->getPost('category');
            $categoryId = $this->getRequest()->getParam('id');
            if (!$categoryId)
            {
                $categoryId = $this->getRequest()->getParam('category_id');
            }

            $model->setData($data)->setId($categoryId);
            if ($model->getCreatedTime == NULL || $model->getUpdateTime() == NULL)
            {
                $model->setCreatedTime(now())->setUpdateTime(now());
            } 
            else {
                $model->setUpdateTime(now());
            }
            $model->save();

            Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('category')->__('category was successfully saved'));
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
            $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('category_id')));
            return;
        }

        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('category')->__('Unable to find category to save'));
        $this->_redirect('*/*/');
    }

    public function deleteAction()
    {
        if( $this->getRequest()->getParam('category_id') > 0 ) {
            try {
                $model = Mage::getModel('category/category');
                 
                $model->setId($this->getRequest()->getParam('category_id'))
                ->delete();
                 
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('category was successfully deleted'));
                $this->_redirect('*/*/');
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('category_id')));
            }
        }
        $this->_redirect('*/*/');
    }

     public function massDeleteAction()
    {
        $vendorIds = $this->getRequest()->getParam('category');
        // print_r($categoryIds); die();
        if(!is_array($categoryIds)) {
             Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select category(s).'));
        } else {
            try {
                $category = Mage::getModel('category/category');
                foreach ($categoryIds as $categoryId) {
                    $category->reset()
                        ->load($categoryId)
                        ->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__('Total of %d record(s) were deleted.', count($categoryIds))
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }

        $this->_redirect('*/*/index');
    }
}
