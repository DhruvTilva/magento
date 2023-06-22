<?php 

class DT_Vendor_AccountController extends Mage_Core_Controller_Front_Action
{
    public function createAction()
    {
        // echo 11; die();
        if ($this->_getSession()->isLoggedIn()) {
            $this->_redirect('*/*');
            return;
        }

        $this->loadLayout();
        // $this->_initLayoutMessages('vendor/session');
        $this->renderLayout();
    }

    protected function _getSession()
    {
        return Mage::getSingleton('customer/session');
    }

    public function createpostAction()
    {
        // echo "<pre>";
        // $vendorData = $_POST;
        $vendorData = $this->getRequest()->getPost();
        // print_r($vendorData);
        $model = Mage::getModel('vendor/vendor');
        $model->setData($vendorData);
        $model->password = md5($model->password);

        // print_r($model);
        $model->save();
        
        // echo 1111;
        //     $config = array(
        //     'ssl' => 'tls',
        //     'port' => 587,
        //     'auth' => 'login',
        //     'username' => 'card.managment.helpdesk@gmail.com',
        //     'password' => 'Tdb@7383161715'
        // );
        
        // $transport = new Zend_Mail_Transport_Smtp('smtp.gmail.com', $config);
        // Zend_Mail::setDefaultTransport($transport);

        // // Send verification email
        // $mail = new Zend_Mail();
        // $mail->setBodyText('Please verify your email');
        // $mail->setFrom('admin@example.com', 'Admin');
        // $mail->addTo('tilvadhruv8@gmail.com', 'Vendor');
        // $mail->setSubject('Email Verification');
        // $mail->send();

    }
}