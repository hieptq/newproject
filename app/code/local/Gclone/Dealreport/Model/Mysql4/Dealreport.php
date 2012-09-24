<?php

/**
 * Contus Support Interactive.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file GCLONE-LICENSE.txt.
 * The CONTUS GCLONE License is available at this URL:
 * http://www.groupclone.net/GCLONE-LICENSE.txt
 *
 * =================================================================
 *                 MAGENTO EDITION USAGE NOTICE
 * =================================================================
 * This package designed for Magento COMMUNITY edition
 * Contus Support does not guarantee correct work of this package
 * on any other Magento edition except Magento COMMUNITY edition.
 * =================================================================
 */

class Gclone_Dealreport_Model_Mysql4_Dealreport extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the dealreport_id refers to the key field in your database table.
        $this->_init('dealreport/dealreport', 'dealreport_id');
    }
}