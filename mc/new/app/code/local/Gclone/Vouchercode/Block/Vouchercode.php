<?php
class Gclone_Vouchercode_Block_Vouchercode extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getVouchercode()     
     { 
        if (!$this->hasData('vouchercode')) {
            $this->setData('vouchercode', Mage::registry('vouchercode'));
        }
        return $this->getData('vouchercode');
        
    }
}