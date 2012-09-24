<?php
class Gclone_Vouchercode_Block_Adminhtml_Vouchercode extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_vouchercode';
    $this->_blockGroup = 'vouchercode';
    $this->_headerText = Mage::helper('vouchercode')->__('Item Manager');
    $this->_addButtonLabel = Mage::helper('vouchercode')->__('Add Item');
    parent::__construct();
  }
}