<?php

class DT_Salesman_Block_Adminhtml_Salesman_Grid extends Mage_Adminhtml_Block_Widget_Grid
{


    public function __construct()
    {
        parent::__construct();
        $this->setId('salesmanAdminhtmlSalesmanGrid');
        $this->setDefaultSort('salesman_id');
        $this->setDefaultDir('ASC');
    }

   protected function _prepareCollection()
    {
        $collection = Mage::getModel('salesman/salesman')->getCollection();
        /* @var $collection Mage_Cms_Model_Mysql4_Page_Collection */
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $baseUrl = $this->getUrl();

        $this->addColumn('firstname', array(
            'header'    => Mage::helper('salesman')->__('First Name'),
            'align'     => 'left',
            'index'     => 'firstname',
        ));

        $this->addColumn('lastname', array(
            'header'    => Mage::helper('salesman')->__('Last Name'),
            'align'     => 'left',
            'index'     => 'lastname'
        ));

        $this->addColumn('status', array(
            'header'    => Mage::helper('salesman')->__('Status'),
            'align'     => 'left',
            'index'     => 'status',
        ));

        return parent::_prepareColumns();
    }

    
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('salesman_id' => $row->getId()));
    }
   
}