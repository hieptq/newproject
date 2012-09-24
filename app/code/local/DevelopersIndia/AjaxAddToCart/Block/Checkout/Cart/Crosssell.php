<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    Mage
 * @package     Mage_Checkout
 * @copyright   Copyright (c) 2011 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Cart crosssell list
 *
 * @category   Mage
 * @package    Mage_Checkout
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class DevelopersIndia_AjaxAddToCart_Block_Checkout_Cart_Crosssell extends Mage_Checkout_Block_Cart_Crosssell
{
	/**
     * return url with product id whether it is configurable or grouped or of any type
     */
    public function getAddToCartUrl($product, $additional = array())
    {
		// echo $this->getRequest()->getRouteName()."<-- rout param<br/>";
		// echo $this->getRequest()->getControllerName()."<-- controller name<br/>";
		// echo $this->helper('checkout/cart')->getAddUrl($product, $additional);
		// die('in');
		
		if ($this->getRequest()->getRouteName() == 'ajaxaddtocart'
            && $this->getRequest()->getControllerName() == 'cart') {
				$additional['in_cart'] = 1;
		}
		
        return $this->helper('checkout/cart')->getAddUrl($product, $additional);
    }
}