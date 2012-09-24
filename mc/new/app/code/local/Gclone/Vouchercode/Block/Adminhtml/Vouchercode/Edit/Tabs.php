<?php

class Gclone_Vouchercode_Block_Adminhtml_Vouchercode_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('vouchercode_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('vouchercode')->__('Item Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('vouchercode')->__('Item Information'),
          'title'     => Mage::helper('vouchercode')->__('Item Information'),
          'content'   => $this->getLayout()->createBlock('vouchercode/adminhtml_vouchercode_edit_tab_form')->toHtml(),
      ));
     
      return parent::_beforeToHtml();
  }
}