<?php

class Gclone_Vouchercode_Block_Adminhtml_Vouchercode_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'vouchercode';
        $this->_controller = 'adminhtml_vouchercode';
        
        $this->_updateButton('save', 'label', Mage::helper('vouchercode')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('vouchercode')->__('Delete Item'));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('vouchercode_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'vouchercode_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'vouchercode_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('vouchercode_data') && Mage::registry('vouchercode_data')->getId() ) {
            return Mage::helper('vouchercode')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('vouchercode_data')->getTitle()));
        } else {
            return Mage::helper('vouchercode')->__('Add Item');
        }
    }
}