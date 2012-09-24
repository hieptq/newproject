<?php
/**
 * @name         :  Apptha One Step Checkout
 * @version      :  1.1
 * @since        :  Magento 1.4
 * @author       :  Apptha - http://www.apptha.com
 * @copyright    :  Copyright (C) 2011 Powered by Apptha
 * @license      :  http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @Creation Date:  June 20 2011
 * 
 * */ ?>
<?php

class Apptha_Onestepcheckout_Helper_Checkout extends Mage_Core_Helper_Abstract {

    function __construct()
    {
        $this->settings = $this->loadSettings();
    }
//get the Onestepcheckout settings
    public function loadSettings()
    {
        $settings = array();
        $items = array();
        $items = Mage::getStoreConfig('onestepcheckout');
        foreach ($items as $config) {
            foreach ($config as $key => $value) {
                $settings[$key] = $value;
            }
        }
         if(empty($settings['default_country_id']))
        {
            $settings['default_country_id'] = 'US';
        }
        return $settings;
    }
    
//check the exluded fields and assign - to that values
    public function load_exclude_data(&$data) {
        if ($this->settings['display_city'])
        {
            $data['city'] = '-';
        }
        if ($this->settings['display_country'])
        {
            $data['country_id'] = $this->settings['default_country_id'];
        }
        if ($this->settings['display_telephone'])
        {
            $data['telephone'] = '-';
        }
        if ($this->settings['display_state'])
        {
            $data['region'] = '-';
            $data['region_id'] = '1';
        }
        if ($this->settings['display_zipcode'])
        {
            $data['postcode'] = '-';
        }
        if ($this->settings['display_company'])
        {
            $data['company'] = '';
        }
        if ($this->settings['display_fax'])
        {
            $data['fax'] = '';
        }
        if ($this->settings['display_address'])
        {
            $data['street'][] = '-';
        }
        return $data;
    }
    
    //check the exclude fields and assign - to that values when ajax updates trigger
    
	public function load_add_data(&$data) 
    {        
        if (!$data['city'])
        {
            $data['city'] = '-';
        }
        if (!$data['country_id'])
        {
            $data['country_id'] = $this->settings['default_country_id'];
        }
        if (!$data['telephone'])
        {
            $data['telephone'] = '-';
        }
        if (!$data['region_id'])
        {
            $data['region_id'] = '-';
            $data['region'] = '-';
        }
        if (!$data['postcode'])
        {
            $data['postcode'] = '-';
        }
        if (!$data['company'])
        {
            $data['company'] = '-';
        }
        if (!$data['fax'])
        {
            $data['fax'] = '-';
        }
        if (!$data['confirm_password'])
        {
            $data['confirm_password'] = '-';
        }
        if (!$data['customer_password'])
        {
            $data['customer_password'] = '-';
        }         
        if (empty($data['street'][0]))
        {
            $data['street'][0] = '-';
        }
        if (!$data['firstname'])
        {
            $data['firstname'] = '-';
        }
        if (!$data['lastname'])
        {
            $data['lastname'] = '-';
        }
        if (!$data['email'])
        {
            $data['email'] = '-';
        }
        return $data;
    }

}