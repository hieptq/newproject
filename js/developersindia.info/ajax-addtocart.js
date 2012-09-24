// General Functions
var request_uri;
var checkout_cart_url;
var updateLinkUrl;
var ok_button_label;
var cancel_button_label;
var delete_confirm_text;
var enable_success_message;
var button_bg_color
var button_border_color;
var button_font_color;
var di_ajax_add_to_cart_main_div_id = "di_ajax_add_to_cart_main_div";
var product_type_data_container_id = "product_type_data_container";
var di_ajax_add_to_cart_main_div_container_id = "di_ajax_add_to_cart_main_div_container";
var di_ajaxaddtocart_product_addtocart_form_id = "ajaxaddtocart_product_addtocart_form";

function setAllTheUrls(php_request_uri, php_checkout_cart_url, php_updateLinkUrl, php_homeUrl, php_ok_button_label, php_cancel_button_label, php_delete_confirm_text, php_enable_success_message, php_button_bg_color, php_button_border_color, php_button_font_color){
	request_uri = php_request_uri;
	checkout_cart_url = php_checkout_cart_url;
	updateLinkUrl = php_updateLinkUrl;	
	home_url = php_homeUrl;
	ok_button_label = php_ok_button_label;
	cancel_button_label = php_cancel_button_label;
	delete_confirm_text = php_delete_confirm_text;
	enable_success_message = php_enable_success_message;
	button_bg_color = php_button_bg_color;
	button_border_color = php_button_border_color;
	button_font_color = php_button_font_color;
}

function setLocation(url){
	url = prepareAjaxaddtocartUrl(url);
	strurl = url;
	//alert(strurl);
	var match1 = /options=cart/.test(strurl);
	var match2 = /checkout\/onepage/.test(strurl);
	var match3 = /limit\=\w+/.test(strurl);
	var match4 = /order\=\w+\&dir\=\w+/.test(strurl);
	var match5 = /dir\=\w+\&order\=\w+/.test(strurl);
	
	var checkForCartAddToCart = /in_cart\/1/.test(strurl)
	if(checkForCartAddToCart){
		return inCartAddToCart(strurl);
	}
	
	var ajax = true;
	if(match1){
		ajax = false;
	}
	if(match2){
		ajax = false;
	}
	if(match3){
		ajax = false;
	}
	if(match4){
		ajax = false;
	}
	if(match5){
		ajax = false;
	}
	
	if(strurl==home_url){
		ajax = false;
	}
	
	if(ajax){
		diShowLayer(); // Element.show('loading-mask');  
		
		new Ajax.Request(url, {
          onSuccess: function(transport) {
			  diHideLayer(); //Element.hide('loading-mask');  
			  var json = transport.responseText.evalJSON();
			  
			  if(json.r=="failure"){
				alert(json.message);
				// window.location = json.redirect_url;
			  }else if(json.product_type_data){
				/* $('product_type_data_temp_container').innerHTML = json.product_type_data;
				
				var onlyRequiredHtml = "";
				$$('div#product_type_data_temp_container div.product-shop').each(function(elem){
					onlyRequiredHtml = elem.innerHTML;
				});
				
				$('product_type_data_container').innerHTML = onlyRequiredHtml;
				var scripts = json.product_type_data.extractScripts();
				for(var i=0; i<scripts.length; i++){
					var code = scripts[i].strip().gsub(/var\s+/, '');
					eval(code);
				}
				$('product_type_data_container').show(); */
				
				// $('product_type_data_container').innerHTML = json.product_type_data;
				// var scripts = json.product_type_data.extractScripts();
				// for(var i=0; i<scripts.length; i++){
					// var code = scripts[i].strip().gsub(/var\s+/, '');
					// eval(code);
				// }
				// $('product_type_data_container').show();
				
				// showProductTypeDataPopup(json.product_type_data);
				showProductTypeDataPopup(json);
			  }else{
				showDialog(json.message);
				updateTopCartLink(json.topCartText);
				if(json.cart){
					updateSideBarCart(json.cart);
				}
				if(json.big_cart){
					updateBigCart(json.big_cart);
				}				
				findAndCleanUpDeleteUrls();
			}
          }, method: "get"
		});
	}else{
		window.location.href = url;
	}
	
}

function setPLocation(url, setFocus){
	var patt1=new RegExp("/checkout/cart/add/product/");
	if(patt1.test(url)){
		url = prepareAjaxaddtocartUrl(url);
		diShowLayer() //Element.show('loading-mask');  
		new Ajax.Request(url, {
          onSuccess: function(transport) {
			  diHideLayer(); //Element.hide('loading-mask');  
			  var json = transport.responseText.evalJSON();
			  
			  if(json.r=="failure"){
				window.blur();
				window.opener.location.href = json.redirect_url;
			  }else{
				showDialog(json.message, 'compare_page');
				window.opener.location.reload();
			}
          }, method: "get"
		});
	}else{
		if( setFocus ) {
			window.opener.focus();
		}
		window.opener.location.href = url;
	}
}

function inCartAddToCart(strurl){
	diShowLayer(); // Element.show('loading-mask'); 
	strurl = prepareAjaxaddtocartUrl(strurl);
	new Ajax.Request(strurl, {
	  onSuccess: function(transport) {
		  diHideLayer(); // Element.hide('loading-mask');  
		  
		  
			var json = transport.responseText.evalJSON();
					
			if(json.r=="failure"){
				alert(json.message);
				// window.location = json.redirect_url;
			}else if(json.product_type_data){
				// showProductTypeDataPopup(json.product_type_data);
				showProductTypeDataPopup(json);
			}else{
				updateTopCartLink(json.topCartText);
				if(json.cart){
					updateSideBarCart(json.cart);
				}
				if(json.big_cart){
					updateBigCart(json.big_cart);
				}
				//document.getElementById('main').innerHTML = json.cart;
				
				var scripts = json.cart.extractScripts();
				for(var i=0; i<scripts.length; i++){
					var code = scripts[i].strip().gsub(/var\s+/, '');
					eval(code);
				}
				
				//Effect.BlindDown('main');
				findAndCleanUpDeleteUrls();
			}	  
			
	  }, method: "get"
	});
}

function findAndCleanUpDeleteUrls(){
	var patt1=new RegExp("/checkout/cart/delete/");
	for(i=0;i<document.links.length;i++){
		if(patt1.test(document.links[i])){
			url_with_random_chars = document.links[i].href;
			clean_url = url_with_random_chars.replace(/\/uenc\/\w*\W*/i, "/")
			document.links[i].id = clean_url;
			var patt2=new RegExp("/checkout/cart/");
			if(patt2.test(request_uri)){
		//		document.links[i].href = "javascript:ajaxDeleteCartProduct('"+document.links[i].id+"')";		
			}else{
	//			document.links[i].href = "javascript:ajaxDeleteProduct('"+document.links[i].id+"')";		
			}
			
			document.links[i].onclick = "";
					
		}
	}
	
	// also update all add to cart href links
	updateAllHrefLinksToUseSetLocation();
}


// Product Detail Page Functions


var productAddToCartForm = new VarienForm('product_addtocart_form');
productAddToCartForm.submit = function(){
		// alert('submit');
		if (this.validator.validate()) {
			diShowLayer(); // Element.show('loading-mask');  
			
			$('product_addtocart_form').action = prepareAjaxaddtocartUrl($('product_addtocart_form').action);
			
			// do the same with a callback:
			$('product_addtocart_form').request({
				onComplete: function(transport){ 
					// diHideLayer(); // Element.hide('loading-mask');
					
					var json = transport.responseText.evalJSON();
					// alert(json);
					if(json.r=="failure"){
						alert(json.message);
						// window.location = json.redirect_url;
					}else{
					
						showDialog(json.message);
						updateTopCartLink(json.topCartText);
						updateSideBarCart(json.cart);
						findAndCleanUpDeleteUrls();
					}
				}, parameters:'skip_pt_check=1'
			})

		}
}.bind(productAddToCartForm);

var ajaxAddToCartProductAddToCartForm = new VarienForm(di_ajaxaddtocart_product_addtocart_form_id);
ajaxAddToCartProductAddToCartForm.submit = function(){
		// alert('submit');
		if (this.validator.validate()) {
			diShowLayer(); // Element.show('loading-mask');  
			
			$(di_ajaxaddtocart_product_addtocart_form_id).action = prepareAjaxaddtocartUrl($(di_ajaxaddtocart_product_addtocart_form_id).action);
			
			// do the same with a callback:
			$(di_ajaxaddtocart_product_addtocart_form_id).request({
				onComplete: function(transport){ 
					// diHideLayer(); // Element.hide('loading-mask');
					
					var json = transport.responseText.evalJSON();
					// alert(json);
					if(json.r=="failure"){
						alert(json.message);
						// window.location = json.redirect_url;
					}else{
					
						showDialog(json.message);
						updateTopCartLink(json.topCartText);
						updateSideBarCart(json.cart);
						findAndCleanUpDeleteUrls();
					}
				}, parameters:'skip_pt_check=1'
			})

		}
}.bind(ajaxAddToCartProductAddToCartForm);


// Cart Page Functions
function ajaxDeleteCartProduct(url){	

	if(makeDeleteConfirm()){
		url = prepareAjaxaddtocartUrl(url);
		diShowLayer(); // Element.show('loading-mask');  
		url += "request_from/checkout/";
		
		new Ajax.Request(url, {  
		method: 'get',
		onComplete: function(transport) {  
		
			diHideLayer(); // Element.hide('loading-mask');
		
			// option 1 start
			var json = transport.responseText.evalJSON();
					
			if(json.r=="failure"){
				alert(json.message);
				// window.location = json.redirect_url;
			}else{
			
				updateTopCartLink(json.topCartText);
				updateBigCart(json.cart);
				//document.getElementById('main').innerHTML = json.cart;
				
				var scripts = json.cart.extractScripts();
				for(var i=0; i<scripts.length; i++){
					var code = scripts[i].strip().gsub(/var\s+/, '');
					eval(code);
				}
				
				//Effect.BlindDown('main');
				findAndCleanUpDeleteUrls();
			}
			
			// option 1 end
		}
			
		});
	}
}

// Side Bar Functions

function ajaxDeleteProduct(url){
	if(makeDeleteConfirm()){
		url = prepareAjaxaddtocartUrl(url);
		diShowLayer(); // Element.show('loading-mask');  
		new Ajax.Request(url, {  
		method: 'get',  
		onComplete: function(transport) {  
		diHideLayer(); // Element.hide('loading-mask');  
		var json = transport.responseText.evalJSON();
		updateSideBarCart(json.cart);
		updateTopCartLink(json.topCartText);
		findAndCleanUpDeleteUrls();
		}  
		});  
	}
}

function updateSideBarCart(jsonCart){
	var divs = document.getElementsByTagName('div');
	for (var i = 0; i < divs.length; i++) {
		var div = divs[i];
		//if(div.className=="box base-mini mini-cart"){
		if(div.className=="block block-cart"){		
			div.innerHTML = jsonCart;
			div.className = "";
			Effect.BlindDown(div);
			break;
		}
	}
}

function updateBigCart(jsonCart){
	var divs = document.getElementsByTagName('div');
	for (var i = 0; i < divs.length; i++) {
		var div = divs[i];
		if(div.className=="main"){
			div.innerHTML = jsonCart;
			Effect.BlindDown(div);
			break;
		}
	}
}

function makeDeleteConfirm(){
	if(window.confirm(delete_confirm_text)){
		return true;
	}
	return false;
}

function updateTopCartLink(topCartText){
	var aS = document.getElementsByTagName('a');
	for (var i = 0; i < aS.length; i++) {
		var a = aS[i];
		if(a.className=="top-link-cart"){
			a.innerHTML = topCartText;
			a.title = topCartText;
			return;
		}
	}
}

function showDialog(jsonMessage, from){
	if(enable_success_message=="1"){
	
		inputButtons = "<input type='button' name='finish_and_checkout' id='finish_and_checkout' value='"+ok_button_label+"'  /><input type='button' name='continue_shopping' id='continue_shopping' value='"+cancel_button_label+"'/>";
		
		/*scriptCode = "<script type='text/javascript'>";
		scriptCode += "$('finish_and_checkout').observe('click', function(){location.href = checkout_cart_url;});";
		scriptCode += "$('continue_shopping').observe('click', function(){Effect.DropOut('after-loading-success-message')});"
		
		scriptCode += "</script>";*/
		
		scriptCode = "<script type='text/javascript'>";
		if(from=='compare_page'){	
			scriptCode += "$('finish_and_checkout').observe('click', function(){ Effect.DropOut('after-loading-success-message'); window.opener.location.href = checkout_cart_url; window.opener.focus(); });";
			//scriptCode += "$('finish_and_checkout').observe('click', function(){location.href = checkout_cart_url;});";
		}else{
			scriptCode += "$('finish_and_checkout').observe('click', function(){location.href = checkout_cart_url;});";
		}
		// scriptCode += "$('continue_shopping').observe('click', function(){Effect.DropOut('after-loading-success-message')});"
		scriptCode += "$('continue_shopping').observe('click', function(){hideDialog()});"
		
		scriptCode += "</script>";
		
		
	
	
		Element.update('success-message-container', jsonMessage+inputButtons+scriptCode);
		diShowOnlyLayer();
		// $(di_ajax_add_to_cart_main_div_container_id).show();
		placeElementInCenter('after-loading-success-message');
		Element.show('after-loading-success-message');	
		
	}
	return;
}

function hideDialog(){
	// Effect.DropOut('after-loading-success-message')
	$('after-loading-success-message').hide();
	// $(di_ajax_add_to_cart_main_div_container_id).hide();
	// diHideOnlyLayer();
	diHideLayer();
}

function updateAllHrefLinksToUseSetLocation(){
	var patt1=new RegExp("/checkout/cart/add/");
	for(i=0;i<document.links.length;i++){
		if(patt1.test(document.links[i])){
			url = document.links[i].href;
			document.links[i].href = "javascript:setLocation('"+url+"')";
		}
	}
}

function diShowLayer(){
	hideProductTypeDataPopup();
	diShowOnlyLayer(); // $(di_ajax_add_to_cart_main_div_id).show();
	// $(di_ajax_add_to_cart_main_div_container_id).show();
	
	placeElementInCenter('loading-mask');
	Element.show('loading-mask'); 
}

function diHideLayer(){
	diHideOnlyLayer(); // $(di_ajax_add_to_cart_main_div_id).hide();
	// $(di_ajax_add_to_cart_main_div_container_id).hide();
	Element.hide('loading-mask'); 
	resetAllSuperAttributes();
}

function diShowOnlyLayer(){
	$(di_ajax_add_to_cart_main_div_id).show();
	// $(di_ajax_add_to_cart_main_div_id).appear({ duration: 3.0 });
	// Effect.SlideDown($(di_ajax_add_to_cart_main_div_id));
}

function diHideOnlyLayer(){
	$(di_ajax_add_to_cart_main_div_id).hide();
	// $(di_ajax_add_to_cart_main_div_id).SlideUp();
	// Effect.SlideUp($(di_ajax_add_to_cart_main_div_id));
}

function showProductTypeDataPopup(json){
	diShowOnlyLayer(); // $(di_ajax_add_to_cart_main_div_id).show();
	// $(di_ajax_add_to_cart_main_div_container_id).show();
	content = json.product_type_data;
	$(product_type_data_container_id).innerHTML = content;
	
	// rename price id before running scripts from content
	renamePriceIds();
	
	var scripts = content.extractScripts();
	for(var i=0; i<scripts.length; i++){
		var code = scripts[i].strip().gsub(/var\s+/, '');
		eval(code);
	}
	
	placeElementInCenter(product_type_data_container_id);
	// $('product_type_data_container').getDimensions();
	
	$(product_type_data_container_id).show();
	
	// remove id of first price container which is in list page
	// alert(json.from_configure_action);
	// if(json.from_configure_action=="undefined"){
	// if(json.from_configure_action!=true){
		// if($(di_ajaxaddtocart_product_addtocart_form_id).product_type.value=="configurable"){
			// product_id = $(di_ajaxaddtocart_product_addtocart_form_id).product.value;
			// // alert(product_id);
			// // alert($('product-price-'+product_id));
			// // $('product-price-'+product_id).innerHTML = "";
			// if($('product-price-'+product_id)){
				// $('product-price-'+product_id).id = $('product-price-'+product_id).id+'-first';
			// }
		// }
	// }
}

function hideProductTypeDataPopup(){
	diHideOnlyLayer(); // $(di_ajax_add_to_cart_main_div_id).hide();
	// diHideLayer(); // $(di_ajax_add_to_cart_main_div_id).hide();
	// $(di_ajax_add_to_cart_main_div_container_id).hide();
	resetPriceIds();
	$(product_type_data_container_id).hide();
}

function placeElementInCenter(elementId){
	element = $(elementId);
	// var dimensions = element.getDimensions();
	width = element.getWidth();
	// alert(element + ' == width:'+ width);
	margin_left = 0;
	if(width>0){
		margin_left = parseInt(width) / parseInt(2);
	}
	// alert('margin_left: '+margin_left)
	// alert(dimensions.width + " -- -- " + margin_left);
	element.style.marginLeft = -margin_left+"px";
	element.style.left = '50%';
}

function diHideAll(){
	hideProductTypeDataPopup();
	diHideLayer();
}

function sidebarDelete(url){
	// if(makeDeleteConfirm()){
		url = prepareAjaxaddtocartUrl(url);
		diShowLayer(); // Element.show('loading-mask');  
		new Ajax.Request(url, {  
			method: 'get',  
			onComplete: function(transport) {  
				diHideLayer(); // Element.hide('loading-mask');  
				var json = transport.responseText.evalJSON();
				if(json.cart){
					updateSideBarCart(json.cart);
				}
				if(json.big_cart){
					updateBigCart(json.big_cart);
				}
				updateTopCartLink(json.topCartText);
				findAndCleanUpDeleteUrls();
			}  
		});  
	// }
}

function configureProduct(url){
	diShowLayer(); // Element.show('loading-mask');  
		
	url = prepareAjaxaddtocartUrl(url);
	new Ajax.Request(url, {
	  onSuccess: function(transport) {
		  diHideLayer(); //Element.hide('loading-mask');  
		  var json = transport.responseText.evalJSON();
		  
		  if(json.r=="failure"){
			alert(json.message);
			// window.location = json.redirect_url;
		  }else if(json.product_type_data){
			// showProductTypeDataPopup(json.product_type_data);
			showProductTypeDataPopup(json);
		  }else{
			showDialog(json.message);
			updateTopCartLink(json.topCartText);
			updateSideBarCart(json.cart);
			findAndCleanUpDeleteUrls();
		}
	  }, method: "get"
	});
}

function prepareAjaxaddtocartUrl(url){
	renameAllSuperAttributes();
	// renamePriceIds();
	url = url.sub('/checkout/', '/ajaxaddtocart/');
	return url;
}

function renameAllSuperAttributes(){
	$$('.super-attribute-select').each(function(e){
		e.removeClassName('super-attribute-select');
		e.addClassName('super-attribute-select-renamed');
	});
}

function resetAllSuperAttributes(){
	$$('.super-attribute-renamed').each(function(e){
		e.addClassName('super-attribute-select');
		e.removeClassName('super-attribute-select-renamed');
	});
}

function renamePriceIds(){
	product_id = $(di_ajaxaddtocart_product_addtocart_form_id).product.value;
	if($('product-price-'+product_id)){
		if($('product-price-'+product_id).up('form')){
			if($('product-price-'+product_id).up('form').id!=di_ajaxaddtocart_product_addtocart_form_id){
				$('product-price-'+product_id).id = $('product-price-'+product_id).id+'-old';
			}
		}else{
			$('product-price-'+product_id).id = $('product-price-'+product_id).id+'-old';
		}
	}
	if($('product-price-'+product_id+'_clone')){
		if($('product-price-'+product_id+'_clone').up('form')){
			if($('product-price-'+product_id+'_clone').up('form').id!=di_ajaxaddtocart_product_addtocart_form_id){
				$('product-price-'+product_id+'_clone').id = $('product-price-'+product_id+'_clone').id+'-old';
			}
		}else{
			$('product-price-'+product_id+'_clone').id = $('product-price-'+product_id+'_clone').id+'-old';
		}
	}
}

function resetPriceIds(){
	if($(di_ajaxaddtocart_product_addtocart_form_id)){
		product_id = $(di_ajaxaddtocart_product_addtocart_form_id).product.value;
		if($('product-price-'+product_id+'-old')){
			if($('product-price-'+product_id)){
				$('product-price-'+product_id+'-old').id = $('product-price-'+product_id).id;
			}
		}
		if($('product-price-'+product_id+'_clone-old')){
			if($('product-price-'+product_id+'_clone')){
				$('product-price-'+product_id+'_clone-old').id = $('product-price-'+product_id+'_clone').id;
			}
		}
	}
}