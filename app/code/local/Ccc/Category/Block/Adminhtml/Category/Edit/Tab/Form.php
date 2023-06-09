<?php

class Ccc_Category_Block_Adminhtml_Category_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);

        $fieldset = $form->addFieldset('category_form',array('legend'=>Mage::helper('category')->__('category Information')));

        $fieldset->addField('name', 'text', array(
            'label' => Mage::helper('category')->__('Name'),
            'required' => true,
            'name' => 'category[name]',
        ));

        $fieldset->addField('description','text', array(
            'label' => Mage::helper('category')->__('Description'),
            'required' => true,
            'name' => 'category[description]'
        ));


        $fieldset->addField('status', 'select', array(
            'label' => Mage::helper('category')->__('Status'),
            'required' => true,
            'name' => 'category[status]',
            'options' => array(
                1 => Mage::helper('category')->__('Active'),
                2 => Mage::helper('category')->__('Inactive'),
            ),
        ));

        if ( Mage::getSingleton('adminhtml/session')->getCategoryData() )
        {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getCategoryData());
            Mage::getSingleton('adminhtml/session')->setCategoryData(null);
        } 
        elseif ( Mage::registry('category_edit') ) {
            $form->setValues(Mage::registry('category_edit')->getData());
        }
        return parent::_prepareForm();


    }

}





    