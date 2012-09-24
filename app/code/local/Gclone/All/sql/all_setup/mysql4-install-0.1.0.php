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

$installer = $this;

$installer->startSetup();

$connection = $installer->getConnection();
/* @var $connection Varien_Db_Adapter_Pdo_Mysql */


$installer->startSetup();

$connection->insert($installer->getTable('cms/page'), array(
    'title'             => 'Business',
    'root_template'     => 'two_columns_right',
    'identifier'        => 'business',
    'content'           => "<div id=\"business\">\r\n<div class=\"page-title\">\r\n<h1>For Businesses</h1>\r\n</div>\r\n<p style=\"padding: 0px; margin: 0px;\"><strong><span style=\"padding: 0px; margin: 0px; text-decoration: underline;\"><span style=\"font-size: medium; padding: 0px; margin: 0px;\">Content</span></span></strong></p>\r\n<p style=\"padding: 0px; margin: 0px;\"><strong><span style=\"padding: 0px; margin: 0px; text-decoration: underline;\"><span style=\"font-size: medium; padding: 0px; margin: 0px;\"><br style=\"padding: 0px; margin: 0px;\" /></span></span></strong></p>\r\n<p style=\"padding: 0px; margin: 0px;\">To enter the content go to login to \"<strong>admin -&gt;CMS-&gt;pages-&gt;Business</strong>\" page</p>\r\n<p style=\"padding: 0px; margin: 0px;\">&nbsp;</p>\r\n<p style=\"padding: 0px; margin: 0px;\"><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry''s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n<p style=\"padding: 0px; margin: 0px;\">&nbsp;</p>\r\n</div>",
    'creation_time'     => now(),
    'update_time'       => now(),
));
$connection->insert($installer->getTable('cms/page_store'), array(
    'page_id'   => $connection->lastInsertId(),
    'store_id'  => 1
));

$connection->insert($installer->getTable('cms/page'), array(
    'title'             => 'How it Works',
    'root_template'     => 'two_columns_right',
    'identifier'        => 'works',
    'content'           => "<div id=\"business\">\r\n<div class=\"page-title\">\r\n<h1>How it Works</h1>\r\n</div>\r\n<p style=\"padding: 0px; margin: 0px;\"><strong><span style=\"padding: 0px; margin: 0px; text-decoration: underline;\"><span style=\"font-size: medium; padding: 0px; margin: 0px;\">Content</span></span></strong></p>\r\n<p style=\"padding: 0px; margin: 0px;\"><strong><span style=\"padding: 0px; margin: 0px; text-decoration: underline;\"><span style=\"font-size: medium; padding: 0px; margin: 0px;\"><br style=\"padding: 0px; margin: 0px;\" /></span></span></strong></p>\r\n<p style=\"padding: 0px; margin: 0px;\">To enter the content go to login to \"<strong>admin -&gt;CMS-&gt;pages-&gt;works</strong>\" page</p>\r\n<p style=\"padding: 0px; margin: 0px;\">&nbsp;</p>\r\n<p style=\"padding: 0px; margin: 0px;\"><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry''s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n<p style=\"padding: 0px; margin: 0px;\">&nbsp;</p>\r\n</div>",
    'creation_time'     => now(),
    'update_time'       => now(),
));
$connection->insert($installer->getTable('cms/page_store'), array(
    'page_id'   => $connection->lastInsertId(),
    'store_id'  => 1
));

$connection->insert($installer->getTable('cms/page'), array(
    'title'             => 'Terms',
    'root_template'     => 'two_columns_right',
    'identifier'        => 'terms',
    'content'           => "<div id=\"business\">\r\n<div class=\"page-title\">\r\n<h1>Terms and Conditions</h1>\r\n</div>\r\n<p style=\"padding: 0px; margin: 0px;\"><strong><span style=\"padding: 0px; margin: 0px; text-decoration: underline;\"><span style=\"font-size: medium; padding: 0px; margin: 0px;\">Content</span></span></strong></p>\r\n<p style=\"padding: 0px; margin: 0px;\"><strong><span style=\"padding: 0px; margin: 0px; text-decoration: underline;\"><span style=\"font-size: medium; padding: 0px; margin: 0px;\"><br style=\"padding: 0px; margin: 0px;\" /></span></span></strong></p>\r\n<p style=\"padding: 0px; margin: 0px;\">To enter the content go to login to \"<strong>admin -&gt;CMS-&gt;pages-&gt;Terms</strong>\" page</p>\r\n<p style=\"padding: 0px; margin: 0px;\">&nbsp;</p>\r\n<p style=\"padding: 0px; margin: 0px;\"><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry''s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n<p style=\"padding: 0px; margin: 0px;\">&nbsp;</p>\r\n</div>",
    'creation_time'     => now(),
    'update_time'       => now(),
));
$connection->insert($installer->getTable('cms/page_store'), array(
    'page_id'   => $connection->lastInsertId(),
    'store_id'  => 1
));

$connection->insert($installer->getTable('cms/page'), array(
    'title'             => 'Preview Page',
    'root_template'     => 'two_columns_right',
    'identifier'        => 'previewpage',
    'content'           => "<div>\r\n<p>{{block type=\"catalog/product_view\" category_id=\"3\" template=\"catalog/product/view.phtml\"}}</p>\r\n</div>",
    'creation_time'     => now(),
    'update_time'       => now(),
));
$connection->insert($installer->getTable('cms/page_store'), array(
    'page_id'   => $connection->lastInsertId(),
    'store_id'  => 1
));

$connection->insert($installer->getTable('cms/page'), array(
    'title'             => 'about us',
    'root_template'     => 'two_columns_right',
    'identifier'        => 'about',
    'content'           => "<div id=\"business\">\r\n<div class=\"page-title\">\r\n<h1>About Us</h1>\r\n</div>\r\n<p style=\"padding: 0px; margin: 0px;\"><strong><span style=\"padding: 0px; margin: 0px; text-decoration: underline;\"><span style=\"font-size: medium; padding: 0px; margin: 0px;\">Content</span></span></strong></p>\r\n<p style=\"padding: 0px; margin: 0px;\"><strong><span style=\"padding: 0px; margin: 0px; text-decoration: underline;\"><span style=\"font-size: medium; padding: 0px; margin: 0px;\"><br style=\"padding: 0px; margin: 0px;\" /></span></span></strong></p>\r\n<p style=\"padding: 0px; margin: 0px;\">To enter the content go to login to \"<strong>admin -&gt;CMS-&gt;pages-&gt;about us</strong>\" page</p>\r\n<p style=\"padding: 0px; margin: 0px;\">&nbsp;</p>\r\n<p style=\"padding: 0px; margin: 0px;\"><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry''s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n<p style=\"padding: 0px; margin: 0px;\">&nbsp;</p>\r\n</div>",
    'creation_time'     => now(),
    'update_time'       => now(),
));
$connection->insert($installer->getTable('cms/page_store'), array(
    'page_id'   => $connection->lastInsertId(),
    'store_id'  => 1
));

$connection->insert($installer->getTable('cms/page'), array(
    'title'             => 'FAQ',
    'root_template'     => 'two_columns_right',
    'identifier'        => 'faq',
    'content'           => "<div id=\"business\">\r\n<div class=\"page-title\">\r\n<h1>Frequently Asked Questions</h1>\r\n</div>\r\n<p style=\"padding: 0px; margin: 0px;\"><strong><span style=\"padding: 0px; margin: 0px; text-decoration: underline;\"><span style=\"font-size: medium; padding: 0px; margin: 0px;\">Content</span></span></strong></p>\r\n<p style=\"padding: 0px; margin: 0px;\"><strong><span style=\"padding: 0px; margin: 0px; text-decoration: underline;\"><span style=\"font-size: medium; padding: 0px; margin: 0px;\"><br style=\"padding: 0px; margin: 0px;\" /></span></span></strong></p>\r\n<p style=\"padding: 0px; margin: 0px;\">To enter the content go to login to \"<strong>admin -&gt;CMS-&gt;pages-&gt;FAQ</strong>\" page</p>\r\n<p style=\"padding: 0px; margin: 0px;\">&nbsp;</p>\r\n<p style=\"padding: 0px; margin: 0px;\"><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry''s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n<p style=\"padding: 0px; margin: 0px;\">&nbsp;</p>\r\n</div>",
    'creation_time'     => now(),
    'update_time'       => now(),
));
$connection->insert($installer->getTable('cms/page_store'), array(
    'page_id'   => $connection->lastInsertId(),
    'store_id'  => 1
));

$connection->insert($installer->getTable('cms/page'), array(
    'title'             => 'Privacy Policy',
    'root_template'     => 'two_columns_right',
    'identifier'        => 'privacy',
    'content'           => "<div id=\"business\">\r\n<div class=\"page-title\">\r\n<h1>Privacy Policy</h1>\r\n</div>\r\n<p style=\"padding: 0px; margin: 0px;\"><strong><span style=\"padding: 0px; margin: 0px; text-decoration: underline;\"><span style=\"font-size: medium; padding: 0px; margin: 0px;\">Content</span></span></strong></p>\r\n<p style=\"padding: 0px; margin: 0px;\"><strong><span style=\"padding: 0px; margin: 0px; text-decoration: underline;\"><span style=\"font-size: medium; padding: 0px; margin: 0px;\"><br style=\"padding: 0px; margin: 0px;\" /></span></span></strong></p>\r\n<p style=\"padding: 0px; margin: 0px;\">To enter the content go to login to \"<strong>admin -&gt;CMS-&gt;pages-&gt;Privacy Policy</strong>\" page</p>\r\n<p style=\"padding: 0px; margin: 0px;\">&nbsp;</p>\r\n<p style=\"padding: 0px; margin: 0px;\"><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry''s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n<p style=\"padding: 0px; margin: 0px;\">&nbsp;</p>\r\n</div>",
    'creation_time'     => now(),
    'update_time'       => now(),
));
$connection->insert($installer->getTable('cms/page_store'), array(
    'page_id'   => $connection->lastInsertId(),
    'store_id'  => 1
));

$connection->insert($installer->getTable('cms/page'), array(
    'title'             => 'Press',
    'root_template'     => 'two_columns_right',
    'identifier'        => 'press',
    'content'           => "<div id=\"business\">\r\n<div class=\"page-title\">\r\n<h1>Press</h1>\r\n</div>\r\n<p style=\"padding: 0px; margin: 0px;\"><strong><span style=\"padding: 0px; margin: 0px; text-decoration: underline;\"><span style=\"font-size: medium; padding: 0px; margin: 0px;\">Content</span></span></strong></p>\r\n<p style=\"padding: 0px; margin: 0px;\"><strong><span style=\"padding: 0px; margin: 0px; text-decoration: underline;\"><span style=\"font-size: medium; padding: 0px; margin: 0px;\"><br style=\"padding: 0px; margin: 0px;\" /></span></span></strong></p>\r\n<p style=\"padding: 0px; margin: 0px;\">To enter the content go to login to \"<strong>admin -&gt;CMS-&gt;pages-&gt;Press</strong>\" page</p>\r\n<p style=\"padding: 0px; margin: 0px;\">&nbsp;</p>\r\n<p style=\"padding: 0px; margin: 0px;\"><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry''s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n<p style=\"padding: 0px; margin: 0px;\">&nbsp;</p>\r\n</div>",
    'creation_time'     => now(),
    'update_time'       => now(),
));
$connection->insert($installer->getTable('cms/page_store'), array(
    'page_id'   => $connection->lastInsertId(),
    'store_id'  => 1
));

//updates

$connection->update($installer->getTable('cms/page'), array(
'layout_update_xml'=>"<reference name=\"head\">\r\n<action method=\"addCss\"><stylesheet>css/homecontent.css</stylesheet></action>\r\n<action method=\"addCss\"><stylesheet>css/header.css</stylesheet></action>\r\n<action method=\"addJs\"><script>prototype/prototype.js</script></action>\r\n  <action method=\"addJs\"><script>scriptaculous/effects.js</script></action>\r\n <action method=\"addCss\"><stylesheet>css/reset.css</stylesheet></action>\r\n<action method=\"addItem\"><type>skin_js</type><name>js/sleight.js</name></action>\r\n</reference>"), 
"identifier='previewpage'"
);

$connection->update($this->getTable('cms/block'), array(
'content'=>"<div class=\"clsfoot-txt\">\r\n<div class=\"clearfix\">\r\n<div class=\"clsfoot-div\">\r\n<h4>Navigate</h4>\r\n<ul class=\"clsfooterul\">\r\n<li><a href=\"{{store url =\'\'catalog/seo_sitemap/category\'\'}}\">Site Map</a></li><li><a href=\"{{store url =\'\'catalogsearch/advanced\'\'}}\">Advanced Search</a></li>\r\n<li><a href=\"{{store url =\'\'rssfeed\'\'}}\">RSS Feed</a></li>\r\n</ul>\r\n</div>\r\n<div class=\"clsfoot-div\">\r\n<h4>About</h4>\r\n<ul class=\"clsfooterul\">\r\n<li><a href=\"{{store url =\'\'works\'\'}}\">How It Works</a></li>\r\n<li><a href=\"{{store url =\'\'about\'\'}}\">About Us</a></li>\r\n<li><a href=\"{{store url =\'\'faq\'\'}}\">Faq</a></li>\r\n</ul>\r\n</div>\r\n<div class=\"clsfoot-div\">\r\n<h4>Terms</h4>\r\n<ul class=\"clsfooterul\">\r\n<li><a href=\"{{store url =\'\'privacy\'\'}}\">Privacy Policy</a></li>\r\n<li><a href=\"{{store url =\'\'terms\'\'}}\">Terms and Conditions</a></li>\r\n<li><a href=\"{{store url =\'\'press\'\'}}\">Press</a></li>\r\n</ul>\r\n</div>\r\n<ul class=\"clsfooterlogo\">\r\n<li><a href=\"{{store url=\'\'\'\'}}\" target=\"_blank\"><img title=\"Store\" src=\"{{skin url=\'\'images/logo.png\'\'}}\" alt=\"Store\" /></a></li>\r\n</ul>\r\n<div class=\"clscopyright\">&copy;2010 {{config path=\"general/store_information/name\"}}. All rights reserved.</div>\r\n</div></div>"), 
"identifier='footer_links'"
);

//cms_block

$connection->insert($installer->getTable('cms/block'), array(
    'title'             => 'How to use coupon',
    'identifier'        => 'coupon-use',
    'content'           => "<p><span style=\"color: #181818; font-family: Arial, Helvetica, sans-serif; font-size: 20px;\"><strong>How to use this: </strong> </span></p>\r\n<p><span style=\"color: #181818; font-family: Arial, Helvetica, sans-serif; font-size: 12px;\">1. Print coupon. We recommend that you re-use the back-side of this paper for your next coupon, and help reduce waste.  <br /> 2. Check the<strong> Fine Print.</strong> Make an appointment or reservation if required.  <br /> 3. Present coupon to merchant.  <br /> 4. Enjoy!  <br /><br />*Remember: Customers <strong>tip on the full amount</strong> of the pre-discounted service (and tip generously).  We support sustainable businesses because they share our values.</span></p>",
    'creation_time'     => now(),
    'update_time'       => now(),
));

$connection->insert($installer->getTable('cms/block_store'), array(
    'block_id'   => $connection->lastInsertId(),
    'store_id'  => 1
));

$connection->insert($installer->getTable('cms/block'), array(
    'title'             => 'Coupon footer',
    'identifier'        => 'coupon-footer',
    'content'           => "<table cellspacing=\"0\" cellpadding=\"0\" width=\"100%\" bgcolor=\"#dbdbdb\">\r\n<tbody>\r\n<tr>\r\n<td width=\"5%\">&nbsp;</td>\r\n<td style=\"padding: 5px 0;\" width=\"48%\"><span style=\"font-family: Arial, Helvetica, sans-serif; font-size: xx-small;\"> Support: 1-800-650-1030 Monday-Friday 10am-6pm IST</span></td>\r\n<td width=\"2%\">&nbsp;</td>\r\n<td style=\"padding: 5px 0;\" width=\"40%\" valign=\"top\"><span style=\"font-family: Arial, Helvetica, sans-serif; font-size: xx-small;\">Email : {{config path=\"trans_email/ident_general/email\"}}</span></td>\r\n<td width=\"5%\">&nbsp;</td>\r\n</tr>\r\n</tbody>\r\n</table>",
    'creation_time'     => now(),
    'update_time'       => now(),
));

$connection->insert($installer->getTable('cms/block_store'), array(
    'block_id'   => $connection->lastInsertId(),
    'store_id'  => 1
));

$connection->insert($installer->getTable('cms/block'), array(
    'title'             => 'Privacy Policy',
    'identifier'        => 'privacypolicy',
    'content'           => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus vulputate pharetra tincidunt. Praesent vitae mauris lacus, sed sollicitudin lorem. Sed tellus ligula, mollis non iaculis nec, feugiat consequat est. Cras elit leo, malesuada malesuada ultricies et, lacinia ac orci. In hac habitasse platea dictumst. Aliquam pellentesque erat non dui varius ultrices. Vivamus tincidunt consequat ipsum, at imperdiet neque cursus a. Nam vel tellus et velit malesuada pulvinar nec a lectus. Vivamus enim nibh, varius in facilisis in, ultrices eu nibh. Pellentesque tristique metus nec sem pharetra posuere venenatis diam aliquet. Duis in augue turpis, nec volutpat elit. Nullam semper egestas orci, et congue nisl ultricies eget. Mauris nec nisi a turpis egestas venenatis. Cras sed est ac ipsum vulputate mollis.",
    'creation_time'     => now(),
    'update_time'       => now(),
));

$connection->insert($installer->getTable('cms/block_store'), array(
    'block_id'   => $connection->lastInsertId(),
    'store_id'  => 1
));

$connection->insert($installer->getTable('cms/block'), array(
    'title'             => 'Footer iphone App',
    'identifier'        => 'footer-iphone',
    'content'           => "<p><a href=\"http://itunes.apple.com/app/groupclone/id413499577?mt=8\" target=\"_blank\"><img src=\"{{media url=\"footer/icon_iphone.png\"}}\" alt=\"Iphone App\" /></a><a></a></p>\r\n<p><a> </a></p>\r\n<h4><a></a><a href=\"http://itunes.apple.com/app/groupclone/id413499577?mt=8\" target=\"_blank\">Download iPhone App</a></h4>\r\n<p><a href=\"http://itunes.apple.com/app/groupclone/id413499577?mt=8\" target=\"_blank\">Get iPhone App. Just one click away</a></p>",
    'creation_time'     => now(),
    'update_time'       => now(),
	'is_active'			=>	0
));

$connection->insert($installer->getTable('cms/block_store'), array(
    'block_id'   => $connection->lastInsertId(),
    'store_id'  => 1
));

$connection->insert($installer->getTable('cms/block'), array(
    'title'             => 'Footer Merchant',
    'identifier'        => 'footer-merchant',
    'content'           => "<p><a href=\"{{store url ='merchant'}}\"><img src=\"{{media url=\"footer/icon_mlogin.png\"}}\" alt=\"Merchant Login\" /></a></p>\r\n<h4><a href=\"{{store url ='merchant'}}\">Merchant Login</a></h4>\r\n<p><a href=\"{{store url ='merchant'}}\">Merchant Login - Start your own deal and enjoy the benefit</a></p>",
    'creation_time'     => now(),
    'update_time'       => now(),
));

$connection->insert($installer->getTable('cms/block_store'), array(
    'block_id'   => $connection->lastInsertId(),
    'store_id'  => 1
));

$connection->insert($installer->getTable('cms/block'), array(
    'title'             => 'Footer refer a friend',
    'identifier'        => 'footer-refer',
    'content'           => "<p><a href=\"{{store url ='advertsystem/index/invitation'}}\"><img src=\"{{media url=\"footer/icon_friend.png\"}}\" alt=\"\" /></a></p>\r\n<h4><a href=\"{{store url ='advertsystem/index/invitation'}}\">Invite your Friends ! </a></h4>\r\n<p><a href=\"{{store url ='advertsystem/index/invitation'}}\">Refer a friend and get discount, via Advert System</a></p>",
    'creation_time'     => now(),
    'update_time'       => now(),
));

$connection->insert($installer->getTable('cms/block_store'), array(
    'block_id'   => $connection->lastInsertId(),
    'store_id'  => 1
));

$connection->insert($installer->getTable('cms/block'), array(
    'title'             => 'Footer Paypal',
    'identifier'        => 'footer-paypal',
    'content'           => "<p><a onclick=\"javascript:window.open('https://www.paypal.com/us/cgi-bin/webscr?cmd=xpt/Marketing/popup/OLCWhatIsPayPal-outside','paypal','width=600,height=350,left=0,top=0,location=no,status=yes,scrollbars=yes,resizable=yes''); return false;\" href=\"#!\"><img src=\"{{media url=\"footer/icon_paypal.png\"}}\" alt=\"PayPal\" /></a></p>\r\n<h4><a onclick=\"javascript:window.open(''https://www.paypal.com/us/cgi-bin/webscr?cmd=xpt/Marketing/popup/OLCWhatIsPayPal-outside'',''paypal'',''width=600,height=350,left=0,top=0,location=no,status=yes,scrollbars=yes,resizable=yes''); return false;\" href=\"#!\">Secure PayPal</a></h4>\r\n<p><a onclick=\"javascript:window.open(''https://www.paypal.com/us/cgi-bin/webscr?cmd=xpt/Marketing/popup/OLCWhatIsPayPal-outside'',''paypal'',''width=600,height=350,left=0,top=0,location=no,status=yes,scrollbars=yes,resizable=yes'); return false;\" href=\"#!\">Make a secure payment via PayPal.</a></p>",
    'creation_time'     => now(),
    'update_time'       => now(),
));

$connection->insert($installer->getTable('cms/block_store'), array(
    'block_id'   => $connection->lastInsertId(),
    'store_id'  => 1
));

$connection->insert($installer->getTable('cms/block'), array(
    'title'             => 'Footer Featured Business',
    'identifier'        => 'footer-fbusiness',
    'content'           => "<p><a href=\"{{store url ='fbusiness'}}\"><img title=\"fbusiness\" src=\"{{media url=\"footer/fbusiness-1.png\"}}\" alt=\"fbusiness\" /></a></p>\r\n<h4><a href=\"{{store url ='fbusiness'}}\">For Your Business</a></h4>\r\n<p><a href=\"{{store url =''fbusiness''}}\">Get your business featured on {{config path=\"general/store_information/name\"}} and enjoy the benefits.</a></p>",
    'creation_time'     => now(),
    'update_time'       => now(),
));

$connection->insert($installer->getTable('cms/block_store'), array(
    'block_id'   => $connection->lastInsertId(),
    'store_id'  => 1
));


//insert config data - wishlist
$connection->insert($installer->getTable('core_config_data'), array(
    'scope'         => 'default',
    'scope_id'      => 0,
    'path'          => "wishlist/general/active",
    'value'     	=> 0,   
));

//$installer->getConnection()->update($attributeTable, array('value'=>$value), "value_id=" . $row['value_id']);



$installer->run("
ALTER TABLE {$installer->getTable('gift_message')} ADD `email` VARCHAR(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL;
ALTER TABLE {$installer->getTable('gift_message')} ADD `product_id` INT NOT NULL;
ALTER TABLE {$installer->getTable('gift_message')} ADD `order_id` INT NOT NULL;
");


$connection->insert($installer->getTable('admin_role'), array(
    'parent_id'     => 0,
    'tree_level'    => 1,
    'sort_order'    => 0,
    'role_type'    	=> 'G',
	'user_id'		=>	0,
	'role_name'		=> 'merchant'
));

$lastInsertRole = $connection->lastInsertId();


$installer->run("
INSERT INTO {$installer->getTable('admin_rule')} (`role_id`, `resource_id`, `privileges`,
`assert_id`, `role_type`, `permission`) VALUES
($lastInsertRole, 'all', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/dashboard', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/system', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/system/acl', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/system/acl/roles', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/system/acl/users', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/system/store', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/system/design', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/system/config', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/system/config/general', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/system/config/web', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/system/config/design', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/system/config/system', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/system/config/advanced', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/system/config/trans_email', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/system/config/dev', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/system/config/currency', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/system/config/sendfriend', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/system/config/admin', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/system/config/cms', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/system/config/customer', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/system/config/catalog', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/system/config/payment', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/system/config/payment_services', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/system/config/sales', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/system/config/sales_email', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/system/config/sales_pdf', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/system/config/shipping', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/system/config/carriers', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/system/config/checkout', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/system/config/paypal', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/system/config/google', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/system/config/reports', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/system/config/tax', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/system/config/wishlist', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/system/config/cataloginventory', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/system/config/contacts', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/system/config/sitemap', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/system/config/newsletter', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/system/config/rss', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/system/config/api', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/system/config/downloadable', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/system/config/license', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/system/config/videoupload', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/system/config/advertsystem', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/system/config/offlineMaintenance', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/system/config/constantcontact', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/system/config/deal', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/system/config/mailchimp', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/system/config/twitterbox', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/system/config/moneybookers', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/system/currency', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/system/email_template', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/system/variable', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/system/myaccount', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/system/tools', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/system/tools/backup', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/system/tools/compiler', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/system/convert', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/system/convert/gui', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/system/convert/profiles', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/system/cache', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/system/extensions', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/system/extensions/local', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/system/extensions/custom', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/system/index', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/system/api', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/system/api/users', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/system/api/roles', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/system/license', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/global_search', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/cms', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/cms/block', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/cms/page', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/cms/page/save', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/cms/page/delete', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/customer', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/customer/group', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/customer/manage', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/customer/online', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/catalog', '', 0, 'G', 'allow'),
($lastInsertRole, 'admin/catalog/attributes', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/catalog/attributes/attributes', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/catalog/attributes/sets', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/catalog/categories', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/catalog/products', '', 0, 'G', 'allow'),
($lastInsertRole, 'admin/catalog/update_attributes', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/catalog/urlrewrite', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/catalog/reviews_ratings', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/catalog/reviews_ratings/ratings', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/catalog/sitemap', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/catalog/googlebase', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/catalog/googlebase/types', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/catalog/googlebase/items', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/catalog/videoupload', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/sales', '', 0, 'G', 'allow'),
($lastInsertRole, 'admin/sales/order', '', 0, 'G', 'allow'),
($lastInsertRole, 'admin/sales/order/actions', '', 0, 'G', 'allow'),
($lastInsertRole, 'admin/sales/order/actions/create', '', 0, 'G', 'allow'),
($lastInsertRole, 'admin/sales/order/actions/view', '', 0, 'G', 'allow'),
($lastInsertRole, 'admin/sales/order/actions/reorder', '', 0, 'G', 'allow'),
($lastInsertRole, 'admin/sales/order/actions/edit', '', 0, 'G', 'allow'),
($lastInsertRole, 'admin/sales/order/actions/cancel', '', 0, 'G', 'allow'),
($lastInsertRole, 'admin/sales/order/actions/review_payment', '', 0, 'G', 'allow'),
($lastInsertRole, 'admin/sales/order/actions/capture', '', 0, 'G', 'allow'),
($lastInsertRole, 'admin/sales/order/actions/invoice', '', 0, 'G', 'allow'),
($lastInsertRole, 'admin/sales/order/actions/creditmemo', '', 0, 'G', 'allow'),
($lastInsertRole, 'admin/sales/order/actions/hold', '', 0, 'G', 'allow'),
($lastInsertRole, 'admin/sales/order/actions/unhold', '', 0, 'G', 'allow'),
($lastInsertRole, 'admin/sales/order/actions/ship', '', 0, 'G', 'allow'),
($lastInsertRole, 'admin/sales/order/actions/comment', '', 0, 'G', 'allow'),
($lastInsertRole, 'admin/sales/order/actions/emails', '', 0, 'G', 'allow'),
($lastInsertRole, 'admin/sales/invoice', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/sales/shipment', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/sales/creditmemo', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/sales/transactions', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/sales/transactions/fetch', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/sales/recurring_profile', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/sales/billing_agreement', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/sales/billing_agreement/actions', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/sales/billing_agreement/actions/view', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/sales/billing_agreement/actions/manage', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/sales/billing_agreement/actions/use', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/sales/checkoutagreement', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/sales/tax', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/sales/tax/classes_customer', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/sales/tax/classes_product', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/sales/tax/import_export', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/sales/tax/rates', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/sales/tax/rules', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/sales/couponvalidator', '', 0, 'G', 'allow'),
($lastInsertRole, 'admin/promo', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/promo/quote', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/report', '', 0, 'G', 'allow'),
($lastInsertRole, 'admin/report/salesroot', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/report/salesroot/paypal_settlement_reports', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/report/salesroot/paypal_settlement_reports/view', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/report/salesroot/paypal_settlement_reports/fetch', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/report/salesroot/sales', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/report/salesroot/tax', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/report/salesroot/shipping', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/report/salesroot/invoiced', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/report/salesroot/refunded', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/report/salesroot/coupons', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/report/salesroot/deals', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/report/shopcart', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/report/shopcart/product', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/report/shopcart/abandoned', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/report/products', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/report/products/ordered', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/report/products/sold', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/report/products/viewed', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/report/products/lowstock', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/report/products/downloads', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/report/deals', '', 0, 'G', 'allow'),
($lastInsertRole, 'admin/report/deals/sold', '', 0, 'G', 'allow'),
($lastInsertRole, 'admin/report/customers', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/report/customers/accounts', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/report/customers/totals', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/report/customers/orders', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/report/customers/dealreports', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/report/review', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/report/review/customer', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/report/review/product', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/report/tags', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/report/tags/customer', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/report/tags/popular', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/report/tags/product', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/report/search', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/report/statistics', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/newsletter', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/newsletter/problem', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/newsletter/queue', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/newsletter/subscriber', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/newsletter/template', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/advertsystem', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/advertsystem/rules', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/advertsystem/referral', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/advertsystem/config', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/Contus_Background', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/Contus_Ordercustomer', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/Contus_Share', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/Gclone_Advertsystem', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/Gclone_All', '', 0, 'G', 'deny'),
($lastInsertRole, 'admin/Gclone_Deal', '', 0, 'G', 'deny');
");


$installer->endSetup();
