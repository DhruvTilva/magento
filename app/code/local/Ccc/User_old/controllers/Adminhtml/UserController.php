<?php


class Ccc_User_Adminhtml_UserController extends Mage_Adminhtml_Controller_Action
{
    function indexAction()
    {
        
        $this->_title($this->__('User'))->_title($this->__('Manage Users'));
        $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('user/adminhtml_user'));
        $this->renderLayout();

    }

    protected function _initAction()
    {
        // load layout, set active menu and breadcrumbs
        $this->loadLayout()
            ->_setActiveMenu('user/user')
            ->_addBreadcrumb(Mage::helper('user')->__('user Manager'), Mage::helper('user')->__('user Manager'))
            ->_addBreadcrumb(Mage::helper('user')->__('Manage user'), Mage::helper('user')->__('Manage user'))
        ;
        return $this;
    }

    public function editAction()
    {
        $this->_title($this->__('user'))
             ->_title($this->__('users'))
             ->_title($this->__('Edit users'));
        $id = $this->getRequest()->getParam('user_id');
        $model = Mage::getModel('user/user');
        if ($id) {
            $model->load($id);
            if (! $model->getId()) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('user')->__('This page no longer exists.'));
                $this->_redirect('*/*/');
                return;
            }
        }
        $this->_title($model->getId() ? $model->getTitle() : $this->__('New user'));

        $data = Mage::getSingleton('adminhtml/session')->getFormData(true);

        if (!empty($data)) 
        {
            $model->setData($data);
        }

        Mage::register('user_edit',$model);

        $this->_initAction()
            ->_addBreadcrumb(
                $id ? Mage::helper('user')->__('Edit user')
                    : Mage::helper('user')->__('New user'),
                $id ? Mage::helper('user')->__('Edit user')
                    : Mage::helper('user')->__('New user'));

        $this->_addContent($this->getLayout()->createBlock('user/adminhtml_user_edit'))
                ->_addLeft($this->getLayout()
                ->createBlock('user/adminhtml_user_edit_tabs'));

        $this->renderLayout();
    }

    public function newAction()
    {
        $this->_forward('edit');
    }


    public function saveAction()
    {
        try {

            $model = Mage::getModel('user/user');
            $data = $this->getRequest()->getPost('user');
            $userId = $this->getRequest()->getParam('id');
            if (!$userId)
            {
                $userId = $this->getRequest()->getParam('user_id');
            }

            $model->setData($data)->setId($userId);
            if ($model->getCreatedTime == NULL || $model->getUpdateTime() == NULL)
            {
                $model->setCreatedTime(now())->setUpdateTime(now());
            } 
            else {
                $model->setUpdateTime(now());
            }
            $model->save();

            Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('user')->__('user was successfully saved'));
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
            $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('user_id')));
            return;
        }

        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('user')->__('Unable to find product to save'));
        $this->_redirect('*/*/');
    }

    public function deleteAction()
    {
        if( $this->getRequest()->getParam('user_id') > 0 ) {
            try {
                $model = Mage::getModel('user/user');
                 
                $model->setId($this->getRequest()->getParam('user_id'))
                ->delete();
                 
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('user was successfully deleted'));
                $this->_redirect('*/*/');
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('user_id')));
            }
        }
        $this->_redirect('*/*/');
    }

     public function massDeleteAction()
    {
        $userIds = $this->getRequest()->getParam('user');
        // print_r($productIds); die();
        if(!is_array($userIds)) {
             Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select user(s).'));
        } else {
            try {
                $user = Mage::getModel('user/user');
                foreach ($userIds as $userId) {
                    $user->reset()
                        ->load($userId)
                        ->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__('Total of %d record(s) were deleted.', count($userIds))
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }

        $this->_redirect('*/*/index');
    }
}
