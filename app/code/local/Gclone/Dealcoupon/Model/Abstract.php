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
class Gclone_Dealcoupon_Model_Abstract extends Mage_Sales_Model_Order_Pdf_Abstract {
    /*
     * To create a PDF document
     * updated @ 02.12.2010
     */

    //insert coupon pdf

    protected function insertCoupon(&$page, $_order, $orderId, $putOrderId = true, $identifier) {
        $baseurl = Mage::getBaseUrl();
        $skinPath = $this->getSkinUrl();
        $currencySymbol = Mage::app()->getLocale()->currency(Mage::app()->getStore()->getCurrentCurrencyCode())->getSymbol();
        $baseurl = $this->getBaseUrl();
        $realOrderId = $_order[0]['increment_id'];
        $displayOrderId = '#' . $realOrderId;
        //$orderId = $_order[0]['entity_id'];
        $resource = Mage::getSingleton('core/resource');
        $couponemail = $resource->getConnection('core_write');
        $tprefix = (string) Mage::getConfig()->getTablePrefix();
        $uniquenumber = '';
        $giftCouponCheck = $couponemail->fetchRow("select * from " . $tprefix . "ordercustomer where order_id =" . $orderId . " and quantitynumber=" . $identifier);

        if (isset($giftCouponCheck['uniqueid'])) {
            $uniquenumber = $giftCouponCheck['uniqueid'];
            $customerName = $giftCouponCheck['customer_name'];
            $voucherCode = $giftCouponCheck['vouchercode']; 
        }
        $store = Mage::app()->getStore();
        $order = Mage::getModel('sales/order')->load($orderId);
        $items = $order->getAllItems();
        $itemcount = count($items);
        $Productname = '';
        $unitPrice = '';
        $qty = '';
        foreach ($items as $itemId => $item) {
            $Productname = $item->getName();
            $unitPrice = $item->getPrice();
            $specialPrice = $item->getSpecialPrice();
            $qty = $item->getQtyOrdered();
            $model = Mage::getModel('catalog/product');
            $productId = $item->getProductId();
            $url = "productid" . $productId;
            $productdetail = $model->load($item->getProductId());
            $currentproductimage = Mage::helper('catalog/image')->init($productdetail, 'image')->resize(386, 338);
            $specialPrice = $productdetail->getSpecialPrice();
            $Productname = $productdetail->getName();
            $Productname = self::fineLayout($Productname,90,"<br/>");
            
          
            
            $unitPrice = $productdetail->getPrice();
            $discount_price = $unitPrice - $specialPrice;
            $discount = ($discount_price * 100) / $unitPrice;
            $discount = round($discount);
            $currentdiscount = $discount;
            $couponValid = $productdetail->getEnjoyby();
            $couponValidDate = date("F j, Y", strtotime($couponValid));
            $couponCondition = $productdetail->getLimits();
            $phone = $productdetail->getQuestions();
            $Companywebsite = $productdetail->getCustomer_website();
            //b   $Fineprint = self::strip_only($productdetail->getFineprint(),array('style','ul','li','p','strong','br','span','a'));          
           $Fineprint = self::strip_only($productdetail->getFineprint(),array('style','ul','li','p','strong','span','a'));



           //b $Fineprint = self::fineLayout($Fineprint,82,"</li>");
             $Fineprint = self::fineLayout($Fineprint,82,"<br />");
              //$Fineprint=array_merge((array)$Fineprint, (array)$fine3);
             /*$Fineprint = explode('</li>', $Fineprint);
            $j = 0;

            foreach ($Fineprint as $fitem) {
                $fineprint[$j] = strip_tags(trim($fitem));
                $j = $j + 1;
            }*/

            $Companyname = $productdetail->getCompanyName();
            $Companyaddress = self::strip_only($productdetail->getCustomersite(),array('style','ul','li','p','strong','span','a'));



           //b $Fineprint = self::fineLayout($Fineprint,82,"</li>");
             $Companyaddress = self::fineLayout($Companyaddress,55,"<br />");
 
//            $Companyaddress = self::fineLayout($productdetail->getCustomersite(),45,"</li>");
//            $Companyaddress=array_merge((array)$Companyaddress, (array)$fine3);
            /*$comAddress = explode('<br/>', $Companyaddress);
            $i = 0;
            foreach ($comAddress as $item) {
                $address[$i] = trim($item);
                $i = $i + 1;
            }*/

            $product_worth = $productdetail->getPrice();
            $product_description = $productdetail->getDescription();
       }

        /* @var $order Mage_Sales_Model_Order */
        $page->setFillColor(new Zend_Pdf_Color_Rgb(0.30, 0.40, 0.42));

        // $page->drawRectangle(25, 810, 570, 725);
        $page->drawRectangle(75, 800, 520, 760);
        $page->setFillColor(new Zend_Pdf_Color_Rgb(1, 1, 1));
        $enableBarcode = Mage::getStoreConfig('barcode/defaultcode/status');
        $barcodeFileName = $uniquenumber;
      
        //orderid
        $page->setFillColor(new Zend_Pdf_Color_Rgb(1, 1, 1));
          $page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD), 12);
        $page->drawText(Mage::helper('sales')->__($displayOrderId), 420, 770, 'UTF-8');
        //set color for body text
        $page->setFillColor(new Zend_Pdf_Color_Rgb(0, 0, 0));
        //product name
        $this->_setFontBold($page, 12);
        $y = '740';
        for ($k = 0; $k < count($Productname); $k++) {
            $page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD), 9);
            $page->drawText(Mage::helper('sales')->__($Productname[$k]), 85, $y, 'UTF-8');
            $y = $y - 15;
        }
        /* foreach ($prDesc as $value){
            $page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD), 9);
            $page->drawText(Mage::helper('sales')->__($value), 85, $y, 'UTF-8');
            $y = $y - 15;
        }*/

        $y = $y - 15;
        $redeem = $y;
        //recipient
        $page->drawText(Mage::helper('sales')->__('Recipient'), 85, $y, 'UTF-8');
        $this->_setFontRegular($page);
        $y = $y - 10;
         $page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA), 6);
        $page->drawText(Mage::helper('sales')->__($customerName), 85, $y, 'UTF-8');
        //Expires On
        $y = $y - 20;
       $page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD), 9);
        $page->drawText(Mage::helper('sales')->__('Expires On'), 85, $y, 'UTF-8');
        $y = $y - 10;
        $page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA), 6);
        $page->drawText(Mage::helper('sales')->__($couponValidDate), 85, $y, 'UTF-8');
        //Fine Print
         $y = $y - 20;
         
        $page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD), 9);
        $page->drawText(Mage::helper('sales')->__('Fine Print'), 85, $y, 'UTF-8');
        $this->_setFontRegular($page);
        $y = $y-10;
        for ($k = 0; $k < count($Fineprint); $k++) {
            $page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA), 6);
            $page->drawText(Mage::helper('sales')->__(strip_tags($Fineprint[$k])), 85, $y, 'UTF-8');
            $y = $y - 10;
        }
        $howit = $y;
        //Redeem at @ address
        $y = $redeem;
        $page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD), 9);
        $page->drawText(Mage::helper('sales')->__('Redeem at'), 350, $y, 'UTF-8');
        $this->_setFontRegular($page);
        $y = $y - 10;
        
        for ($k = 0; $k < count($Companyaddress); $k++) {

         $page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA), 6);
            $page->drawText(Mage::helper('sales')->__(strip_tags($Companyaddress[$k])), 350, $y, 'UTF-8');
            $y = $y - 10;
        }

        //Worth
         $page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD), 9);
        $page->drawText(Mage::helper('sales')->__('Worth'), 350, $y, 'UTF-8');        
        $y = $y - 15;
        $page->drawText(Mage::helper('sales')->__($currencySymbol . floor($specialPrice)), 350, $y, 'UTF-8');

        //Worth
       $page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD), 9);
        $y = $y - 15;



        $page->drawText(Mage::helper('sales')->__('Coupon Code'), 350, $y, 'UTF-8');
         $page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD), 10);
        $y = $y - 10;

        $enableBarcode = Mage::getStoreConfig('barcode/defaultcode/status');
        $barcodeFileName = $uniquenumber;
        if ($enableBarcode != 0) {
            $obj = Gclone_Barcode_Block_Barcode::generateBarcode($uniquenumber, $barcodeFileName);


            $phpSelf = $_SERVER['PHP_SELF'];
            $link = explode('/', $phpSelf);
            foreach ($link as $item) {

                if ($item == 'index.php') {
                    break;
                }
                $url = $item;
            }
            if (isset($url)) {
                $image = $_SERVER['DOCUMENT_ROOT'] . '/' . $url . '/media/barcode/' . $barcodeFileName . '.png';
            } else {
                $image = $_SERVER['DOCUMENT_ROOT'] . '/media/barcode/' . $barcodeFileName . '.png';
            }


            $image = Zend_Pdf_Image::imageWithPath($image);
            $page->drawImage($image, 350, $y + 5, 420, $y - 65);
           
        } else {
             $page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA), 6);
            $page->drawText(Mage::helper('sales')->__($uniquenumber), 350, $y, 'UTF-8');
            $y = $y - 10;
            $howit1 = $y;
       }
         $y = 630;
         $page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD), 9);
        $page->drawText(Mage::helper('sales')->__('Voucher Code'), 350, $y, 'UTF-8');        
        $y = $y - 15;
        $page->drawText(Mage::helper('sales')->__($voucherCode), 350, $y, 'UTF-8');
        $y = $y - 10;
       
            $howit1 = $y;
       if($howit <= $howit1)

       {
       $y = $howit;
       $page->drawLine (75, 760, 75, $y);
       $page->drawLine (520, 760, 520, $y);
       $page->drawLine (75, $y, 520, $y);
       $y = $howit-25;
       } else {
       $y = $howit1;
       $page->drawLine (75, 760, 75, $y);
       $page->drawLine (520, 760, 520, $y);
       $page->drawLine (75, $y, 520, $y);
       $y = $howit1-25;
       }
       $f = Mage::app()->getLayout()->createBlock('cms/block')->setBlockId('coupon-use')->toHtml();
       $howTo = strip_tags($f);
       $how = explode('  ', $howTo);
//        $howTo = self::strip_only($f,array('span','strong','p','div'));
  //      $how = explode('<br />', $howTo);
        
        $h = 0;
        foreach ($how as $howitems) {
            $howItems[$h] = trim($howitems);
            $h = $h + 1;
            
        }



      $page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA_BOLD), 9);

       // for ($s = 0; $s < count($how); $s++) {
        for ($s = 0; $s < $h; $s++) {
      $page->drawText(Mage::helper('sales')->__($howItems[$s]), 85, $y, 'UTF-8');
             $page->setFont(Zend_Pdf_Font::fontWithName(Zend_Pdf_Font::FONT_HELVETICA), 6);
            $y = $y - 15;
        }
        
        $r = Mage::app()->getLayout()->createBlock('cms/block')->setBlockId('coupon-footer')->toHtml();
        $foot = self::fineLayout($r,120,"<br />");
        $footer = strip_tags($r);
        $footer = explode('&nbsp;', $footer);
        $e = 0;
        foreach ($footer as $footerItem) {
            $foot[$e] = trim($footerItem);
            $e = $e + 1;
        }
        $page->setFillColor(new Zend_Pdf_Color_Rgb(0.30, 0.40, 0.42));
        $y = $y - 20;
        $x = 85;
       // for ($t = 1; $t < count($foot); $t++) {
        for ($t = 1; $t < $e; $t++) {
            $page->drawText(Mage::helper('sales')->__($foot[$t]), $x, $y, 'UTF-8');
            $x = $x + 300;
        }

        $phpSelf = $_SERVER['PHP_SELF'];
        $link = explode('/', $phpSelf);
        foreach ($link as $item) {

            if ($item == 'index.php') {
                break;
            }
            $url = $item;
        }
        if (isset($url)) {
            $image = $_SERVER['DOCUMENT_ROOT'] . '/' . $url . '/skin/frontend/default/blue_theme/images/logo.png';
        } else {
            $image = $_SERVER['DOCUMENT_ROOT'] . '/skin/frontend/default/blue_theme/images/logo.png';
        }

        //$image = $_SERVER['DOCUMENT_ROOT'] . '/gcVersion5-beta/skin/frontend/default/inspire-blue/images/logo.png';
        $image = Zend_Pdf_Image::imageWithPath($image);
        $page->drawImage($image, 79, 765, 160, 795);
    }

    //insert coupon pdf

    public function getPdf() {
        return true;
    }

    protected function fineLayout($content,$charsLen,$tag='<br />') {
 $fine1=explode(' ',$content);
 $fine2 = count($fine1)-1;
 $fine3=$fine1[$fine2];
$fine3;

           // self::strip_only($content,array('p', 'ul','li','span','style'));
            
	    $contentf = str_replace("\r\n", " ", $content);
	    $contentf = str_replace($tag," ", $content);
	    $contentf = str_replace("&nbsp;"," ", $content);
	    $contentf = str_replace("&ndash;"," ", $content);
	    $contentCount = strlen($contentf);
	    $j = 0;
	    $o = 0;
	
	    for ($i = 0; $i <= $contentCount; $i = $i++) {
	        $contents = '';
	        $Contentl = substr($contentf, $i, $charsLen);
	        $ContentArr = explode(' ', $Contentl);	       
	        $val = count($ContentArr);
	
	        $m = 0;
	        foreach ($ContentArr as $conitem) {
	
	            if ($m < $val-1) {
	                $contents .= strip_tags(trim($conitem)) . " ";
	                $m++;
	            } else {
	                $n = strlen(strip_tags(trim($conitem)));
	            }
	        }
	           if ($fine3!= '' && strlen($contents)< ($charsLen - 7))
{

 
//$fullContent1=array_merge($fullContent[$var1], $fine3);
$contents = $contents.$fine3;
 
}
	        $fullContent[$o] = $contents;
	        $o++;

	        $i = $i + $charsLen - $n;
	    }
	    
	    	    if ($fine3!= '')
{

 
//$fullContent1=array_merge($fullContent[$var1], $fine3);
$fullContent[$var1] = $fine3;
 
}
	    return $fullContent;
	    
	    
	}
	
	
	private function strip_only($str, $tags) {
	
	 if(!is_array($tags)) {
	        $tags = (strpos($str, '>') !== false ? explode('>', str_replace('<', '', $tags)) : array($tags));
	        if(end($tags) == '') array_pop($tags);
	 }
	    foreach($tags as $tag) $str = preg_replace('#</?'.$tag.'[^>]*>#is', '', $str);
	    return $str;
	}
}