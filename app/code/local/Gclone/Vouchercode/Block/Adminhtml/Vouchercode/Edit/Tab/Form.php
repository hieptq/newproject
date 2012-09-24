<?php

class Gclone_Vouchercode_Block_Adminhtml_Vouchercode_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _construct()
    {
        parent::_construct();
        $this->setTemplate('vouchercode/form.phtml');

    }
//  protected function _prepareForm()
//  {
//      $form = new Varien_Data_Form();
//      $this->setForm($form);
//      $fieldset = $form->addFieldset('vouchercode_form', array('legend'=>Mage::helper('vouchercode')->__('Voucher Code Information')));
//
//      $fieldset->addField('title', 'text', array(
//          'label'     => Mage::helper('vouchercode')->__('Title'),
//          'class'     => 'required-entry',
//          'required'  => true,
//          'name'      => 'title',
//      ));
//
//      $fieldset->addField('filename', 'file', array(
//          'label'     => Mage::helper('vouchercode')->__('File'),
//          'required'  => false,
//          'name'      => 'filename',
//	  ));
//
//      $fieldset->addField('status', 'select', array(
//          'label'     => Mage::helper('vouchercode')->__('Status'),
//          'name'      => 'status',
//          'values'    => array(
//              array(
//                  'value'     => 1,
//                  'label'     => Mage::helper('vouchercode')->__('Enabled'),
//              ),
//
//              array(
//                  'value'     => 2,
//                  'label'     => Mage::helper('vouchercode')->__('Disabled'),
//              ),
//          ),
//      ));
//
//      $fieldset->addField('content', 'editor', array(
//          'name'      => 'content',
//          'label'     => Mage::helper('vouchercode')->__('Content'),
//          'title'     => Mage::helper('vouchercode')->__('Content'),
//          'style'     => 'width:700px; height:500px;',
//          'wysiwyg'   => false,
//          'required'  => true,
//      ));
//
//      if ( Mage::getSingleton('adminhtml/session')->getVouchercodeData() )
//      {
//          $form->setValues(Mage::getSingleton('adminhtml/session')->getVouchercodeData());
//          Mage::getSingleton('adminhtml/session')->setVouchercodeData(null);
//      } elseif ( Mage::registry('vouchercode_data') ) {
//          $form->setValues(Mage::registry('vouchercode_data')->getData());
//      }
//      return parent::_prepareForm();
//  }

     public function edit()
    {
        if($this->getRequest()->getParam('id'))
        {
            $id = $this->getRequest()->getParam('id');
            $model  = Mage::getModel('vouchercode/vouchercode')->load($id);

        }
        return $model;
    }
}