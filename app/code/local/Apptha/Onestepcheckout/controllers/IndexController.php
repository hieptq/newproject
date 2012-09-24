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
 * */
?>
<?php

class Apptha_Onestepcheckout_IndexController extends Mage_Core_Controller_Front_Action {

 
	/* function:load the onepage template and check the quotes if not available redirect to cart page   */

	
    public function indexAction() {

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
        //	if ($cartItems > 1) {
				Mage::getSingleton('checkout/session')->addError($this->__('Maximum one product to add the shopping cart.'));
				$this->_redirect('checkout/cart');
				return;
			}
		}

                //Maximum per customer

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

		Mage::getSingleton('checkout/session')->setCartWasUpdated(false);
		Mage::getSingleton('customer/session')->setBeforeAuthUrl(Mage::getUrl('*/*/*', array('_secure' => true)));
		$this->getOnepage()->initCheckout();
		$this->loadLayout();
		$this->_initLayoutMessages('customer/session');
		$this->renderLayout();
	}

    /* End of index Action */

    /* function:if ajax  expires  check the quouetes if not avaiable  redirect to ajaxredirectresponse  fn */

    protected function _expireAjax() {
        if (!$this->getOnepage()->getQuote()->hasItems()
                || $this->getOnepage()->getQuote()->getHasError()
                || $this->getOnepage()->getQuote()->getIsMultiShipping()) {
            $this->_ajaxRedirectResponse();
            return true;
        }
        $action = $this->getRequest()->getActionName();
        if (Mage::getSingleton('checkout/session')->getCartWasUpdated(true)
                && !in_array($action, array('index', 'progress'))) {
            $this->_ajaxRedirectResponse();
            return true;
        }

        return false;
    }

    /* End of expireAjax fn */

    /* function:set session expires and send the response to Onestepcheckout.js  */

    public function _ajaxRedirectResponse() {
        $this->getResponse()
                ->setHeader('HTTP/1.1', '403 Session Expired')
                ->setHeader('Login-Required', 'true')
                ->sendResponse();
        return $this;
    }

    /* End of ajaxRedirectResponse fn */

    /* function:includes the core checkout onepage model  */

    public function getOnepage() {
        return Mage::getSingleton('checkout/type_onepage');
    }

    /* End of getOnepage fn */

    /* function:get the username and password from ajax and check the user table  and send the result as json response to js */

    public function loginAction() {
        $username = $this->getRequest()->getPost('onestepcheckout_username', false);
        $password = $this->getRequest()->getPost('onestepcheckout_password', false);
        $session = Mage::getSingleton('customer/session');

        $result = array(
            'success' => false
        );

        if ($username && $password) {
            try {
                $session->login($username, $password);
            } catch (Exception $e) {
                $result['error'] = $e->getMessage();
            }

            if (!isset($result['error'])) {
                $result['success'] = true;
            }
        } else {
            $result['error'] = $this->__('Please enter your Email Id and password.');
        }

        $this->getResponse()->setBody(Zend_Json::encode($result));
    }

    /* End of Login Action  */
    public function forgotPasswordAction()
    {
        $email = $this->getRequest()->getPost('email', false);

        if (!Zend_Validate::is($email, 'EmailAddress'))
        {
            $result = array('success'=>false);
        }
        else
        {

            $customer = Mage::getModel('customer/customer')
            ->setWebsiteId(Mage::app()->getStore()->getWebsiteId())
            ->loadByEmail($email);

            if ($customer->getId())
             {
                try
                {
                    $newPassword = $customer->generatePassword();
                    $customer->changePassword($newPassword, false);
                    $customer->sendPasswordReminderEmail();
                    $result = array('success'=>true);
                }
                catch (Exception $e)
                {
                    $result = array('success'=>false, 'error'=>$e->getMessage());
                }
            }
            else
            {
                $result = array('success'=>false, 'error'=>'notfound');
            }
        }

        $this->getResponse()->setBody(Zend_Json::encode($result));
    }

    /* function:load the product information when payment method selects */

    public function playAction()
    {
        if ($this->_expireAjax())
        {

            return;
        }
        $this->loadLayout();
        $this->renderLayout();
    }

    /* End of Play Action  */

    /* function:load the product information when shipping method selects */

    public function reloadAction()
    {
        if ($this->_expireAjax())
        {
            return;
        }
        $shipping_method = $this->getRequest()->getPost('shipping_method');
        $save_shippingmethod = $this->getOnepage()->saveShippingMethod($shipping_method);          
	    if(!$save_shippingmethod)
	     {
	       $event =    Mage::dispatchEvent('checkout_controller_onepage_save_shipping_method',
	                        array('request'=>$this->getRequest(),
	                            'quote'=>$this->getOnepage()->getQuote()));
	       $this->getOnepage()->getQuote()->collectTotals();
	     }
  	    $this->getOnepage()->getQuote()->collectTotals()->save(); 
        $this->getOnepage()->getQuote()->getShippingAddress()->setShippingMethod($shipping_method);
        $this->loadLayout();
        $this->renderLayout();
    }

    /* End of reload Action  */
    
	 /* Start of paymentreload Action  */
    /* payment reload when changes the shipping methods */
    
 	public function paymentreloadAction()
    {       
        $this->loadLayout(false);
        $this->renderLayout();
    }
    
     /* End of paymentreload Action  */
    
    public function summaryAction()
    {
        if ($this->_expireAjax())
        {

            return;
        }

        $this->loadLayout();
        $this->renderLayout();
    }
    //ajax save billing function
    //save billing,shipping,payment information
     public function savebillingAction()
    {
        $billing_data = $this->getRequest()->getPost('billing', array());
        $shipping_data = $this->getRequest()->getPost('shipping', array());
       
        $customerAddressId = $this->getRequest()->getPost('billing_address_id', false);
        $shippingAddressId = $this->getRequest()->getPost('shipping_address_id', false);
        if (!empty($shippingAddressId))
          {

                $shippingAddress = Mage::getModel('customer/address')->load($shippingAddressId);
                if (is_object($shippingAddress) && $shippingAddress->getCustomerId() == Mage::helper('customer')->getCustomer()->getId()) {
                    $shipping_data = array_merge($shipping_data, $shippingAddress->getData());
                    
                }
           }
           
        /* start of save billing and shipping information for tax calculation */
           
    	$config = Mage::getStoreConfig('tax/calculation/based_on');
        $helper = Mage::helper('onestepcheckout/checkout');
        if($config=="billing")
        {
              $billing_info = $helper->load_add_data($billing_data);
              $billing_result = $this->getOnepage()->saveBilling($billing_info, $customerAddressId);
        }
        else
        {
            if(!empty($billing_data['use_for_shipping']))
             {
               $Billingdata = $helper->load_add_data($billing_data);
               $shipping_result = $this->getOnepage()->saveShipping($Billingdata, $customerAddressId);
             }
        	else
             {
            	if($this->getOnepage()->getQuote()->isVirtual()) 
            	 {
            	 	$billing_info = $helper->load_add_data($billing_data);
              		$billing_result = $this->getOnepage()->saveBilling($billing_info, $customerAddressId);
            	 }
            	else
            	{
                	$shipping_info = $helper->load_add_data($shipping_data);
                	$shipping_result = $this->getOnepage()->saveShipping($shipping_info, $shippingAddressId);
            	}
             }
        }
           
           
           /* End  of save billing and shipping information for tax calculation */
         
           
           //if shipping same as billing
         // save billing country,region,city,postcode to shipping
        if(!empty($billing_data['use_for_shipping'])) 
        {
            if(!empty($billing_data['country_id'])){
                $this->getOnepage()->getQuote()->getShippingAddress()->setCountryId($billing_data['country_id'])->setCollectShippingRates(true);
            }
             if(!empty($billing_data['region'])){
                $this->getOnepage()->getQuote()->getShippingAddress()->setRegionId($billing_data['region'])->setCollectShippingRates(true);
            }
            if(!empty($billing_data['city'])){
                $this->getOnepage()->getQuote()->getShippingAddress()->setCity($billing_data['city'])->setCollectShippingRates(true);
            }
            if(!empty($billing_data['postcode'])){
                $this->getOnepage()->getQuote()->getShippingAddress()->setPostcode($billing_data['postcode'])->setCollectShippingRates(true);
            }
        }
        else
        {
            if(!empty($shipping_data['country_id'])){
                $this->getOnepage()->getQuote()->getShippingAddress()->setCountryId($shipping_data['country_id'])->setCollectShippingRates(true);
            }
            else {$this->getOnepage()->getQuote()->getBillingAddress()->setCountryId($shipping_data['country_id'])->setCollectShippingRates(true);}
             if(!empty($shipping_data['region'])){
                $this->getOnepage()->getQuote()->getShippingAddress()->setRegionId($shipping_data['region'])->setCollectShippingRates(true);
            }
            if(!empty($shipping_data['city'])){
                $this->getOnepage()->getQuote()->getShippingAddress()->setCity($shipping_data['city'])->setCollectShippingRates(true);
            }
            if(!empty($shipping_data['postcode'])){
                $this->getOnepage()->getQuote()->getShippingAddress()->setPostcode($shipping_data['postcode'])->setCollectShippingRates(true);
            }
        }
    $paymentMethod = $this->getRequest()->getPost('payment_method', false);
    $paymentMethod = $this->getRequest()->getPost('payment_method', false);
    if($this->getOnepage()->getQuote()->isVirtual()) 
      {
          $this->getOnepage()->getQuote()->getBillingAddress()->setPaymentMethod(!empty($paymentMethod) ? $paymentMethod : null);
      }
     else
      {
            $this->getOnepage()->getQuote()->getShippingAddress()->setPaymentMethod(!empty($paymentMethod) ? $paymentMethod : null);
      }

        $this->loadLayout(false);
        $this->renderLayout();

    }


    /* function:get all the information from onepage form and save the order using ajax */

    public function saveOrderAction() {
        if ($this->_expireAjax()) {
        	
            return;
        }
        $helper = Mage::helper('onestepcheckout/checkout');
        if ($this->getRequest()->isPost()) {
            $Method = $this->getRequest()->getPost('checkout_method', false);
            $Billingdata = $this->getRequest()->getPost('billing', array());
            $Billingdata = $helper->load_exclude_data($Billingdata);
            $Paymentdata = $this->getRequest()->getPost('payment', array());
            $result = $this->getOnepage()->saveCheckoutMethod($Method);
            if(isset($Billingdata['is_subscribed']) && !empty($Billingdata['is_subscribed']))
            {
            $customer = $this->getOnepage()->getCheckout()->setCustomerIsSubscribed(1);
            }
            $customerAddressId = $this->getRequest()->getPost('billing_address_id', false);
            if (isset($Billingdata['email'])) {
                $Billingdata['email'] = trim($Billingdata['email']);
            }
            $Billingresult = $this->getOnepage()->saveBilling($Billingdata, $customerAddressId);
            $Paymentresult = $this->getOnepage()->savePayment($Paymentdata);
            $Shippingdata = $this->getRequest()->getPost('shipping', array());
            $ShippingAddressId = $this->getRequest()->getPost('shipping_address_id', false);
           if (!empty($Billingdata['use_for_shipping']))
            {
                $shipping_result = $this->getOnepage()->saveShipping($Billingdata, $customerAddressId);
            }
            else if (!empty($ShippingAddressId)) {

                $shippingAddress = Mage::getModel('customer/address')->load($ShippingAddressId);
                if (is_object($shippingAddress) && $shippingAddress->getCustomerId() == Mage::helper('customer')->getCustomer()->getId())
                {
                    $Shippingdata = array_merge($Shippingdata, $shippingAddress->getData());
                    $shipping_result = $this->getOnepage()->saveShipping($Shippingdata, $ShippingAddressId);
                }
            } else if (empty($Billingdata['use_for_shipping']) && !$ShippingAddressId)
                {
                $shipping_result = $this->getOnepage()->saveShipping($Shippingdata, $ShippingAddressId);
            } else {
                $shipping_result = $this->getOnepage()->saveShipping($Billingdata, $customerAddressId);
            }
            $ShippingMethoddata = $this->getRequest()->getPost('shipping_method', '');
            $ShippingMethodresult = $this->getOnepage()->saveShippingMethod($ShippingMethoddata);
            // }
        }
        Mage::dispatchEvent('checkout_controller_onepage_save_shipping_method', array('request' => $this->getRequest(), 'quote' => $this->getOnepage()->getQuote()));
        $data = $this->getRequest()->getPost('payment', array());
            $result = $this->getOnepage()->savePayment($data);

            // get section and redirect data
            $redirectUrl = $this->getOnepage()->getQuote()->getPayment()->getCheckoutRedirectUrl();
             if ($redirectUrl) {
               if ($requiredAgreements = Mage::helper('checkout')->getRequiredAgreementIds()) {
                $postedAgreements = array_keys($this->getRequest()->getPost('agreement', array()));
                if ($diff = array_diff($requiredAgreements, $postedAgreements)) {
                    $result['success'] = false;
                    $result['error'] = true;
                    $result['error_messages'] = $this->__('Please agree to all the terms and conditions before placing the order.');
                    $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
                    return;
                }
            }
                 $result['success'] = true;
                 $result['error'] = false;
                 $result['redirect'] = $redirectUrl;
              $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
              return;
            }
           // $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
        $result = array();
        try {
            if ($requiredAgreements = Mage::helper('checkout')->getRequiredAgreementIds()) {
                $postedAgreements = array_keys($this->getRequest()->getPost('agreement', array()));
                if ($diff = array_diff($requiredAgreements, $postedAgreements)) {
                    $result['success'] = false;
                    $result['error'] = true;
                    $result['error_messages'] = $this->__('Please agree to all the terms and conditions before placing the order.');
                    $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
                    return;
                }
            }
            if ($data = $this->getRequest()->getPost('payment', false)) {
                $this->getOnepage()->getQuote()->getPayment()->importData($data);
            }
            $this->getOnepage()->saveOrder();
            $redirectUrl = $this->getOnepage()->getCheckout()->getRedirectUrl();
            $result['success'] = true;
            $result['error'] = false;
        } catch (Mage_Payment_Model_Info_Exception $e) {
            $message = $e->getMessage();
            if (!empty($message)) {
                $result['error_messages'] = $message;
            }
            
        } catch (Mage_Core_Exception $e) {
           // Mage::logException($e);
            $result['success'] = false;
            $result['error'] = true;
            $result['error_messages'] = $e->getMessage();
            Mage::helper('checkout')->sendPaymentFailedEmail($this->getOnepage()->getQuote(), $e->getMessage());
            $result['success'] = false;
            $result['error'] = true;
            $result['error_messages'] = $e->getMessage();

           
        } catch (Exception $e) {
           // Mage::logException($e);
            $result['success'] = false;
            $result['error'] = true;
            $result['error_messages'] = $e->getMessage();
            Mage::helper('checkout')->sendPaymentFailedEmail($this->getOnepage()->getQuote(), $e->getMessage());
            $result['success'] = false;
            $result['error'] = true;
            $result['error_messages'] = $this->__('There was an error processing your order. Please contact us or try again later.');
        }
        $this->getOnepage()->getQuote()->save();
        /**
         * when there is redirect to third party, we don't want to save order yet.
         * we will save the order in return action.
         */
        if (isset($redirectUrl)) {
            $result['redirect'] = $redirectUrl;
        }
        if ($result['success']) {
            $result['success'] = Mage::getBaseUrl() . 'checkout/onepage/success/';
        }

        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
    }

    /* End of saveorder Action */

 /* start of couponcode Action */
    function couponcodeAction()
    {

        $quote = $this->getOnepage()->getQuote();
        $couponCode = (string)$this->getRequest()->getParam('code');

        if ($this->getRequest()->getParam('remove') == 1) {
            $couponCode = '';
        }

        $response = array(
            'success' => false,
            'error'=> false,
            'message' => false,
        );
        try {

            $quote->getShippingAddress()->setCollectShippingRates(true);
            $quote->setCouponCode(strlen($couponCode) ? $couponCode : '')
            ->collectTotals()
            ->save();

            if ($couponCode) {
                if ($couponCode == $quote->getCouponCode()) {
                    $response['success'] = true;
                    $response['message'] = $this->__('Coupon code "%s" was applied successfully.',
                    Mage::helper('core')->htmlEscape($couponCode));
                }
                else {
                    $response['success'] = false;
                    $response['error'] = true;
                    $response['message'] = $this->__('Coupon code "%s" is not valid.',
                    Mage::helper('core')->htmlEscape($couponCode));
                }
            } else {
                $response['success'] = true;
                $response['message'] = $this->__('Coupon code was canceled successfully.');
            }


        }
        catch (Mage_Core_Exception $e) {
            $response['success'] = false;
            $response['error'] = true;
            $response['message'] = $e->getMessage();
        }
        catch (Exception $e) {
            $response['success'] = false;
            $response['error'] = true;
            $response['message'] = $this->__('Can not apply coupon code.');
        }

       
        $html = $this->getLayout()
        ->createBlock('onestepcheckout/onestep_review_info')
        ->setTemplate('onestepcheckout/onestep/review/info.phtml')
        ->toHtml();

        $response['summary'] = $html;


        $this->getResponse()->setBody(Zend_Json::encode($response));
    }
     /* End of couponcode Action */
}