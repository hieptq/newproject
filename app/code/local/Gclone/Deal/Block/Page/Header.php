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
/*
 * Contus Support Interactive
 */

class Gclone_Deal_Block_Page_Header extends Mage_Core_Block_Template {

	public function _construct() {
		$websiteId = Mage::app()->getStore()->getWebsiteId();
		$websites = Mage::getModel('core/website')
		->getCollection();
		foreach($websites as $website) {
			if($websiteId == $website->getWebsiteId()){
				$websiteCode = $website->getCode();
			}
		}
                $id = Mage::app()->getRequest()->getParam('id');
		$defaultHome = Mage::getStoreConfig('emailnewsletter/homepage/as_default_homepage');
		if ($defaultHome == 1 && $websiteCode != 'facebook') {
			$flag = 0;
			$task = Mage::app()->getRequest()->getParam('task');
			$skip = Mage::app()->getRequest()->getPost('skips');

            // Both the condition has been checked together 
			if(isset($id) || $skip == 1 || $task == 'confirmSubscribe') {
				$flag = 1;				
				$cookieExpires = Mage::getSingleton('core/cookie')->getLifetime();
				Mage::getSingleton('core/cookie')->set('confirmSubscribe',$cookieExpires, (3600 * 24 * 365 * 2));
			}


			if ($flag == 0 && Mage::getSingleton('core/cookie')->get('confirmSubscribe') == '' ) {
				$url = Mage::getBaseUrl() . 'subscribepage.html';
				//Mage::app()->getResponse()->setHeader("Location", $url)->sendHeaders();
                                Mage::app()->getFrontController()->getResponse()->setRedirect($url);
			}
		}
		//noRoute
		$request = Mage::app()->getFrontController()->getRequest();
		$actionName = $request->getActionName();
		if ($actionName == 'noRoute') {
			$url = Mage::getBaseUrl() . 'no-route';
			//Mage::app()->getResponse()->setHeader("Location", $url)->sendHeaders();
                        Mage::app()->getFrontController()->getResponse()->setRedirect($url);
		}
		$this->setTemplate('page/html/header.phtml');
	}

}

?>