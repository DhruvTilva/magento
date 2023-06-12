<?php

// echo "frontend"; die();
class DT_Brand_FrontendController extends Mage_Core_Controller_Front_Action
{
   

    public function viewAction()
    {
        // echo 111; die();
        $this->loadLayout();
        // $this->getLayout()->getBlock('content')
        // ->append($this->getLayout()->createBlock('brand/brand')->setTemplate('brand/banner.phtml'));
        $this->renderLayout();
    }
}