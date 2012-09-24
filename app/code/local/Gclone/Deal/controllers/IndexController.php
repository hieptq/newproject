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
class Gclone_Deal_IndexController extends Mage_Core_Controller_Front_Action {

    public function indexAction() {
        $cityId = Mage::getModel('deal/deal')->fetchCity();
        $productIds = Mage::getModel('deal/deal')->fetchDeals($cityId);
        Mage::getSingleton('core/session')->setProductIds($productIds);
        Mage::getSingleton('core/session')->setDealModule('1');

        $this->loadLayout();
        $id = Mage::app()->getRequest()->getParam('id');
        if (isset($id)) {
            $productId = $id;
            $model = Mage::getModel('catalog/product'); //getting product model
            $_product = $model->load($productId);
            $this->getLayout()->getBlock('head')->setTitle(htmlspecialchars($_product->getMetaTitle()));
            $this->getLayout()->getBlock('head')->setKeywords(htmlspecialchars($_product->getMetaKeyword()));
            $this->getLayout()->getBlock('head')->setDescription(htmlspecialchars($_product->getMetaDescription()));
        } else {
            $title = Mage::getStoreConfig('deal/homepage/title');
            if ($title == '') {
                $title = "Today's Deal";
            }
            $metaDescription = Mage::getStoreConfig('deal/homepage/metadescription');
            $metaKeywords = Mage::getStoreConfig('deal/homepage/metakeywords');

            $this->getLayout()->getBlock('head')->setTitle(htmlspecialchars($title));
            $this->getLayout()->getBlock('head')->setKeywords(htmlspecialchars($metaKeywords));
            $this->getLayout()->getBlock('head')->setDescription(htmlspecialchars($metaDescription));
        }
        $this->renderLayout();
    }

    public function viewAction() {
        $id = Mage::app()->getRequest()->getParam('id');
        $productIds = array();
        $productIds[0] = $id;
        Mage::getModel('deal/deal')->fetchCity();
        Mage::getSingleton('core/session')->setProductIds($productIds);
        Mage::getSingleton('core/session')->setDealModule('1');

        $this->loadLayout();

        if (isset($id)) {
            $productId = $id;
            $model = Mage::getModel('catalog/product'); //getting product model
            $_product = $model->load($productId);
            $this->getLayout()->getBlock('head')->setTitle(htmlspecialchars($_product->getMetaTitle()));
            $this->getLayout()->getBlock('head')->setKeywords(htmlspecialchars($_product->getMetaKeyword()));
            $this->getLayout()->getBlock('head')->setDescription(htmlspecialchars($_product->getMetaDescription()));
        }
        $this->renderLayout();
    }

    public function activeAction() {
        $this->loadLayout();
        $this->getLayout()->getBlock('head')->setTitle($this->__('Active Deals'));
        $this->renderLayout();
    }

    public function recentAction() {
        $this->loadLayout();
        $this->getLayout()->getBlock('head')->setTitle($this->__('Recent Deals'));
        $this->renderLayout();
    }

    public function upcomingAction() {
        $this->loadLayout();
        $this->getLayout()->getBlock('head')->setTitle($this->__('Upcoming Deals'));
        $this->renderLayout();
    }
    public function subscribepageAction() {        
        $this->loadLayout();
        $this->getLayout()->getBlock('head')->setTitle($this->__('Subscribe for newsletter'));
        $this->renderLayout();
    }

}