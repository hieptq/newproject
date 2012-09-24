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

class Gclone_Dealcoupon_Block_Coupon extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getDealcoupon()     
     { 
        if (!$this->hasData('dealcoupon')) {
            $this->setData('dealcoupon', Mage::registry('dealcoupon'));
        }
        return $this->getData('dealcoupon');
        
    }


    public function getPaymentInfoHtml() {
        return $this->getChildHtml('payment_info');
    }

    public function getOrder($orderId) {
        //return Mage::registry('current_order');
        $resource = Mage::getSingleton('core/resource');
        $currentdeal = $resource->getConnection('core_write');
        $read = $resource->getConnection('catalog_read');
        $orderTable = $resource->getTableName('sales/order');
        $orderItemTable = $resource->getTableName('sales/order_item');
        $selectOrders = $read->select()
                                ->from(array('cp' => $orderTable))
                                ->join(array('pei' => $orderItemTable), 'pei.order_id=cp.entity_id', array())
                                ->where('pei.order_id in (?)', $orderId);
                $orders_list = $read->fetchAll($selectOrders);
        return $orders_list;
    }

    protected function _prepareItem(Mage_Core_Block_Abstract $renderer) {
        $renderer->setPrintStatus(true);

        return parent::_prepareItem($renderer);
    }

    public function getCouponCode($orderId) {
        $resource = Mage::getSingleton('core/resource');
        $orderTable = $resource->getTableName('ordercustomer');
        $read = $resource->getConnection('read');
        $tprefix = (string) Mage::getConfig()->getTablePrefix();
        $select = $read->select()
                        ->from(array('cp' => $orderTable))
                        ->where('cp.product_id=?', $orderId);

        $orders_list = $read->fetchAll($select);
        return $orders_list;
    }

    public function getProductDetail($productId) {
        $product = Mage::getModel('catalog/product')->load($productId);
        return $product;
    }

    public function getCouponPdf($_order, $orderId, $no, $identifier) {
        $pdf = Mage::getModel('dealcoupon/invoice')->getCouponPdf($_order, $orderId, $no);
        return $pdf;
    }
}