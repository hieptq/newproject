<?php

class Gclone_Rssfeed_Block_Rssfeed extends Mage_Core_Block_Template {

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
    public function _prepareLayout() {
        return parent::_prepareLayout();
    }

    public function getRssfeed() {
        if (!$this->hasData('rssfeed')) {
            $this->setData('rssfeed', Mage::registry('rssfeed'));
        }
        return $this->getData('rssfeed');
    }

    public function generateActiveFeeds() {
        // Create array to store the RSS feed entries
        $entries = array();

        $storeId = Mage::app()->getStore()->getStoreId();

        $newurl = Mage::getUrl('rssfeed/index/feed/store_id/' . $storeId);
        $title = $this->__('New Products from %s', Mage::app()->getStore()->getGroup()->getName());
        $lang = Mage::getStoreConfig('general/locale/code');
        $product = Mage::getModel('catalog/product');
        $todayDate = $product->getResource()->formatDate(time());

        $_productCollection = $product->getCollection()
                        ->setStoreId($storeId);
        $_productCollection->addFieldToFilter(array(
            array('attribute' => 'Status', 'eq' => '1'),
        ));

        $_productCollection->addAttributeToSelect('special_from_date');
        $_productCollection->addAttributeToSelect('special_to_date');
        $_productCollection->addAttributeToSelect('starttime');
        $_productCollection->addAttributeToSelect('time');
        $_productCollection->addAttributeToSelect('name');
        $_productCollection->addAttributeToSelect('description');
        $_productCollection->addAttributeToSelect('fineprint');
        $_productCollection->addAttributeToSelect('dealcategory');
        $_productCollection->addAttributeToSelect('thumbnail');

        $currentTime = Mage_Core_Model_Locale::date(null, null, "en_US", true);

        if (count($_productCollection) > 0) {
            foreach ($_productCollection as $_product) {
                $productUrl = $_product->getProductUrl();
                $final = Mage::getSingleton('core/session')->getTotalCities();
                $catName = $_product->getAttributeText('dealcategory');
                $galleryImages = (string)Mage::helper('catalog/image')->init($_product, 'thumbnail');
                $ProductToDate = $_product->getResource()->formatDate($_product->getspecial_to_date(), false);
                $ProductFromDate = $_product->getResource()->formatDate($_product->getspecial_from_date(), false);
                $Fromtime = strtotime($ProductFromDate);
                if ($Fromtime < strtotime($currentTime)) {
                    if (strtotime($ProductToDate . ' ' . $_product->getTime()) > strtotime($currentTime)) {
                        if (isset($galleryImages)) {
                            $productImage = $galleryImages;
                        } else {
                            $productImage = Mage::getBaseUrl() . 'media/catalog/product/placeholder/default/nodeal.jpg';
                        }

                        $entry = array('title' => $_product->getName(),
                            'description' => strip_tags($_product->getdescription()),
                            'link' => $productUrl,
                            'content' => $_product->getFineprint(),
                            'lastUpdate' => $Fromtime,
                            'category' => array(
                                array(
                                    'term' => $catName,
                                ),
                                array(
                                    'term' => $this->__('Active Deals'),
                                )
                            ),
//                            'source' => array(
//                                'title' => $final[$_product->getcities()],
//                                'url' => Mage::getBaseUrl() . str_replace(' ', '+', $final[$_product->getcities()]),
//                            ),
                            'enclosure' => array(
                                array(
                                    'url' => $productImage,
                                    'type' => 'image/jpeg',
                                    'length' => '150'
                            ))
                        );

                        array_push($entries, $entry);
                    }
                }
            }
        }


        $configTitle = Mage::getStoreConfig('rssfeed/active/feedtitle');
        if ($configTitle == '') {
            $configTitle = Mage::getStoreConfig('general/store_information/name').' Feeds';            
        }
        $configLink = Mage::getStoreConfig('rssfeed/rssfeed/link');
        if ($configLink == '') {
            $configLink = Mage::getBaseUrl();
        }
        // Create the RSS array
        $rss = array(
            'title' => $configTitle,
            'link' => $configLink,
            'language' => $lang,
            'charset' => 'UTF-8',
            'entries' => $entries
        );

        // Import the array
        $feed = Zend_Feed::importArray($rss, 'rss');

        // Write the feed to a variable
        $rssFeed = $feed->saveXML();


       
        $url = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA);

        $file = array();
        if (isset($url)) {
            $file['dom'] = $url . '/rss/active/' . $storeId . '.xml';
        }
       
        $file['download'] = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA) . '/rss/active/' . $storeId . '.xml';
        // Write the feed to a file residing in /media/rss/active/
        $fh = fopen($file['dom'], "w");
        fwrite($fh, $rssFeed);
        fclose($fh);
        return $file;
    }

    public function generateUpcomingFeeds() {
        // Create array to store the RSS feed entries
        $entries = array();

        $storeId = Mage::app()->getStore()->getStoreId();

        $newurl = Mage::getUrl('rssfeed/index/feed/store_id/' . $storeId);
        $title = $this->__('New Products from %s', Mage::app()->getStore()->getGroup()->getName());
        $lang = Mage::getStoreConfig('general/locale/code');
        $product = Mage::getModel('catalog/product');
        $todayDate = $product->getResource()->formatDate(time());

        $_productCollection = $product->getCollection()
                        ->setStoreId($storeId);
        $_productCollection->addFieldToFilter(array(
            array('attribute' => 'Status', 'eq' => '1'),
        ));

        $_productCollection->addAttributeToSelect('special_from_date');
        $_productCollection->addAttributeToSelect('special_to_date');
        $_productCollection->addAttributeToSelect('starttime');
        $_productCollection->addAttributeToSelect('time');
        $_productCollection->addAttributeToSelect('name');
        $_productCollection->addAttributeToSelect('description');
        $_productCollection->addAttributeToSelect('fineprint');
        $_productCollection->addAttributeToSelect('dealcategory');
        $_productCollection->addAttributeToSelect('thumbnail');

        $currentTime = Mage_Core_Model_Locale::date(null, null, "en_US", true);

        if (count($_productCollection) > 0) {
            foreach ($_productCollection as $_product) {
                $productUrl = $_product->getProductUrl();
                $final = Mage::getSingleton('core/session')->getTotalCities();
                $catName = $_product->getAttributeText('dealcategory');
                $galleryImages = (string)Mage::helper('catalog/image')->init($_product, 'thumbnail');
                $ProductToDate = $_product->getResource()->formatDate($_product->getspecial_to_date(), false);
                $ProductFromDate = $_product->getResource()->formatDate($_product->getspecial_from_date(), false);
                $Fromtime = strtotime($ProductFromDate);
                if ($Fromtime > strtotime($currentTime)) {
                    if (strtotime($ProductToDate . ' ' . $_product->getTime()) > strtotime($currentTime)) {
                         if (isset($galleryImages)) {
                            $productImage = $galleryImages;
                        } else {
                            $productImage = Mage::getBaseUrl() . 'media/catalog/product/placeholder/default/nodeal.jpg';
                        }

                        $entry = array('title' => $_product->getName(),
                            'description' => strip_tags($_product->getdescription()),
                            'link' => Mage::getBaseUrl() . 'upcoming-deals.html',
                            'content' => $_product->getFineprint(),
                            'lastUpdate' => $Fromtime,
                            'category' => array(
                                array(
                                    'term' => $catName,
                                ),
                                array(
                                    'term' => $this->__('Upcoming Deals'),
                                )
                            ),
//                            'source' => array(
//                                'title' => $final[$_product->getcities()],
//                                'url' => Mage::getBaseUrl() . str_replace(' ', '+', $final[$_product->getcities()]),
//                            ),
                            'enclosure' => array(
                                array(
                                    'url' => $productImage,
                                    'type' => 'image/jpeg',
                                    'length' => '150'
                            ))
                        );

                        array_push($entries, $entry);
                    }
                }
            }
        }

        $configTitle = Mage::getStoreConfig('rssfeed/upcoming/feedtitle');
        if ($configTitle == '') {
            $configTitle = Mage::getStoreConfig('general/store_information/name').' Feeds';
        }
        $configLink = Mage::getStoreConfig('rssfeed/rssfeed/link');
        if ($configLink == '') {
            $configLink = Mage::getBaseUrl();
        }
        // Create the RSS array
        $rss = array(
            'title' => $configTitle,
            'link' => $configLink,
            'language' => $lang,
            'charset' => 'UTF-8',
            'entries' => $entries
        );

        // Import the array
        $feed = Zend_Feed::importArray($rss, 'rss');

        // Write the feed to a variable
        $rssFeed = $feed->saveXML();


        $url = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA);

        $file = array();
        if (isset($url)) {
            $file['dom'] = $url . '/rss/upcoming/' . $storeId . '.xml';
        }
        $file['download'] = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA) . 'rss/upcoming/' . $storeId . '.xml';
        // Write the feed to a file residing in /media/rss/upcoming/
        $fh = fopen($file['dom'], "w");
        fwrite($fh, $rssFeed);
        fclose($fh);
        return $file;
    }

    public function generateRecentFeeds() {
        // Create array to store the RSS feed entries
        $entries = array();

        $storeId = Mage::app()->getStore()->getStoreId();

        $newurl = Mage::getUrl('rssfeed/index/feed/store_id/' . $storeId);
        $title = $this->__('New Products from %s', Mage::app()->getStore()->getGroup()->getName());
        $lang = Mage::getStoreConfig('general/locale/code');
        $product = Mage::getModel('catalog/product');
        $todayDate = $product->getResource()->formatDate(time());

        $_productCollection = $product->getCollection()
                        ->setStoreId($storeId);
        $_productCollection->addFieldToFilter(array(
            array('attribute' => 'Status', 'eq' => '1'),
        ));

        $_productCollection->addAttributeToSelect('special_from_date');
        $_productCollection->addAttributeToSelect('special_to_date');
        $_productCollection->addAttributeToSelect('starttime');
        $_productCollection->addAttributeToSelect('time');
        $_productCollection->addAttributeToSelect('name');
        $_productCollection->addAttributeToSelect('description');
        $_productCollection->addAttributeToSelect('fineprint');
        $_productCollection->addAttributeToSelect('dealcategory');
        $_productCollection->addAttributeToSelect('thumbnail');

        $currentTime = Mage_Core_Model_Locale::date(null, null, "en_US", true);

        if (count($_productCollection) > 0) {
            foreach ($_productCollection as $_product) {
                $productUrl = $_product->getProductUrl();
                $final = Mage::getSingleton('core/session')->getTotalCities();

                $catName = $_product->getAttributeText('dealcategory');

                $galleryImages = (string)Mage::helper('catalog/image')->init($_product, 'thumbnail');
                $ProductToDate = $_product->getResource()->formatDate($_product->getspecial_to_date(), false);
                $ProductFromDate = $_product->getResource()->formatDate($_product->getspecial_from_date(), false);
                $Fromtime = strtotime($ProductFromDate);
                if ($Fromtime < strtotime($currentTime)) {
                    if (strtotime($ProductToDate . ' ' . $_product->getTime()) < strtotime($currentTime)) {
                         if (isset($galleryImages)) {
                            $productImage = $galleryImages;
                        } else {
                            $productImage = Mage::getBaseUrl() . 'media/catalog/product/placeholder/default/nodeal.jpg';
                        }

                        $entry = array('title' => $_product->getName(),
                            'description' => strip_tags($_product->getdescription()),
                            'link' => $productUrl,
                            'content' => $_product->getFineprint(),
                            'lastUpdate' => strtotime($ProductToDate . ' ' . $_product->getTime()),
                            'category' => array(
                                array(
                                    'term' => $catName,
                                ),
                                array(
                                    'term' => $this->__('Recent Deals'),
                                )
                            ),
//                            'source' => array(
//                                'title' => $final[$_product->getcities()],
//                                'url' => Mage::getBaseUrl() . str_replace(' ', '+', $final[$_product->getcities()]),
//                            ),
                            'enclosure' => array(
                                array(
                                    'url' => $productImage,
                                    'type' => 'image/jpeg',
                                    'length' => '150'
                            ))
                        );

                        array_push($entries, $entry);
                    }
                }
            }
        }

        $configTitle = Mage::getStoreConfig('rssfeed/recent/feedtitle');
        if ($configTitle == '') {
            $configTitle = Mage::getStoreConfig('general/store_information/name').' Feeds';
        }
        $configLink = Mage::getStoreConfig('rssfeed/rssfeed/link');
        if ($configLink == '') {
            $configLink = Mage::getBaseUrl();
        }
        // Create the RSS array
        $rss = array(
            'title' => $configTitle,
            'link' => $configLink,
            'language' => $lang,
            'charset' => 'UTF-8',
            'entries' => $entries
        );

        // Import the array
        $feed = Zend_Feed::importArray($rss, 'rss');

        // Write the feed to a variable
        $rssFeed = $feed->saveXML();


       $url = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA);

        $file = array();
        if (isset($url)) {
            $file['dom'] = $url . '/rss/recent/' . $storeId . '.xml';
        }
        $file['download'] = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA). '/rss/recent/' . $storeId . '.xml';
        // Write the feed to a file residing in /media/rss/recent/
        $fh = fopen($file['dom'], "w");
        fwrite($fh, $rssFeed);
        fclose($fh);
        return $file;
    }

}