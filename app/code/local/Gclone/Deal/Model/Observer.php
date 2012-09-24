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

class Gclone_Deal_Model_Observer {

    public function processOnOrderSave($observer) {
        $order = $observer->getEvent()->getOrder();
		$orderid = $order->getIncrementId();
        $resource = Mage::getSingleton('core/resource');
        $read = $resource->getConnection('catalog_read');
        $orderTable = $resource->getTableName('sales/order');
        $orderItemTable = $resource->getTableName('sales/order_item');
        $tprefix = (string) Mage::getConfig()->getTablePrefix();
        $siteTurnOverTable = $tprefix . "site_turnover";

        $select = $read->select()
                        ->from(array('cp' => $orderTable), array('totalcount' => 'sum(cp.total_qty_ordered)', 'orderid' => 'pei.order_id', 'firstname' => 'cp.customer_firstname', 'lastname' => 'cp.customer_lastname', 'entityid' => 'cp.entity_id'))
                        ->join(array('pei' => $orderItemTable), 'pei.order_id=cp.entity_id', array('productid' => 'pei.product_id'))
                        ->where('cp.increment_id in (?)', $orderid);
        $orders_list = $read->fetchAll($select);
        
        $quantity = floor($orders_list[0]['totalcount']);
        $orderid = $orders_list[0]['orderid'];
        $order_id = $orders_list[0]['entityid'];
        $model = Mage::getModel('catalog/product'); //getting product model
        $productId = $orders_list[0]['productid'];
        $_product = $model->load($productId);

        //site turnover
        $pri = $_product->getPrice() - $_product->getSpecialPrice();
        $saved = $pri * $quantity;

        $executeQuery = $read->query("insert into $siteTurnOverTable values ('',$productId,$order_id,$saved,$quantity)");
        
    	$sessiongift = Mage::getSingleton('core/session');
        if($sessiongift->getorderemail()) {
            $lastOrderId = $order->getEntityId();
            $customerId = Mage::getSingleton('customer/session')->getCustomerId();
            $tprefix = (string)Mage::getConfig()->getTablePrefix();
            $write = Mage::getSingleton('core/resource')->getConnection('core_write');
            $giftCouponCheck = $write->fetchRow("select max(gift_message_id) as idgift from ".$tprefix."gift_message");
            $giftid = '';
            if(isset($giftCouponCheck['idgift'])) {
                $giftid = $giftCouponCheck['idgift'];
            }
            
            $write->query("UPDATE ".$tprefix."gift_message set order_id ='".$lastOrderId."'where order_id  = '0' and customer_id = '".$customerId."' and gift_message_id = '".$giftid."'");
            $sessiongift->setorderemail('');
            $sessiongift->setorderfrom('');
            $sessiongift->setorderto('');
            $sessiongift->setordermessage('');
        }
        
	 }


}