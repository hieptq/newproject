<?php

class Gclone_Vouchercode_Model_Mysql4_Vouchercode extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the vouchercode_id refers to the key field in your database table.
        $this->_init('vouchercode/vouchercode', 'vouchercode_id');
    }
}