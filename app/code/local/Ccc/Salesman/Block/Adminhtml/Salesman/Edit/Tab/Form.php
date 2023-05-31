<?php

class Ccc_Salesman_Block_Adminhtml_Salesman_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);

        $fieldset = $form->addFieldset('salesman_form',array('legend'=>Mage::helper('salesman')->__('salesman Information')));

        $fieldset->addField('firstname', 'text', array(
            'label' => Mage::helper('salesman')->__('First Name'),
            'required' => true,
            'name' => 'salesman[firstname]',
        ));

        $fieldset->addField('lastname','text', array(
            'label' => Mage::helper('salesman')->__('Last Name'),
            'required' => true,
            'name' => 'salesman[lastname]'
        ));

        $fieldset->addField('status','select', array(
            'label' => Mage::helper('salesman')->__('Status'),
            'required' => true,
            'name' => 'salesman[status]',
            'options'=> ['Active'=>'Active','Inactive'=>'Inactive']
        ));

      

        if ( Mage::getSingleton('adminhtml/session')->getSalesmanData() )
        {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getSalesmanData());
            Mage::getSingleton('adminhtml/session')->setSalesmanData(null);
        } elseif ( Mage::registry('salesman_edit') ) {
            $form->setValues(Mage::registry('salesman_edit')->getData());
        }
        return parent::_prepareForm();


    }

}