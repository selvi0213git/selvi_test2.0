/**
 * @author http://www.cosmosfarm.com/
 */
function cosmosfarm_members_open_postcode(){
	var width = 500;
	var height = 600;
	new daum.Postcode({
		width: width,
		height: height,
		oncomplete: function(data){
			jQuery('.cosmosfarm-members-form input[name="zip"]').val(data.zonecode);
			jQuery('.cosmosfarm-members-form input[name="addr1"]').val(data.roadAddress);
			
			jQuery('#billing_postcode').val(data.zonecode);
			jQuery('#billing_address_1').val(data.roadAddress);
		}
	}).open({
		left: (screen.availWidth-width)*0.5,
		top: (screen.availHeight-height)*0.5
	});
	return false;
}

function cosmosfarm_find_japan_address(){
	var zip = jQuery('.cosmosfarm-members-form input[name="zip"]').val();
	
	if(!zip){
		alert(cosmosfarm_members_localize_strings.please_enter_the_postcode);
		jQuery('.cosmosfarm-members-form input[name="zip"]').focus();
		return false;
	}
	
	jQuery.get('https://api.zipaddress.net/', {zipcode:zip, lang:'ja', callback:'cosmosfarm_japan_address_callback'});
}

function cosmosfarm_japan_address_callback(data){
	if(data.code == '400'){
		alert(data.message);
		jQuery('.cosmosfarm-members-form input[name="zip"]').focus();
	}
	else{
		jQuery('.cosmosfarm-members-form input[name="thestate"]').val(data.pref);
		jQuery('.cosmosfarm-members-form input[name="city"]').val(data.address);
	}
}

function cosmosfarm_members_avatar_form_submit(input){
	jQuery('#cosmosfarm_members_avatar_form').submit();
}

function cosmosfarm_members_check_password_strength(){
	var password1 = jQuery('.cosmosfarm-members-form input[name="password"]').val();
	var password2 = jQuery('.cosmosfarm-members-form input[name="confirm_password"]').val();
	
	//var strength = wp.passwordStrength.meter(password1, [], password2);
	var strength = cosmosfarm_members_get_password_strength(password1, password2);
	switch(strength){
		case 'mismatch':
			jQuery('.password-strength-meter-display').text(cosmosfarm_members_localize_strings.your_password_is_different);
			jQuery('.password-strength-meter-display').removeClass('good');
			jQuery('.password-strength-meter-display').addClass('bad');
			break;
		case 'short':
			jQuery('.password-strength-meter-display').text(cosmosfarm_members_localize_strings.password_must_consist_of_8_digits);
			jQuery('.password-strength-meter-display').removeClass('good');
			jQuery('.password-strength-meter-display').addClass('bad');
			break;
		case 'space':
			jQuery('.password-strength-meter-display').text(cosmosfarm_members_localize_strings.please_enter_your_password_without_spaces);
			jQuery('.password-strength-meter-display').removeClass('good');
			jQuery('.password-strength-meter-display').addClass('bad');
			break;
		case 'bad':
			jQuery('.password-strength-meter-display').text(cosmosfarm_members_localize_strings.password_must_consist_of_8_digits);
			jQuery('.password-strength-meter-display').removeClass('good');
			jQuery('.password-strength-meter-display').addClass('bad');
			break;
		default:
			jQuery('.password-strength-meter-display').text(cosmosfarm_members_localize_strings.it_is_a_safe_password);
			jQuery('.password-strength-meter-display').addClass('good');
			jQuery('.password-strength-meter-display').removeClass('bad');
	}
	return strength;
}

function cosmosfarm_members_get_password_strength(password1, password2){
	var number = password1.search(/[0-9]/g);
	var english = password1.search(/[a-z]/ig);
	var special = password1.search(/[~!@\#$%<>^&*\()\-=+_\,.;'"|\\]/ig);
	if(password2 && password1 != password2){
		return 'mismatch';
	}
	else if(password1.length < 8){
		return 'short';
	}
	else if(password1.search(/\s/g) != -1){
		return 'space';
	}
	else if(number < 0 || english < 0 || special < 0){
		return 'bad';
	}
	return 'good';
}

function cosmosfarm_members_certification(){
	IMP.certification({
		merchant_uid:'merchant_' + new Date().getTime(),
		min_age:cosmosfarm_members_settings.certification_min_age
	},
	function(rsp){
		if(rsp.success){
			jQuery.post('?action=cosmosfarm_members_certification_confirm', {imp_uid:rsp.imp_uid}, function(res){
				if(res.error_message){
					alert(res.error_message);
				}
				else{
					if(cosmosfarm_members_settings.certification_name_field){
						jQuery('input[name="'+cosmosfarm_members_settings.certification_name_field+'"]').val(res.name);
					}
					if(cosmosfarm_members_settings.certification_gender_field){
						jQuery('input[name="'+cosmosfarm_members_settings.certification_gender_field+'"]').val(res.gender=='male'?cosmosfarm_members_localize_strings.male:cosmosfarm_members_localize_strings.female);
					}
					if(cosmosfarm_members_settings.certification_birth_field){
						jQuery('input[name="'+cosmosfarm_members_settings.certification_birth_field+'"]').val(res.birth);
					}
					if(cosmosfarm_members_settings.certified_phone && cosmosfarm_members_settings.certification_carrier_field){
						jQuery('input[name="'+cosmosfarm_members_settings.certification_carrier_field+'"]').val(res.carrier);
					}
					if(cosmosfarm_members_settings.certified_phone && cosmosfarm_members_settings.certification_phone_field){
						jQuery('input[name="'+cosmosfarm_members_settings.certification_phone_field+'"]').val(res.phone);
					}
					alert(cosmosfarm_members_localize_strings.certificate_completed);
				}
			});
		}
		else{
			alert(rsp.error_msg);
		}
	});
}

function cosmosfarm_members_exists_check(input_name){
	if(input_name == 'username') input_name = 'user_login';
	if(jQuery("[name='"+input_name+"']").length > 0){
		if(!jQuery("[name='"+input_name+"']").val()){
			alert(cosmosfarm_members_localize_strings.please_fill_out_this_field);
			jQuery("[name='"+input_name+"']").focus();
		}
		else{
			jQuery.post(cosmosfarm_members_settings.home_url + '?action=cosmosfarm_members_exists_check', {mata_key:input_name, mata_value:jQuery("[name='"+input_name+"']").val(), security:cosmosfarm_members_settings.ajax_nonce}, function(res){
				if(res.exists){
					alert(cosmosfarm_members_localize_strings.not_available);
				}
				else{
					alert(cosmosfarm_members_localize_strings.available);
				}
			});
		}
	}
}

jQuery(document).ready(function(){
	jQuery('#billing_address_1').attr('readonly', true);
	jQuery('#billing_address_1').click(function(){
		cosmosfarm_members_open_postcode();
	});
	jQuery('#billing_postcode').attr('readonly', true);
	jQuery('#billing_postcode').click(function(){
		cosmosfarm_members_open_postcode();
	});
	
	if(typeof jQuery.datepicker == 'object'){
		jQuery('input[name="birthday"]').datepicker({
				closeText : '닫기',
				prevText : '이전달',
				nextText : '다음달',
				currentText : '오늘',
				monthNames : [ '1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월' ],
				monthNamesShort : [ '1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월' ],
				dayNames : [ '일', '월', '화', '수', '목', '금', '토' ],
				dayNamesShort : [ '일', '월', '화', '수', '목', '금', '토' ],
				dayNamesMin : [ '일', '월', '화', '수', '목', '금', '토' ],
				weekHeader : 'Wk',
				dateFormat : 'yy-mm-dd',
				firstDay : 0,
				isRTL : false,
				duration : 200,
				showAnim : 'fadeIn',
				showMonthAfterYear : true,
				yearSuffix : '년'
		});
	}
	
	jQuery('.cosmosfarm-members-form.signup-form form').submit(function(){
		if(cosmosfarm_members_settings.use_strong_password){
			var strength = cosmosfarm_members_check_password_strength();
			switch(strength){
				case 'mismatch':
					alert(cosmosfarm_members_localize_strings.your_password_is_different);
					break;
				case 'short':
					alert(cosmosfarm_members_localize_strings.password_must_consist_of_8_digits);
					break;
				case 'space':
					alert(cosmosfarm_members_localize_strings.please_enter_your_password_without_spaces);
					break;
				case 'bad':
					alert(cosmosfarm_members_localize_strings.password_must_consist_of_8_digits);
					break;
				default:
					//alert('안전한 비밀번호입니다.');
			}
			if(strength != 'good'){
				return false;
			}
		}
		return true;
	});
});