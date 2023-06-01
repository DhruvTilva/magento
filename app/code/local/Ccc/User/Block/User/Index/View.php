<?php
// echo 111; die();
class Ccc_User_Block_User_Index_View extends Mage_Core_Block_Template
{
   protected $tabs = [];


   public function __construct()
   {
        parent::__construct();
       $this->setTemplate('user/index/view.phtml');
        // echo 111; die();
   }

   public function addTab($name)
   {
      $this->tabs[] = $name;
      return $this;
   }

   public function getTabs()
   {
      return $this->tabs;
   }
}
