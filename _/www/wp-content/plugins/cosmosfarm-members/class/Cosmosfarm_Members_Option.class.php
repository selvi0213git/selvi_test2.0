<?php
/**
 * Cosmosfarm_Members_Option
 * @link http://www.cosmosfarm.com/
 * @copyright Copyright 2017 Cosmosfarm. All rights reserved.
 */
class Cosmosfarm_Members_Option {

	var $skin;
	var $channel;
	var $social_login_active;
	var $allow_email_login;
	var $login_redirect_page;
	var $login_redirect_url;
	var $naver_client_id;
	var $naver_client_secret;
	var $facebook_client_id;
	var $facebook_client_secret;
	var $kakao_client_id;
	var $google_client_id;
	var $google_client_secret;
	var $twitter_client_id;
	var $twitter_client_secret;
	var $instagram_client_id;
	var $instagram_client_secret;
	var $line_client_id;
	var $line_client_secret;
	var $login_page_id;
	var $login_page_url;
	var $register_page_id;
	var $register_page_url;
	var $account_page_id;
	var $account_page_url;
	var $user_required;
	var $verify_email;
	var $verify_email_title;
	var $verify_email_content;
	var $confirmed_email;
	var $confirmed_email_title;
	var $confirmed_email_content;
	var $page_restriction_redirect;
	var $social_buttons_shortcode_display;
	var $change_role_active;
	var $change_role_thresholds;
	var $use_delete_account;
	
	var $use_strong_password;
	var $save_login_history;
	var $use_login_protect;
	var $login_protect_time;
	var $login_protect_count;
	var $login_protect_lockdown;
	var $use_login_timeout;
	var $login_timeout;
	var $save_activity_history;
	
	var $iamport_id;
	var $iamport_api_key;
	var $iamport_api_secret;
	var $use_certification;
	var $certification_min_age;
	var $certification_name_field;
	var $certification_gender_field;
	var $certification_birth_field;
	var $certification_carrier_field;
	var $certification_phone_field;
	
	var $exists_check;
	
	public function __construct(){
		$this->channel = array(
				'naver' => __('Naver', 'cosmosfarm-members'),
				'facebook' => __('Facebook', 'cosmosfarm-members'),
				'kakao' => __('Kakao', 'cosmosfarm-members'),
				'google' => __('Google+', 'cosmosfarm-members'),
				'twitter' => __('Twitter', 'cosmosfarm-members'),
				'instagram' => __('Instagram', 'cosmosfarm-members'),
				'line' => __('Line', 'cosmosfarm-members'),
		);
		$this->init();
	}

	public function init(){
		$this->skin = get_option('cosmosfarm_members_skin', 'default');
		$this->social_login_active = get_option('cosmosfarm_members_social_login_active', array());
		$this->allow_email_login = get_option('cosmosfarm_members_allow_email_login', '');
		$this->login_redirect_page = get_option('cosmosfarm_members_login_redirect_page', '');
		$this->login_redirect_url = get_option('cosmosfarm_members_login_redirect_url', '');
		$this->naver_client_id = get_option('cosmosfarm_members_naver_client_id', '');
		$this->naver_client_secret = get_option('cosmosfarm_members_naver_client_secret', '');
		$this->facebook_client_id = get_option('cosmosfarm_members_facebook_client_id', '');
		$this->facebook_client_secret = get_option('cosmosfarm_members_facebook_client_secret', '');
		$this->kakao_client_id = get_option('cosmosfarm_members_kakao_client_id', '');
		$this->google_client_id = get_option('cosmosfarm_members_google_client_id', '');
		$this->google_client_secret = get_option('cosmosfarm_members_google_client_secret', '');
		$this->twitter_client_id = get_option('cosmosfarm_members_twitter_client_id', '');
		$this->twitter_client_secret = get_option('cosmosfarm_members_twitter_client_secret', '');
		$this->instagram_client_id = get_option('cosmosfarm_members_instagram_client_id', '');
		$this->instagram_client_secret = get_option('cosmosfarm_members_instagram_client_secret', '');
		$this->line_client_id = get_option('cosmosfarm_members_line_client_id', '');
		$this->line_client_secret = get_option('cosmosfarm_members_line_client_secret', '');
		$this->login_page_id = get_option('cosmosfarm_members_login_page_id', '');
		$this->login_page_url = get_option('cosmosfarm_members_login_page_url', '');
		$this->register_page_id = get_option('cosmosfarm_members_register_page_id', '');
		$this->register_page_url = get_option('cosmosfarm_members_register_page_url', '');
		$this->account_page_id = get_option('cosmosfarm_members_account_page_id', '');
		$this->account_page_url = get_option('cosmosfarm_members_account_page_url', '');
		$this->user_required = get_option('cosmosfarm_members_user_required', '');
		$this->verify_email = get_option('cosmosfarm_members_verify_email', '');
		$this->verify_email_title = stripslashes(get_option('cosmosfarm_members_verify_email_title', ''));
		$this->verify_email_content = stripslashes(get_option('cosmosfarm_members_verify_email_content', ''));
		$this->confirmed_email = get_option('cosmosfarm_members_confirmed_email', '');
		$this->confirmed_email_title = stripslashes(get_option('cosmosfarm_members_confirmed_email_title', ''));
		$this->confirmed_email_content = stripslashes(get_option('cosmosfarm_members_confirmed_email_content', ''));
		$this->page_restriction_redirect = get_option('cosmosfarm_members_page_restriction_redirect', '');
		$this->social_buttons_shortcode_display = get_option('cosmosfarm_members_social_buttons_shortcode_display', '');
		$this->change_role_active = get_option('cosmosfarm_members_change_role_active', '');
		$this->change_role_thresholds = get_option('cosmosfarm_members_change_role_thresholds', '');
		if(!$this->change_role_thresholds) $this->change_role_thresholds = array();
		$this->use_delete_account = get_option('cosmosfarm_members_use_delete_account', '');
		
		$this->use_strong_password = get_option('cosmosfarm_members_use_strong_password', '');
		$this->save_login_history = get_option('cosmosfarm_members_save_login_history', '');
		$this->use_login_protect = get_option('cosmosfarm_members_use_login_protect', '');
		$this->login_protect_time = get_option('cosmosfarm_members_login_protect_time', '');
		$this->login_protect_count = get_option('cosmosfarm_members_login_protect_count', '');
		$this->login_protect_lockdown = get_option('cosmosfarm_members_login_protect_lockdown', '');
		$this->use_login_timeout = get_option('cosmosfarm_members_use_login_timeout', '');
		$this->login_timeout = get_option('cosmosfarm_members_login_timeout', '');
		$this->save_activity_history = get_option('cosmosfarm_members_save_activity_history', '');
		
		$this->iamport_id = get_option('cosmosfarm_members_iamport_id', '');
		$this->iamport_api_key = get_option('cosmosfarm_members_iamport_api_key', '');
		$this->iamport_api_secret = get_option('cosmosfarm_members_iamport_api_secret', '');
		$this->use_certification = get_option('cosmosfarm_members_use_certification', '');
		$this->certification_min_age = get_option('cosmosfarm_members_certification_min_age', '');
		$this->certification_name_field = get_option('cosmosfarm_members_certification_name_field', '');
		$this->certification_gender_field = get_option('cosmosfarm_members_certification_gender_field', '');
		$this->certification_birth_field = get_option('cosmosfarm_members_certification_birth_field', '');
		$this->certification_carrier_field = get_option('cosmosfarm_members_certification_carrier_field', '');
		$this->certification_phone_field = get_option('cosmosfarm_members_certification_phone_field', '');
		
		$this->exists_check = get_option('cosmosfarm_members_exists_check', array());
	}

	public function save(){
		$this->update('cosmosfarm_members_skin');
		$this->update('cosmosfarm_members_social_login_active');
		$this->update('cosmosfarm_members_allow_email_login');
		$this->update('cosmosfarm_members_login_redirect_page');
		$this->update('cosmosfarm_members_login_redirect_url');
		$this->update('cosmosfarm_members_naver_client_id');
		$this->update('cosmosfarm_members_naver_client_secret');
		$this->update('cosmosfarm_members_facebook_client_id');
		$this->update('cosmosfarm_members_facebook_client_secret');
		$this->update('cosmosfarm_members_kakao_client_id');
		$this->update('cosmosfarm_members_google_client_id');
		$this->update('cosmosfarm_members_google_client_secret');
		$this->update('cosmosfarm_members_twitter_client_id');
		$this->update('cosmosfarm_members_twitter_client_secret');
		$this->update('cosmosfarm_members_instagram_client_id');
		$this->update('cosmosfarm_members_instagram_client_secret');
		$this->update('cosmosfarm_members_line_client_id');
		$this->update('cosmosfarm_members_line_client_secret');
		$this->update('cosmosfarm_members_login_page_id');
		$this->update('cosmosfarm_members_login_page_url');
		$this->update('cosmosfarm_members_register_page_id');
		$this->update('cosmosfarm_members_register_page_url');
		$this->update('cosmosfarm_members_account_page_id');
		$this->update('cosmosfarm_members_account_page_url');
		$this->update('cosmosfarm_members_user_required');
		$this->update('cosmosfarm_members_verify_email');
		$this->update('cosmosfarm_members_verify_email_title');
		$this->update('cosmosfarm_members_verify_email_content');
		$this->update('cosmosfarm_members_confirmed_email');
		$this->update('cosmosfarm_members_confirmed_email_title');
		$this->update('cosmosfarm_members_confirmed_email_content');
		$this->update('cosmosfarm_members_page_restriction_redirect');
		$this->update('cosmosfarm_members_social_buttons_shortcode_display');
		$this->update('cosmosfarm_members_change_role_active');
		$this->update('cosmosfarm_members_change_role_thresholds');
		$this->update('cosmosfarm_members_use_delete_account');
		
		$this->update('cosmosfarm_members_use_strong_password');
		$this->update('cosmosfarm_members_save_login_history');
		$this->update('cosmosfarm_members_use_login_protect');
		$this->update('cosmosfarm_members_login_protect_time');
		$this->update('cosmosfarm_members_login_protect_count');
		$this->update('cosmosfarm_members_login_protect_lockdown');
		$this->update('cosmosfarm_members_use_login_timeout');
		$this->update('cosmosfarm_members_login_timeout');
		$this->update('cosmosfarm_members_save_activity_history');
		
		$this->update('cosmosfarm_members_iamport_id');
		$this->update('cosmosfarm_members_iamport_api_key');
		$this->update('cosmosfarm_members_iamport_api_secret');
		$this->update('cosmosfarm_members_use_certification');
		$this->update('cosmosfarm_members_certification_min_age');
		$this->update('cosmosfarm_members_certification_name_field');
		$this->update('cosmosfarm_members_certification_gender_field');
		$this->update('cosmosfarm_members_certification_birth_field');
		$this->update('cosmosfarm_members_certification_carrier_field');
		$this->update('cosmosfarm_members_certification_phone_field');
		
		$this->update('cosmosfarm_members_exists_check');
	}

	public function update($option_name){
		if(isset($_POST[$option_name])){
			if(is_string($_POST[$option_name])){
				$new_value = trim($_POST[$option_name]);
			}
			else{
				$new_value = $_POST[$option_name];
			}
			if(get_option($option_name) !== false){
				update_option($option_name, $new_value, 'yes');
			}
			else add_option($option_name, $new_value, '', 'yes');
		}
	}
	
	public function truncate(){
		delete_option('cosmosfarm_members_policy_service');
		delete_option('cosmosfarm_members_policy_privacy');
		delete_option('cosmosfarm_members_skin');
		delete_option('cosmosfarm_members_social_login_active');
		delete_option('cosmosfarm_members_allow_email_login');
		delete_option('cosmosfarm_members_login_redirect_page');
		delete_option('cosmosfarm_members_login_redirect_url');
		delete_option('cosmosfarm_members_naver_client_id');
		delete_option('cosmosfarm_members_naver_client_secret');
		delete_option('cosmosfarm_members_facebook_client_id');
		delete_option('cosmosfarm_members_facebook_client_secret');
		delete_option('cosmosfarm_members_kakao_client_id');
		delete_option('cosmosfarm_members_google_client_id');
		delete_option('cosmosfarm_members_google_client_secret');
		delete_option('cosmosfarm_members_twitter_client_id');
		delete_option('cosmosfarm_members_twitter_client_secret');
		delete_option('cosmosfarm_members_instagram_client_id');
		delete_option('cosmosfarm_members_instagram_client_secret');
		delete_option('cosmosfarm_members_line_client_id');
		delete_option('cosmosfarm_members_line_client_secret');
		delete_option('cosmosfarm_members_login_page_id');
		delete_option('cosmosfarm_members_login_page_url');
		delete_option('cosmosfarm_members_register_page_id');
		delete_option('cosmosfarm_members_register_page_url');
		delete_option('cosmosfarm_members_account_page_id');
		delete_option('cosmosfarm_members_account_page_url');
		delete_option('cosmosfarm_members_user_required');
		delete_option('cosmosfarm_members_verify_email');
		delete_option('cosmosfarm_members_verify_email_title');
		delete_option('cosmosfarm_members_verify_email_content');
		delete_option('cosmosfarm_members_confirmed_email');
		delete_option('cosmosfarm_members_confirmed_email_title');
		delete_option('cosmosfarm_members_confirmed_email_content');
		delete_option('cosmosfarm_members_page_restriction_redirect');
		delete_option('cosmosfarm_members_social_buttons_shortcode_display');
		delete_option('cosmosfarm_members_change_role_active');
		delete_option('cosmosfarm_members_change_role_thresholds');
		delete_option('cosmosfarm_members_use_delete_account');
		
		delete_option('cosmosfarm_members_use_strong_password');
		delete_option('cosmosfarm_members_save_login_history');
		delete_option('cosmosfarm_members_use_login_protect');
		delete_option('cosmosfarm_members_login_protect_time');
		delete_option('cosmosfarm_members_login_protect_count');
		delete_option('cosmosfarm_members_login_protect_lockdown');
		delete_option('cosmosfarm_members_use_login_timeout');
		delete_option('cosmosfarm_members_login_timeout');
		delete_option('cosmosfarm_members_save_activity_history');
		
		delete_option('cosmosfarm_members_iamport_id');
		delete_option('cosmosfarm_members_iamport_api_key');
		delete_option('cosmosfarm_members_iamport_api_secret');
		delete_option('cosmosfarm_members_use_certification');
		delete_option('cosmosfarm_members_certification_min_age');
		delete_option('cosmosfarm_members_certification_name_field');
		delete_option('cosmosfarm_members_certification_gender_field');
		delete_option('cosmosfarm_members_certification_birth_field');
		delete_option('cosmosfarm_members_certification_carrier_field');
		delete_option('cosmosfarm_members_certification_phone_field');
		
		delete_option('cosmosfarm_members_exists_check');
	}
}
?>