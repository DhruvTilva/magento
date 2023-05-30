<?php

class Ccc_Category_Adminhtml_CategoryController extends Mage_Adminhtml_Controller_Action
{
    function indexAction()
    {
        $this->_title($this->__('Category'))->_title($this->__('Manage Categorys'));
        $this->loadLayout();
        $this->_addContent($this->getLayout()->createBlock('category/adminhtml_category'));
        // $block = Mage::app()->getLayout()->createBlock('Mage_Core_Block_Template');
        // $this->_addContent($block);
        $this->renderLayout();
    }
}
