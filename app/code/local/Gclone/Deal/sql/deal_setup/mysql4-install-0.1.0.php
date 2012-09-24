<?php
/**
 * Contus Support Interactive.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file GCLONE-LICENSE.txt.
 * The CONTUS License is available at this URL:
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

$installer = $this;

$installer->startSetup();

//create the 'Deal starts at' attribute
$installer->addAttribute('catalog_product', 'starttime', array(
    'group' => 'Deal Information',
    'label' => 'Deal starts at',
    'type' => 'varchar',
    'input' => 'text',
    'default' => '11:59 PM',
    'class' => '',
    'backend' => '',
    'frontend' => '',
    'source' => '',
    'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
    'visible' => true,
    'required' => true,
    'user_defined' => true,
    'searchable' => false,
    'filterable' => false,
    'comparable' => false,
    'visible_on_front' => true,
    'visible_in_advanced_search' => false,
    'unique' => false,
    'apply_to' => 'simple,virtual',
));
$installer->updateAttribute('catalog_product', 'starttime', 'is_global', Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE);
$installer->updateAttribute('catalog_product', 'starttime', 'apply_to', 'simple,virtual');

//create the 'Deal expires at' attribute
$installer->addAttribute('catalog_product', 'time', array(
    'group' => 'Deal Information',
    'label' => 'Deal expires at',
    'type' => 'varchar',
    'input' => 'text',
    'default' => '11:59 PM',
    'class' => '',
    'backend' => '',
    'frontend' => '',
    'source' => '',
    'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
    'visible' => true,
    'required' => true,
    'user_defined' => true,
    'searchable' => false,
    'filterable' => false,
    'comparable' => false,
    'visible_on_front' => true,
    'visible_in_advanced_search' => false,
    'unique' => false,
    'apply_to' => 'simple,virtual',
));
$installer->updateAttribute('catalog_product', 'time', 'is_global', Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE);
$installer->updateAttribute('catalog_product', 'time', 'apply_to', 'simple,virtual');

//create the 'Minimum coupons to be purchased' attribute
$installer->addAttribute('catalog_product', 'target_number', array(
    'group' => 'Deal Information',
    'label' => 'Minimum coupons to be purchased',
    'type' => 'varchar',
    'input' => 'text',
    'default' => '1',
    'class' => 'validate-digits',
    'backend' => '',
    'frontend' => '',
    'source' => '',
    'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
    'visible' => true,
    'required' => false,
    'user_defined' => true,
    'searchable' => false,
    'filterable' => false,
    'comparable' => false,
    'visible_on_front' => true,
    'visible_in_advanced_search' => false,
    'unique' => false,
    'apply_to' => 'simple,virtual',
));
$installer->updateAttribute('catalog_product', 'target_number', 'frontend_class', 'validate-digits');
$installer->updateAttribute('catalog_product', 'target_number', 'is_global', Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE);
$installer->updateAttribute('catalog_product', 'target_number', 'apply_to', 'simple,virtual');

//create the 'Maximum Coupons Per Customer' attribute
$installer->addAttribute('catalog_product', 'percustomer', array(
    'group' => 'Deal Information',
    'label' => 'Maximum Coupons Per Customer',
    'type' => 'varchar',
    'input' => 'text',
    'default' => '0',
    'class' => 'validate-digits',
    'backend' => '',
    'frontend' => '',
    'source' => '',
    'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
    'visible' => true,
    'required' => false,
    'user_defined' => true,
    'searchable' => false,
    'filterable' => false,
    'comparable' => false,
    'visible_on_front' => true,
    'visible_in_advanced_search' => false,
    'unique' => false,
    'apply_to' => 'simple,virtual',
));
$installer->updateAttribute('catalog_product', 'percustomer', 'frontend_class', 'validate-digits');
$installer->updateAttribute('catalog_product', 'percustomer', 'is_global', Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE);
$installer->updateAttribute('catalog_product', 'percustomer', 'apply_to', 'simple,virtual');

//create the 'Buy it for friend - Maximum Coupons Per Customer' attribute
$installer->addAttribute('catalog_product', 'for_friend', array(
    'group' => 'Deal Information',
    'label' => 'Buy it for friend - Maximum Coupons Per Customer',
    'type' => 'varchar',
    'input' => 'text',
    'default' => '0',
    'class' => 'validate-digits',
    'backend' => '',
    'frontend' => '',
    'source' => '',
    'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
    'visible' => true,
    'required' => false,
    'user_defined' => true,
    'searchable' => false,
    'filterable' => false,
    'comparable' => false,
    'visible_on_front' => true,
    'visible_in_advanced_search' => false,
    'unique' => false,
    'apply_to' => 'simple,virtual',
));
$installer->updateAttribute('catalog_product', 'for_friend', 'frontend_class', 'validate-digits');
$installer->updateAttribute('catalog_product', 'for_friend', 'is_global', Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE);
$installer->updateAttribute('catalog_product', 'for_friend', 'apply_to', 'simple,virtual');

//create the 'Coupon valid till' attribute
$installer->addAttribute('catalog_product', 'enjoyby', array(
    'group' => 'Deal Information',
    'label' => 'Coupon valid till',
    'type' => 'datetime',
    'input' => 'date',
    'default' => '',
    'class' => '',
    'backend' => 'eav/entity_attribute_backend_datetime',
    'frontend' => 'eav/entity_attribute_frontend_datetime',
    'source' => '',
    'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
    'visible' => true,
    'required' => false,
    'user_defined' => true,
    'searchable' => false,
    'filterable' => false,
    'comparable' => false,
    'visible_on_front' => true,
    'visible_in_advanced_search' => false,
    'unique' => false,
    'apply_to' => 'simple,virtual',
));
$installer->updateAttribute('catalog_product', 'enjoyby', 'is_global', Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE);
$installer->updateAttribute('catalog_product', 'enjoyby', 'apply_to', 'simple,virtual');

//create the 'Fine Print' attribute
$installer->addAttribute('catalog_product', 'fineprint', array(
    'group' => 'Deal Information',
    'label' => 'Fine Print',
    'type' => 'text',
    'input' => 'textarea',
    'default' => '',
    'class' => '',
    'backend' => '',
    'frontend' => '',
    'source' => '',
    'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
    'visible' => true,
    'required' => false,
    'user_defined' => true,
    'searchable' => false,
    'filterable' => false,
    'comparable' => false,
    'wysiwyg_enabled' => true,
    'visible_on_front' => true,
    'visible_in_advanced_search' => false,
    'unique' => false,
    'apply_to' => 'simple,virtual',
));
$installer->updateAttribute('catalog_product', 'fineprint', 'is_global', Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE);
$installer->updateAttribute('catalog_product', 'fineprint', 'apply_to', 'simple,virtual');
$installer->updateAttribute('catalog_product', 'fineprint', 'is_wysiwyg_enabled', 1);

//create the 'Hightlights' attribute
$installer->addAttribute('catalog_product', 'hightlight', array(
    'group' => 'Deal Information',
    'label' => 'Hightlights',
    'type' => 'text',
    'input' => 'textarea',
    'default' => '',
    'class' => '',
    'backend' => '',
    'frontend' => '',
    'source' => '',
    'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
    'visible' => true,
    'required' => false,
    'user_defined' => true,
    'searchable' => false,
    'filterable' => false,
    'comparable' => false,
    'wysiwyg_enabled' => true,
    'visible_on_front' => true,
    'visible_in_advanced_search' => false,
    'unique' => false,
    'apply_to' => 'simple,virtual',
));
$installer->updateAttribute('catalog_product', 'hightlight', 'is_global', Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE);
$installer->updateAttribute('catalog_product', 'hightlight', 'apply_to', 'simple,virtual');
$installer->updateAttribute('catalog_product', 'hightlight', 'is_wysiwyg_enabled', 1);

//create the 'Appear in Recent deals' attribute
$installer->addAttribute('catalog_product', 'featured', array(
    'group' => 'Deal Information',
    'label' => 'Appear in Recent deals',
    'type' => 'int',
    'input' => 'select',
    'default' => '',
    'class' => '',
    'backend' => '',
    'frontend' => '',
    'source' => 'eav/entity_attribute_source_boolean',
    'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
    'visible' => true,
    'required' => false,
    'user_defined' => true,
    'searchable' => false,
    'filterable' => false,
    'comparable' => false,
    'visible_on_front' => true,
    'visible_in_advanced_search' => false,
    'unique' => false,
    'apply_to' => 'simple,virtual',
));
$installer->updateAttribute('catalog_product', 'featured', 'is_global', Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE);
$installer->updateAttribute('catalog_product', 'featured', 'apply_to', 'simple,virtual');

//create the 'Deal City' attribute
$installer->addAttribute('catalog_product', 'dealcity', array(
    'group' => 'Deal Information',
    'label' => 'Deal City',
    'type' => 'varchar',
    'input' => 'multiselect',
    'default' => '',
    'class' => '',
    'backend' => 'eav/entity_attribute_backend_array',
    'frontend' => '',
    'source' => '',
    'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
    'visible' => true,
    'required' => true,
    'user_defined' => true,
    'searchable' => true,
    'filterable' => false,
    'comparable' => false,
    'visible_on_front' => true,
    'option' => array(
        'value' => array('newyork' => array(0 => 'New York', 1 => 'New York'), 'Hartford' => array(0 => 'Hartford', 1 => 'Hartford'), 'Cleveland' => array(0 => 'Cleveland', 1 => 'Cleveland')),
        'order' => array('newyork' => '0', 'Hartford' => '1', 'Cleveland' => '2')
    ),
    'visible_in_advanced_search' => true,
    'unique' => false,
    'apply_to' => 'simple,virtual',
));
$installer->updateAttribute('catalog_product', 'dealcity', 'is_global', Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE);
$installer->updateAttribute('catalog_product', 'dealcity', 'apply_to', 'simple,virtual');

//create the 'Deal Category' attribute
$installer->addAttribute('catalog_product', 'dealcategory', array(
    'group' => 'Deal Information',
    'label' => 'Deal Category',
    'type' => 'varchar',
    'input' => 'select',
    'default' => '',
    'class' => '',
    'backend' => 'eav/entity_attribute_backend_array',
    'frontend' => '',
    'source' => '',
    'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
    'visible' => true,
    'required' => true,
    'user_defined' => true,
    'searchable' => true,
    'filterable' => false,
    'comparable' => false,
    'visible_on_front' => true,
    'option' => array(
        'value' => array('maindeal' => array(0 => 'Main Deal', 1 => 'Main Deal'), 'sidedeal' => array(0 => 'Side Deal', 1 => 'Side Deal')),
        'order' => array('maindeal' => 0, 'sidedeal' => 1)
    ),
    'visible_in_advanced_search' => true,
    'unique' => false,
    'apply_to' => 'simple,virtual',
));
$installer->updateAttribute('catalog_product', 'dealcategory', 'is_global', Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE);
$installer->updateAttribute('catalog_product', 'dealcategory', 'apply_to', 'simple,virtual');

//create the 'Customer email' attribute
$installer->addAttribute('catalog_product', 'customeremail', array(
    'group' => 'Deal Information',
    'label' => 'Email',
    'type' => 'varchar',
    'input' => 'text',
    'default' => '',
    'class' => 'validate-email',
    'backend' => '',
    'frontend' => '',
    'source' => '',
    'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
    'visible' => true,
    'required' => true,
    'user_defined' => true,
    'searchable' => false,
    'filterable' => false,
    'comparable' => false,
    'visible_on_front' => true,
    'visible_in_advanced_search' => false,
    'unique' => false,
    'apply_to' => 'simple,virtual',
));
$installer->updateAttribute('catalog_product', 'customeremail', 'frontend_class', 'validate-email');
$installer->updateAttribute('catalog_product', 'customeremail', 'is_global', Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE);
$installer->updateAttribute('catalog_product', 'customeremail', 'apply_to', 'simple,virtual');

//create the 'Company address' attribute
$installer->addAttribute('catalog_product', 'customersite', array(
    'group' => 'Deal Information',
    'label' => 'Company address',
    'type' => 'text',
    'input' => 'textarea',
    'default' => '',
    'class' => '',
    'backend' => '',
    'frontend' => '',
    'source' => '',
    'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
    'visible' => true,
    'required' => false,
    'user_defined' => true,
    'searchable' => false,
    'filterable' => false,
    'comparable' => false,
    'visible_on_front' => true,
    'visible_in_advanced_search' => false,
    'unique' => false,
    'apply_to' => 'simple,virtual',
));
$installer->updateAttribute('catalog_product', 'customersite', 'is_global', Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE);
$installer->updateAttribute('catalog_product', 'customersite', 'apply_to', 'simple,virtual');

//create the 'Phone' attribute
$installer->addAttribute('catalog_product', 'questions', array(
    'group' => 'Deal Information',
    'label' => 'Phone',
    'type' => 'varchar',
    'input' => 'text',
    'default' => '',
    'class' => 'validate-digits',
    'backend' => '',
    'frontend' => '',
    'source' => '',
    'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
    'visible' => true,
    'required' => false,
    'user_defined' => true,
    'searchable' => false,
    'filterable' => false,
    'comparable' => false,
    'visible_on_front' => true,
    'visible_in_advanced_search' => false,
    'unique' => false,
    'apply_to' => 'simple,virtual',
));
$installer->updateAttribute('catalog_product', 'questions', 'frontend_class', 'validate-digits');
$installer->updateAttribute('catalog_product', 'questions', 'is_global', Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE);
$installer->updateAttribute('catalog_product', 'questions', 'apply_to', 'simple,virtual');

//create the 'customer website' attribute
$installer->addAttribute('catalog_product', 'customer_website', array(
    'group' => 'Deal Information',
    'label' => 'Company Website',
    'type' => 'varchar',
    'input' => 'text',
    'default' => '',
    'class' => '',
    'backend' => '',
    'frontend' => '',
    'source' => '',
    'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
    'visible' => true,
    'required' => false,
    'user_defined' => true,
    'searchable' => false,
    'filterable' => false,
    'comparable' => false,
    'visible_on_front' => true,
    'visible_in_advanced_search' => false,
    'unique' => false,
    'apply_to' => 'simple,virtual',
));
$installer->updateAttribute('catalog_product', 'customer_website', 'is_global', Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE);
$installer->updateAttribute('catalog_product', 'customer_website', 'apply_to', 'simple,virtual');


//create the 'Map' attribute
$installer->addAttribute('catalog_product', 'sitemap', array(
    'group' => 'Deal Information',
    'label' => 'Map',
    'type' => 'text',
    'input' => 'textarea',
    'default' => '',
    'class' => '',
    'backend' => '',
    'frontend' => '',
    'source' => '',
    'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
    'visible' => true,
    'required' => false,
    'user_defined' => true,
    'searchable' => false,
    'filterable' => false,
    'comparable' => false,
    'visible_on_front' => true,
    'visible_in_advanced_search' => false,
    'unique' => false,
    'apply_to' => 'simple,virtual',
));
$installer->updateAttribute('catalog_product', 'sitemap', 'is_global', Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE);
$installer->updateAttribute('catalog_product', 'sitemap', 'apply_to', 'simple,virtual');

//create the 'Merchant' attribute
$installer->addAttribute('catalog_product', 'merchant', array(
    'group' => 'Deal Information',
    'label' => 'merchant',
    'type' => 'varchar',
    'input' => 'text',
    'default' => '',
    'class' => '',
    'backend' => '',
    'frontend' => '',
    'source' => '',
    'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
    'visible' => true,
    'required' => false,
    'user_defined' => true,
    'searchable' => false,
    'filterable' => false,
    'comparable' => false,
    'visible_on_front' => true,
    'visible_in_advanced_search' => false,
    'unique' => false,
    'apply_to' => 'simple,virtual',
));
$installer->updateAttribute('catalog_product', 'questions', 'is_global', Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE);
$installer->updateAttribute('catalog_product', 'questions', 'apply_to', 'simple,virtual');

//$installer->updateAttribute('catalog_product', 'featured', 'is_wysiwyg_enabled', 1);

//create a config table
$installer->run("
  CREATE TABLE IF NOT EXISTS {$this->getTable('gclone_config_data')} (
  `config_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `path` varchar(255) NOT NULL DEFAULT 'general',
  `value` text NOT NULL,
  PRIMARY KEY (`config_id`),
  UNIQUE KEY `config_scope` (`path`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
");

$attributeId = Mage::getResourceModel('eav/entity_attribute')->getIdByCode('catalog_product', 'dealcategory');
$attribute = Mage::getModel('eav/config')->getAttribute('catalog_product', $attributeId); // get the cities attribute id 562


foreach ($attribute->getSource()->getAllOptions(true, true) as $option) {
    if ($option['value'] != '') {
        $label = strtolower($option['label']);
        $label = str_replace(' ', '', $label);
        $value = $option['value'];
        $installer->run("INSERT INTO {$this->getTable('gclone_config_data')} (`path`, `value`) VALUES ('deal/category/$label', '$value')");
    }
}
//insert url rewrite for the active, recent and upcoming deals
$installer->run("
    INSERT INTO {$this->getTable('core_url_rewrite')} (`store_id`, `category_id`, `product_id`, `id_path`, `request_path`, `target_path`, `is_system`, `options`, `description`) VALUES (0, NULL, NULL, 'deal/index/active', 'active-deals.html', 'deal/index/active', 0, '', 'Active Deals'),
(0, NULL, NULL, 'deal/index/recent', 'recent-deals.html', 'deal/index/recent', 0, '', 'Recent Deals'),
(0, NULL, NULL, 'deal/index/upcoming', 'upcoming-deals.html', 'deal/index/upcoming', 0, '', 'Upcoming Deals'),
(0, NULL, NULL, 'deal/index/subscribepage', 'subscribepage.html', 'deal/index/subscribepage', 0, '', 'Subscribe Page')
");

//Create the site_turnover table
$installer->run("
    CREATE TABLE IF NOT EXISTS {$this->getTable('site_turnover')} (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `saved_money` int(11) NOT NULL,
  `total_purchased` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
");

$installer->endSetup();
