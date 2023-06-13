<?php

class DT_Vendor_Block_Adminhtml_Vendor_Grid extends Mage_Adminhtml_Block_Widget_Grid
{


    public function __construct()
    {
        parent::__construct();
        $this->setId('vendorAdminhtmlVendorGrid');
        $this->setDefaultSort('vendor_id');
        $this->setDefaultDir('ASC');
    }

   protected function _prepareCollection()
    {
        $collection = Mage::getModel('vendor/vendor')->getCollection();
        /* @var $collection Mage_Cms_Model_Mysql4_Page_Collection */
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $baseUrl = $this->getUrl();

        $this->addColumn('name', array(
            'header'    => Mage::helper('vendor')->__('Name'),
            'align'     => 'left',
            'index'     => 'name',
        ));

        $this->addColumn('email', array(
            'header'    => Mage::helper('vendor')->__('Email'),
            'align'     => 'left',
            'index'     => 'email'
        ));

        $this->addColumn('password', array(
            'header'    => Mage::helper('vendor')->__('Password'),
            'align'     => 'left',
            'index'     => 'password'
        ));

        $this->addColumn('mobile', array(
            'header'    => Mage::helper('vendor')->__('Mobile'),
            'align'     => 'left',
            'index'     => 'mobile'
        ));

        $this->addColumn('status', array(
            'header'    => Mage::helper('vendor')->__('Status'),
            'align'     => 'left',
            'index'     => 'status',
           

        ));

        $this->addColumn('created_at', array(
            'header'    => Mage::helper('vendor')->__('Created At'),
            'align'     => 'left',
            'index'     => 'created_at',
        ));

        $this->addColumn('updated_at', array(
            'header'    => Mage::helper('vendor')->__('Updated At'),
            'align'     => 'left',
            'index'     => 'updated_at',
        ));

        return parent::_prepareColumns();
    }

    
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('vendor_id' => $row->getId()));
    }
   
}