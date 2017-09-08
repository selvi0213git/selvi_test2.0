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

/**
 * Selvi UI Scripts
 * ui.kboardToggle
 */

/* Run Globally */
jQuery(function() {
	ui.kboardToggle();
});

/* UI Methods */
var ui = {

	/**
	 * Kboard Toggle
	 */
	"kboardToggle": function() {
		jQuery(".kboard-selvi").each(function() {
			jQuery(this).find(".kboard-list-title").find("a").on("click", function(e) {
				e.preventDefault();
				jQuery(this).find(".content-view").slideToggle("fast");
				jQuery(this).parents("tr").toggleClass("open");
				jQuery(this).parents("tr").next(".kboard-list-reply").toggle();
			});
		});
	},//end kboardToggle

	/**
	 * Open magnificpopup
	 * doc: http://dimsemenov.com/plugins/magnific-popup/documentation.html
	 * need 'magnific-popup.css'
	 * need 'jquery.magnific-popup.min.js'
	 */
	"openModal": function(jQuerysrc, jQuerytype) {
		jQuery.magnificPopup.open({
	    items: {
	      src: jQuerysrc,
	      type: jQuerytype
	    },
	    closeOnBgClick: false
	  });
	},//end openModal

	/**
	 * Filebox
	 */
	"filebox" : function() {
		var fileTarget = jQuery('.filebox .hidden-input-file');

	  fileTarget.on('change', function(){  // 값이 변경되면
	    if(window.FileReader){  // modern browser
	      var filename = jQuery(this)[0].files[0].name;
	    }
	    else {  // old IE
	      var filename = jQuery(this).val().split('/').pop().split('\\').pop();  // 파일명만 추출
	    }

	    // 추출한 파일명 삽입
	    jQuery(this).siblings('.input-file-name').val(filename);
	  });
	},//end filebox
}//ui

/**
 * Eley UI Scripts
 * add script
 */
 
//textarea 크기자동조절
/*
function resize(obj){
	obj.style.height = "1px";
	obj.style.height = (20+obj.scrollHeight)+"px";
}
*/