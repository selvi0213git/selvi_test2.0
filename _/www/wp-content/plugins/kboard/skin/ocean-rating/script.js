/**
 * @author http://www.cosmosfarm.com/
 */

var console = window.console || { log: function() {} };

function kboard_editor_execute(form){
	jQuery.fn.exists = function(){
		return this.length>0;
	}
	
	if(!jQuery('input[name=title]', form).val()){
		alert(kboard_localize.please_enter_a_title);
		jQuery('input[name=title]', form).focus();
		return false;
	}
	else if(jQuery('input[name=member_display]', form).eq(1).exists() && !jQuery('input[name=member_display]', form).eq(1).val()){
		alert(kboard_localize.please_enter_a_author);
		jQuery('[name=member_display]', form).eq(1).focus();
		return false;
	}
	else if(jQuery('input[name=password]', form).exists() && !jQuery('input[name=password]', form).val()){
		alert(kboard_localize.please_enter_a_password);
		jQuery('input[name=password]', form).focus();
		return false;
	}
	else if(jQuery('input[name=captcha]', form).exists() && !jQuery('input[name=captcha]', form).val()){
		alert(kboard_localize.please_enter_the_CAPTCHA_code);
		jQuery('input[name=captcha]', form).focus();
		return false;
	}
	
	return true;
}

function kboard_rating_value(value){
	var rating_obj = jQuery('.kboard-rating');
	jQuery(rating_obj).removeClass();
	jQuery(rating_obj).addClass('kboard-rating').addClass('value-'+value);
	jQuery('input[name=kboard_option_rating]').val(value);
}