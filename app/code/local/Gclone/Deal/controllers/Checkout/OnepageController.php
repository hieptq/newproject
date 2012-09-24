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

require_once 'Mage/Checkout/controllers/OnepageController.php';

class Gclone_Deal_Checkout_OnepageController extends Mage_Checkout_OnepageController {

	/**
	 * Checkout page
	 */
	public function indexAction() {
		if (Mage_Customer_Helper_Data::isLoggedIn()) {
			$products = array();
			$product_qty = array();
			$orderStatus[0] = "complete";
			$orderStatus[1] = "processing";

			$resource = Mage::getSingleton('core/resource');
			$read = $resource->getConnection('core_read');
			$resultGiftMessage = array();

			$orders = Mage::getResourceModel('sales/order_collection')
			->addFieldToSelect('*')
			->addFieldToFilter('customer_id', Mage::getSingleton('customer/session')->getCustomer()->getId())
			->addFieldToFilter('state', array('in' => Mage::getSingleton('sales/order_config')->getVisibleOnFrontStates()))
			->setOrder('created_at', 'desc');
			foreach ($orders as $order) {
				$items = $order->getItemsCollection();
				$qty = array();
				// checking for order status.
				if (in_array($order->getStatus(), $orderStatus)) {
					foreach ($items as $item) {
						if (!in_array($item->getProductId(), $products)) {
							$products[] = $item->getProductId();
							$product_qty[$item->getProductId()] = $item->getQtyOrdered();
						} else {
							$product_qty[$item->getProductId()] = $product_qty[$item->getProductId()] + $item->getQtyOrdered();
						}

						//gift message details
						$checkFriend = 0;
						$sessiongift = Mage::getSingleton('core/session');
						if($sessiongift->getorderemail()) {
							$checkFriend = 1;

							$giftMessage = $read->fetchAll("Select order_id, product_id  from " . $tprefix . "gift_message  where product_id ='".$item->getProductId()."' and customer_id='".Mage::getSingleton('customer/session')->getCustomer()->getId()."' and order_id != 0");
							//$qty = 0;
							foreach ($giftMessage as $value) {

								if($value['order_id'] == $item->getOrderId()){
									 
									$qty1[$value['product_id']] = $qty1[$value['product_id']] + $item->getQtyOrdered();
									$resultGiftMessage[$value['product_id']] = $qty1[$value['product_id']];
								}
							}
						}

					}
				}
			}

			$Cart = new Mage_Checkout_Model_Cart();
			// get all productIds of products in the current cart
			$cartItems = $Cart->getItems();
			foreach ($cartItems as $items123) {
				// load a product by id
				$product = Mage::getModel('catalog/product')->load($items123->getProductId());
				//per customer
				$perCustomer = 0;
				if ($product->getData('percustomer') != 0 && $product->getData('percustomer') != '') {
					if (in_array($items123->getProductId(), $products)) {
						if (($product_qty[$items123->getProductId()] + $items123->getQty()) > $product->getData('percustomer')) {
							$perCustomer = 1;

						}
					} else {
						if ($items123->getQty() > $product->getData('percustomer')) {
							$perCustomer = 1;

						}
					}
				}
				// Buy it for a friend
				$forFriend = 0;
				if ($product->getData('for_friend') != 0 && $product->getData('for_friend') != '') {
					if (in_array($items123->getProductId(), $products)) {
						if (($resultGiftMessage[$items123->getProductId()]) >= $product->getData('for_friend')) {
							$forFriend = 1;

						}
					}
				}

				if(($perCustomer == 0 || $perCustomer == 1) && ($forFriend == 1 && $checkFriend == 1)){
					Mage::getSingleton('checkout/session')->addError($this->__('Buy it for a friend - Maximum Quantity reached for') . ' ' . $items123->getName());
					$this->_redirect('checkout/cart');
					return;
				}
				elseif($perCustomer == 1 && ($forFriend == 0 && $checkFriend == 0)){
					Mage::getSingleton('checkout/session')->addError($this->__('Per Customer Maximum Quantity reached for') . ' ' . $items123->getName());
					$this->_redirect('checkout/cart');
					return;
				}
			}
		}
		// Maximum purchase per customer for guest checkout
		else {
			$Cart = new Mage_Checkout_Model_Cart();
			// get all productIds of products in the current cart
			$cartItems = $Cart->getItems();
			foreach ($cartItems as $items123) {
				// load a product by id
				$product = Mage::getModel('catalog/product')->load($items123->getProductId());
				if ($product->getData('percustomer') != 0 && $product->getData('percustomer') != '') {
					if (in_array($items123->getProductId(), $products)) {
						if (($product_qty[$items123->getProductId()] + $items123->getQty()) > $product->getData('percustomer')) {
							Mage::getSingleton('checkout/session')->addError($this->__('Maximum Quantity reached for Deal') . ' ' . $items123->getName());
							$this->_redirect('checkout/cart');
							return;
						}
					} else {
						if ($items123->getQty() > $product->getData('percustomer')) {
							Mage::getSingleton('checkout/session')->addError($this->__('Maximum Quantity reached for Deal') . ' ' . $items123->getName());
							$this->_redirect('checkout/cart');
							return;
						}
					}
				}
			}
		}
		if (!Mage::helper('checkout')->canOnepageCheckout()) {
			Mage::getSingleton('checkout/session')->addError($this->__('The onepage checkout is disabled.'));
			$this->_redirect('checkout/cart');
			return;
		}
		$quote = $this->getOnepage()->getQuote();
		if (!$quote->hasItems() || $quote->getHasError()) {
			$this->_redirect('checkout/cart');
			return;
		}
		if (!$quote->validateMinimumAmount()) {
			$error = Mage::getStoreConfig('sales/minimum_order/error_message');
			Mage::getSingleton('checkout/session')->addError($error);
			$this->_redirect('checkout/cart');
			return;
		}

		//Maximum one product to add the shopping cart
		$params = $this->getRequest()->getParams();
		$session = Mage::getSingleton('checkout/session');
		$productId = "";
		foreach ($session->getQuote()->getAllItems() as $item) {
			$productId = $item->getProductId();
		}
		$cartItems = Mage::helper('checkout/cart')->getCart()->getItemsCount();
		if ($params['product'] != $productId) {
				if(1==0){
			//if ($cartItems > 1) {
				Mage::getSingleton('checkout/session')->addError($this->__('Maximum one product to add the shopping cart.'));
				$this->_redirect('checkout/cart');
				return;
			}
		}

		Mage::getSingleton('checkout/session')->setCartWasUpdated(false);
		Mage::getSingleton('customer/session')->setBeforeAuthUrl(Mage::getUrl('*/*/*', array('_secure' => true)));
		$this->getOnepage()->initCheckout();
		$this->loadLayout();
		$this->_initLayoutMessages('customer/session');
		$this->getLayout()->getBlock('head')->setTitle($this->__('Checkout'));
		$this->renderLayout();
	}

	/**
	 * Order success action
	 */
	public function successAction() {
		$session = $this->getOnepage()->getCheckout();
		if (!$session->getLastSuccessQuoteId()) {
			$this->_redirect('checkout/cart');
			return;
		}

		$lastQuoteId = $session->getLastQuoteId();
		$lastOrderId = $session->getLastOrderId();
		/* contus new */
		$resource1 = Mage::getSingleton('core/resource');
		$currentdeal = $resource1->getConnection('core_write');
		$tprefix = (string) Mage::getConfig()->getTablePrefix();

		$order = Mage::getModel('sales/order')->load($lastOrderId);
		$incrementId = $order->getIncrementId();
		$items = $order->getAllItems();
		$products = array();

		foreach ($items as $itemId => $item) {
			$model = Mage::getModel('catalog/product');
			$productId = $item->getProductId();
			$productdetail = $model->load($item->getProductId());
			$incrementId = $productdetail->getOrderPrefix() . $incrementId;
			$merchantId = $productdetail->getMerchant();
		}
		$resultproductid = $currentdeal->query("update  " . $tprefix . "sales_flat_order set increment_id='$incrementId', merchant_id='$merchantId' where entity_id  = '$lastOrderId'");
		$resultproductid = $currentdeal->query("update  " . $tprefix . "sales_flat_order_grid set increment_id='$incrementId', merchant_id='$merchantId' where entity_id  = '$lastOrderId'");
		$lastRecurringProfiles = $session->getLastRecurringProfileIds();
		if (!$lastQuoteId || (!$lastOrderId && empty($lastRecurringProfiles))) {
			$this->_redirect('checkout/cart');
			return;
		}

		$session->clear();
		$this->loadLayout();
		$this->_initLayoutMessages('checkout/session');
		Mage::dispatchEvent('checkout_onepage_controller_success_action');
		$this->renderLayout();
	}

}
