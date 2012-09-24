<?php

class Gclone_Vouchercode_Model_Mysql4_Vouchercode_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('vouchercode/vouchercode');
    }
}