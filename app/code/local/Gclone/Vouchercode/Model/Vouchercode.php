<?php

class Gclone_Vouchercode_Model_Vouchercode extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('vouchercode/vouchercode');
    }
     public function getMerchantname() {
       $tprefix = (string) Mage::getConfig()->getTablePrefix();
       $read = Mage::getSingleton('core/resource')->getConnection('core_read');
       $write = Mage::getSingleton('core/resource')->getConnection('core_write');
       $selectName = $read->fetchAll("Select *  from " . $tprefix . "admin_user");

       return $selectName;
    }
}