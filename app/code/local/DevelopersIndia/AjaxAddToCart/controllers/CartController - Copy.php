<?php

require_once("Mage/Checkout/controllers/CartController.php");
class DevelopersIndia_AjaxAddToCart_CartController extends Mage_Checkout_CartController
{
	public function addAction()
    {
		if(!Mage::getStoreConfig("ajaxaddtocart/ajaxaddtocart_settings/active"))
			return parent::addAction();
		$cart   = $this->_getCart();
        $params = $this->getRequest()->getParams();

        $product= $this->_initProduct();
		Mage::register('product', $product);
		Mage::register('current_product', $product);
        $related= $this->getRequest()->getParam('related_product');

        /**
         * Check product availability
         */
        if (!$product) {
            $this->_goBack();
            return;
        }
		
		if(!$this->getRequest()->getParam('skip_pt_check')){
			$allowedProductTypes = array('simple', 'downloadable', 'virtual');
			if(!(in_array($product->getTypeId(), $allowedProductTypes))){
				// return $this->returnOptions($product->getTypeId());
				// die($product->getTypeId());
				if(!$this->getRequest()->getParam('product_submit')){
					$layoutHandle = 'product_type_data_'.$product->getTypeId();
					$this->loadLayout($layoutHandle);
					
					// header('Content-type: application/json');
					// echo 'product_type_data_'.$product->getTypeId()."<-- load layout";
					
					$return['product_type_data'] = $this->getLayout()->getBlock('product.info')->toHtml();
					echo json_encode($return); 
					die();
				}
			}
		}
		// echo "after ".$product->getTypeId();
		// die();


        try {
            $cart->addProduct($product, $params);
            if (!empty($related)) {
                $cart->addProductsByIds(explode(',', $related));
            }

            $cart->save();

            $this->_getSession()->setCartWasUpdated(true);

            /**
             * @todo remove wishlist observer processAddToCart
             */
            Mage::dispatchEvent('checkout_cart_add_product_complete',
                array('product' => $product, 'request' => $this->getRequest(), 'response' => $this->getResponse())
            );
            $message = $this->__('%s was successfully added to your shopping cart.', "<b>".$product->getName()."</b>");
			
			// if(isset($params['in_cart']) && $params['in_cart']!=0){
			if($this->getRequest()->getPost('in_cart')){
				$this->getRequest()->setParam('request_from', 'checkout');
				$this->_forward('delete');
			}else{
						
				header('Content-type: application/json');
				$return['r'] = 'success';
				$return['message'] = $message;
				// $return['cart'] = $this->getLayout()->createBlock('checkout/cart_sidebar')->setTemplate('checkout/cart/sidebar.phtml')->toHtml();
				$this->loadLayout();
				$return['cart'] = $this->getLayout()->getBlock('cart_sidebar')->toHtml();
				
				// update mycart top link
				// $count = Mage::helper('checkout/cart')->getSummaryCount();
				// $cartUrl = Mage::helper('checkout/cart')->getCartUrl();

				// if( $count == 1 ) {
					// $text = $this->__('My Cart (%s item)', $count);
				// } elseif( $count > 0 ) {
					// $text = $this->__('My Cart (%s items)', $count);
				// } else {
					// $text = $this->__('My Cart');
				// }
				// $return['topCartText'] = $text;
				$return['topCartText'] = $this->getUpdatedTopCartLinkAction();
				
				echo json_encode($return); 
			}
        }
        catch (Mage_Core_Exception $e) {
			$re_message = "";
            if ($this->_getSession()->getUseNotice(true)) {
                // $this->_getSession()->addNotice($e->getMessage());
				$re_message .= $e->getMessage()."\n";
            } else {
                $messages = array_unique(explode("\n", $e->getMessage()));
                foreach ($messages as $message) {
                    // $this->_getSession()->addError($message);
					$re_message .= $message."\n";
                }
            }
			
            $url = $this->_getSession()->getRedirectUrl(true);
			
			$return['r'] = 'failure';
			$return['message'] = $re_message;
			$return['redirect_url'] = $url;
			echo json_encode($return); 
			die();
            if ($url) {
                $this->getResponse()->setRedirect($url);
            } else {
                $this->_redirectReferer(Mage::helper('checkout/cart')->getCartUrl());
            }
        }
        catch (Exception $e) {
            // $this->_getSession()->addException($e, $this->__('Can not add item to shopping cart'));
            // $this->_goBack();
			$return['r'] = 'failure';
			$return['message'] = $this->__('Can not add item to shopping cart');
			echo json_encode($return); 
			die();
        }
	}
	
	protected function returnOptions($type){
		header('Content-type: application/json');
		$this->loadLayout('product_type_data_'.$type);
		$return['product_type_data'] = $this->getLayout()->getBlock('content')->toHtml();
		echo json_encode($return); 
		die();
	}
	
	public function sidebardeleteAction(){
		$id = (int) $this->getRequest()->getParam('id');
        if ($id) {
            try {
                $this->_getCart()->removeItem($id)
                  ->save();
            } catch (Exception $e) {
                $this->_getSession()->addError($this->__('Cannot remove item'));
            }
        }
		
		header('Content-type: application/json');			
		// update mycart top link		
		$return['topCartText'] = $this->getUpdatedTopCartLinkAction();
		$return['r'] = 'success';
		// $return['cart'] = $this->getLayout()->createBlock('checkout/cart_sidebar')->setTemplate('checkout/cart/sidebar.phtml')->toHtml();
		$this->loadLayout();
		$return['cart'] = $this->getLayout()->getBlock('cart_sidebar')->toHtml();
		echo json_encode($return); 
	}
	
	/**
     * Delete shoping cart item action
     */
    public function deleteAction()
    {
		if(!Mage::getStoreConfig("ajaxaddtocart/ajaxaddtocart_settings/active"))
			return parent::deleteAction();
			
        $id = (int) $this->getRequest()->getParam('id');
        if ($id) {
            try {
                $this->_getCart()->removeItem($id)
                  ->save();
            } catch (Exception $e) {
                $this->_getSession()->addError($this->__('Cannot remove item'));
            }
        }
        
		if($this->getRequest()->getParam('request_from')=='checkout'){
		
			$this->loadLayout();
			header('Content-type: application/json');
				
			// update mycart top link
			// $count = Mage::helper('checkout/cart')->getSummaryCount();
			// $cartUrl = Mage::helper('checkout/cart')->getCartUrl();

            // if( $count == 1 ) {
                // $text = $this->__('My Cart (%s item)', $count);
            // } elseif( $count > 0 ) {
                // $text = $this->__('My Cart (%s items)', $count);
            // } else {
                // $text = $this->__('My Cart');
            // }
			
			// $return['topCartText'] = $text;
			$return['topCartText'] = $this->getUpdatedTopCartLinkAction();
			
			$return['r'] = 'success';
			$return['in_cart'] = 'success';
			$return['cart'] = $this->getLayout()->getBlock('content')->toHtml();
			echo json_encode($return);
			
		}else{
			header('Content-type: application/json');
			
			// update mycart top link
			/*$count = Mage::helper('checkout/cart')->getSummaryCount();
			$cartUrl = Mage::helper('checkout/cart')->getCartUrl();

            if( $count == 1 ) {
                $text = $this->__('My Cart (%s item)', $count);
            } elseif( $count > 0 ) {
                $text = $this->__('My Cart (%s items)', $count);
            } else {
                $text = $this->__('My Cart');
            }
			
			$return['topCartText'] = $text;*/
			$return['topCartText'] = $this->getUpdatedTopCartLinkAction();
			
			$return['r'] = 'success';
			// $return['cart'] = $this->getLayout()->createBlock('checkout/cart_sidebar')->setTemplate('checkout/cart/sidebar.phtml')->toHtml();
			$this->loadLayout('default');
			$return['cart'] = $this->getLayout()->getBlock('cart_sidebar')->toHtml();
			echo json_encode($return); 
		}
		die();
    }
	
	public function getUpdatedTopCartLinkAction(){
		// update mycart top link
		$count = Mage::helper('checkout/cart')->getSummaryCount();
		$cartUrl = Mage::helper('checkout/cart')->getCartUrl();

		if( $count == 1 ) {
			$text = $this->__('My Cart (%s item)', $count);
		} elseif( $count > 0 ) {
			$text = $this->__('My Cart (%s items)', $count);
		} else {
			$text = $this->__('My Cart');
		}
		// echo $text;
		return $text;
	}
	
	/**
     * Action to reconfigure cart item
     */
    public function configureAction()
    {
		if(!Mage::getStoreConfig("ajaxaddtocart/ajaxaddtocart_settings/active"))
			return parent::configureAction();
			
        // Extract item and product to configure
        $id = (int) $this->getRequest()->getParam('id');
        $quoteItem = null;
        $cart = $this->_getCart();
        if ($id) {
            $quoteItem = $cart->getQuote()->getItemById($id);
        }

        if (!$quoteItem) {
            $this->_getSession()->addError($this->__('Quote item is not found.'));
            $this->_redirect('checkout/cart');
            return;
        }

        try {
            $params = new Varien_Object();
            $params->setCategoryId(false);
            $params->setConfigureMode(true);
            $params->setBuyRequest($quoteItem->getBuyRequest());

            Mage::helper('catalog/product_view')->prepareAndRender($quoteItem->getProduct()->getId(), $this, $params);
			// $this->loadLayout('ajaxaddtocart_cart_configure');
			
			$allowedProductTypes = array('simple', 'downloadable', 'virtual');
			$layoutHandle = 'ajaxaddtocart_cart_configure';
			if(!in_array($quoteItem->getProduct()->getTypeId(), $allowedProductTypes)){
				$layoutHandle = 'ajaxaddtocart_cart_configure_'.$quoteItem->getProduct()->getTypeId();
			}
			
			$this->loadLayout($layoutHandle);
			
			$return['product_type_data'] = $this->getLayout()->getBlock('product.info')->toHtml();
			$return['from_configure_action'] = true;
			echo json_encode($return); 
			die();
			
        } catch (Exception $e) {
            $this->_getSession()->addError($this->__('Cannot configure product.'));
            Mage::logException($e);
            $this->_goBack();
            return;
        }
    }

	/**
     * Update product configuration for a cart item
     */
    public function updateItemOptionsAction()
    {
		if(!Mage::getStoreConfig("ajaxaddtocart/ajaxaddtocart_settings/active"))
			return parent::updateItemOptionsAction();
			
        $cart   = $this->_getCart();
        $id = (int) $this->getRequest()->getParam('id');
        $params = $this->getRequest()->getParams();

        if (!isset($params['options'])) {
            $params['options'] = array();
        }
        try {
            if (isset($params['qty'])) {
                $filter = new Zend_Filter_LocalizedToNormalized(
                    array('locale' => Mage::app()->getLocale()->getLocaleCode())
                );
                $params['qty'] = $filter->filter($params['qty']);
            }

            $quoteItem = $cart->getQuote()->getItemById($id);
            if (!$quoteItem) {
                Mage::throwException($this->__('Quote item is not found.'));
            }

            $item = $cart->updateItem($id, new Varien_Object($params));
            if (is_string($item)) {
                Mage::throwException($item);
            }
            if ($item->getHasError()) {
                Mage::throwException($item->getMessage());
            }

            $related = $this->getRequest()->getParam('related_product');
            if (!empty($related)) {
                $cart->addProductsByIds(explode(',', $related));
            }

            $cart->save();

            $this->_getSession()->setCartWasUpdated(true);

            Mage::dispatchEvent('checkout_cart_update_item_complete',
                array('item' => $item, 'request' => $this->getRequest(), 'response' => $this->getResponse())
            );
            if (!$this->_getSession()->getNoCartRedirect(true)) {
                if (!$cart->getQuote()->getHasError()){
                    $message = $this->__('%s was updated in your shopping cart.', Mage::helper('core')->htmlEscape($item->getProduct()->getName()));
                    // $this->_getSession()->addSuccess($message);
                }
                // $this->_goBack();
            }
			
			header('Content-type: application/json');
			$return['r'] = 'success';
			$return['message'] = $message;
			// $return['cart'] = $this->getLayout()->createBlock('checkout/cart_sidebar')->setTemplate('checkout/cart/sidebar.phtml')->toHtml();
			$this->loadLayout();
			
			if($this->getRequest()->getModuleName()=="checkout"){
				$return['big_cart'] = $this->getLayout()->getBlock('content')->toHtml();
			}else{
				$return['cart'] = $this->getLayout()->getBlock('cart_sidebar')->toHtml();
			}		
			
			// update mycart top link
			/*$count = Mage::helper('checkout/cart')->getSummaryCount();
			$cartUrl = Mage::helper('checkout/cart')->getCartUrl();

			if( $count == 1 ) {
				$text = $this->__('My Cart (%s item)', $count);
			} elseif( $count > 0 ) {
				$text = $this->__('My Cart (%s items)', $count);
			} else {
				$text = $this->__('My Cart');
			}
			$return['topCartText'] = $text;*/
			$return['topCartText'] = $this->getUpdatedTopCartLinkAction();
			
			echo json_encode($return); 
			
        } catch (Mage_Core_Exception $e) {
			$re_message = "";
            if ($this->_getSession()->getUseNotice(true)) {
                // $this->_getSession()->addNotice($e->getMessage());
				$re_message .= $e->getMessage()."\n";
            } else {
                $messages = array_unique(explode("\n", $e->getMessage()));
                foreach ($messages as $message) {
                    // $this->_getSession()->addError($message);
					$re_message .= $message."\n";
                }
            }

            $url = $this->_getSession()->getRedirectUrl(true);
            // if ($url) {
                // $this->getResponse()->setRedirect($url);
            // } else {
                // $this->_redirectReferer(Mage::helper('checkout/cart')->getCartUrl());
            // }
			
			$return['r'] = 'failure';
			$return['message'] = $re_message;
			$return['redirect_url'] = $url;
			echo json_encode($return); 
			die();
			
        } catch (Exception $e) {
            // $this->_getSession()->addException($e, $this->__('Cannot update the item.'));
            Mage::logException($e);
            // $this->_goBack();
			$return['r'] = 'failure';
			$return['message'] = $this->__('Cannot update the item.');
			echo json_encode($return); 
			die();			
        }
        // $this->_redirect('*/*');
    }
}