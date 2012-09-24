<?php

class Gclone_Vouchercode_Model_Vouchercode extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('vouchercode/vouchercode');
    }
}