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
 * Shopping cart item render block
 *
 * @category    Mage
 * @package     Mage_Checkout
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class DevelopersIndia_AjaxAddToCart_Block_Checkout_Sidecart_Item_Renderer_Grouped extends Mage_Checkout_Block_Cart_Item_Renderer_Grouped
{
	public function getConfigureUrl()
    {
		if(!Mage::getStoreConfig("ajaxaddtocart/ajaxaddtocart_settings/active"))
			return parent::getConfigureUrl();
		
		return "javascript:configureProduct('".$this->getUrl(
			'checkout/cart/configure',
			array(
				'id' => $this->getItem()->getId(),
			)
		)."')";
    }

    /**
     * Get item delete url
     *
     * @return string
     */
    public function getDeleteUrl()
    {
		if(!Mage::getStoreConfig("ajaxaddtocart/ajaxaddtocart_settings/active"))
			return parent::getDeleteUrl();
					
		return "javascript:sidebarDelete('".$this->getUrl(
			'checkout/cart/sidebardelete',
			array(
				'id'=>$this->getItem()->getId(),
				Mage_Core_Controller_Front_Action::PARAM_NAME_URL_ENCODED => $this->helper('core/url')->getEncodedUrl()
			)
		)."')";
    }
}
