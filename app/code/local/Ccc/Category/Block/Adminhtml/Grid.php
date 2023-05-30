<?php

class Ccc_Category_Block_Adminhtml_Category_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('categoryAdminhtmlCategoryGrid');
        $this->setDefaultSort('category_id');
        $this->setDefaultDir('ASC');
    }

   protected function _prepareCollection()
    {
        $collection = Mage::getModel('category/category')->getCollection();
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $baseUrl = $this->getUrl();

        $this->addColumn('first_name', array(
            'header'    => Mage::helper('category')->__('First Name'),
            'align'     => 'left',
            'index'     => 'first_name'
        ));

        $this->addColumn('last_name', array(
            'header'    => Mage::helper('category')->__('Last Name'),
            'align'     => 'left',
            'index'     => 'last_name'
        ));

        $this->addColumn('email', array(
            'header'    => Mage::helper('category')->__('Email'),
            'align'     => 'left',
            'index'     => 'email'
        ));

      

        $this->addColumn('mobile', array(
            'header'    => Mage::helper('category')->__('Mobile'),
            'align'     => 'left',
            'index'     => 'mobile'
        ));

        
        return parent::_prepareColumns();
    }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('category_id');
        $this->getMassactionBlock()->setFormFieldName('category');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('category')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('category')->__('Are you sure?')
        ));
        return $this;
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('category_id' => $row->getId()));
    }
   
}