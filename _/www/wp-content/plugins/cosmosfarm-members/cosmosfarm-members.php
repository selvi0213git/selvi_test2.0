<?php
/*
Plugin Name: 코스모스팜 회원관리
Plugin URI: http://www.cosmosfarm.com/wpstore/product/cosmosfarm-members
Description: 한국형 회원가입 레이아웃과 기능을 제공합니다.
Version: 1.8.1
Author: 코스모스팜 - Cosmosfarm
Author URI: http://www.cosmosfarm.com/
*/

if(!defined('ABSPATH')) exit;
if(!session_id()) session_start();

define('COSMOSFARM_MEMBERS_VERSION', '1.8.1');
define('COSMOSFARM_MEMBERS_DIR_PATH', dirname(__FILE__));
define('COSMOSFARM_MEMBERS_URL', plugins_url('', __FILE__));
define('COSMOSFARM_MEMBERS_CERTIFIED_PHONE', false);

include_once 'class/Cosmosfarm_Members_Controller.class.php';
include_once 'class/Cosmosfarm_Members_Mail.class.php';
include_once 'class/Cosmosfarm_Members_Mycred.class.php';
include_once 'class/Cosmosfarm_Members_Option.class.php';
include_once 'class/Cosmosfarm_Members_Page_Builder.class.php';
include_once 'class/Cosmosfarm_Members_Security.class.php';
include_once 'class/Cosmosfarm_Members_Skin.class.php';
include_once 'class/Cosmosfarm_Members.class.php';

add_action('plugins_loaded', 'cosmosfarm_members_plugins_loaded');
function cosmosfarm_members_plugins_loaded(){
	global $cosmosfarm_members_option, $sosmosfarm_members_security;
	$cosmosfarm_members_option = get_cosmosfarm_members_option();
	$sosmosfarm_members_security = new Cosmosfarm_Members_Security();
}

add_action('init', 'cosmosfarm_members_init');
function cosmosfarm_members_init(){
	global $cosmosfarm_members, $cosmosfarm_members_skin, $cosmosfarm_members_option, $cosmosfarm_members_page_builder;
	
	if(defined('WPMEM_VERSION')){
		$cosmosfarm_members = new Cosmosfarm_Members();
		$cosmosfarm_members_skin = new Cosmosfarm_Members_Skin();
		$cosmosfarm_members_option = get_cosmosfarm_members_option();
		$cosmosfarm_members_page_builder = new Cosmosfarm_Members_Page_Builder();
		$cosmosfarm_members_controller = new Cosmosfarm_Members_Controller();
		
		add_action('admin_menu', array($cosmosfarm_members, 'add_admin_menu'));
	}
}

add_action('admin_init', 'cosmosfarm_members_admin_init');
function cosmosfarm_members_admin_init(){
	include_once 'class/Cosmosfarm_Members_Meta_Box.class.php';
	$cosmosfarm_members_meta_box = new Cosmosfarm_Members_Meta_Box();
}

add_action('wp_enqueue_scripts', 'cosmosfarm_members_scripts', 999);
function cosmosfarm_members_scripts(){
	$cosmosfarm_members_option = get_cosmosfarm_members_option();
	
	//wp_enqueue_script("cosmosfarm-members", COSMOSFARM_MEMBERS_URL . "/assets/js/script.js", array(), COSMOSFARM_MEMBERS_VERSION, true);
	wp_enqueue_script("cosmosfarm-members-{$cosmosfarm_members_option->skin}", COSMOSFARM_MEMBERS_URL . "/skin/{$cosmosfarm_members_option->skin}/script.js", array('jquery'), COSMOSFARM_MEMBERS_VERSION, true);
	wp_enqueue_style("cosmosfarm-members-{$cosmosfarm_members_option->skin}", COSMOSFARM_MEMBERS_URL . "/skin/{$cosmosfarm_members_option->skin}/style.css", array(), COSMOSFARM_MEMBERS_VERSION);
	
	// 스크립트 등록
	wp_register_script('daum-postcode', 'https://spi.maps.daum.net/imap/map_js_init/postcode.v2.js', array(), '2.0', true);
	wp_register_script('iamport-payment', 'https://service.iamport.kr/js/iamport.payment-1.1.5.js', array('jquery'), '1.1.5');
	
	// 설정 등록
	$localize = array(
			'ajax_nonce' => wp_create_nonce('cosmosfarm-members-check-ajax-referer'),
			'home_url' => home_url(),
			'site_url' => site_url(),
			'use_strong_password' => $cosmosfarm_members_option->use_strong_password,
			'use_certification' => $cosmosfarm_members_option->use_certification,
			'certified_phone' => COSMOSFARM_MEMBERS_CERTIFIED_PHONE,
			'certification_min_age' => $cosmosfarm_members_option->certification_min_age,
			'certification_name_field' => $cosmosfarm_members_option->certification_name_field,
			'certification_gender_field' => $cosmosfarm_members_option->certification_gender_field,
			'certification_birth_field' => $cosmosfarm_members_option->certification_birth_field,
			'certification_carrier_field' => $cosmosfarm_members_option->certification_carrier_field,
			'certification_phone_field' => $cosmosfarm_members_option->certification_phone_field,
	);
	wp_localize_script("cosmosfarm-members-{$cosmosfarm_members_option->skin}", 'cosmosfarm_members_settings', $localize);
	
	// 번역 등록
	$localize = array(
			'please_enter_the_postcode' => __('Please enter the postcode.', 'cosmosfarm-members'),
			'please_wait' => __('Please wait.', 'cosmosfarm-members'),
			'yes' => __('Yes', 'cosmosfarm-members'),
			'no' => __('No', 'cosmosfarm-members'),
			'password_must_consist_of_8_digits' => __('Password must consist of 8 digits, including English, numbers and special characters.', 'cosmosfarm-members'),
			'your_password_is_different' => __('Your password is different.', 'cosmosfarm-members'),
			'please_enter_your_password_without_spaces' => __('Please enter your password without spaces.', 'cosmosfarm-members'),
			'it_is_a_safe_password' => __('It is a safe password.', 'cosmosfarm-members'),
			'male' => __('Male', 'cosmosfarm-members'),
			'female' => __('Female', 'cosmosfarm-members'),
			'female' => __('Female', 'cosmosfarm-members'),
			'certificate_completed' => __('Certificate Completed', 'cosmosfarm-members'),
			'please_fill_out_this_field' => __('Please fill out this field.', 'cosmosfarm-members'),
			'available' => __('Available', 'cosmosfarm-members'),
			'not_available' => __('Not available', 'cosmosfarm-members'),
	);
	wp_localize_script("cosmosfarm-members-{$cosmosfarm_members_option->skin}", 'cosmosfarm_members_localize_strings', $localize);
}

add_action('admin_enqueue_scripts', 'cosmosfarm_members_admin_scripts', 999);
function cosmosfarm_members_admin_scripts(){
	wp_enqueue_style('cosmosfarm-members-admin', COSMOSFARM_MEMBERS_URL . '/admin/admin.css', array(), COSMOSFARM_MEMBERS_VERSION);
}

add_action('admin_notices', 'cosmosfarm_members_admin_notices');
function cosmosfarm_members_admin_notices(){
	if(!defined('WPMEM_VERSION')){
		$class = 'notice notice-error';
		$message = '코스모스팜 회원관리 사용을 위해서는 먼저 <a href="https://ko.wordpress.org/plugins/wp-members/" onclick="window.open(this.href);return false;">WP-Members</a> 플러그인을 설치해주세요.';
		printf('<div class="%1$s"><p>%2$s</p></div>', $class, $message);
	}
}

function cosmosfarm_members_menu_item($args){
	$item = new stdClass();
	$item->ID = 10000000 + (isset($args['order']) ? $args['order'] : 0);
	$item->db_id = $item->ID;
	$item->title = isset($args['title']) ? $args['title'] : '';
	$item->url = isset($args['url']) ? $args['url'] : '';
	$item->menu_order = $item->ID;
	$item->menu_item_parent = 0;
	$item->post_parent = 0;
	$item->type = 'custom';
	$item->object = 'custom';
	$item->object_id = '';
	$item->classes = isset($args['classes']) ? $args['classes'] : array();
	$item->target = '';
	$item->attr_title = '';
	$item->description = '';
	$item->xfn = '';
	$item->status = '';
	return $item;
}

function get_cosmosfarm_menu_add_login(){
	$menu_add_login = get_option('cosmosfarm_menu_add_login', '');
	return stripslashes($menu_add_login);
}

function get_cosmosfarm_login_menus(){
	$login_menus = get_option('cosmosfarm_login_menus', array());
	return $login_menus;
}

function get_cosmosfarm_policy_service_content(){
	$policy_service = get_option('cosmosfarm_members_policy_service', '');
	return stripslashes($policy_service);
}

function get_cosmosfarm_policy_privacy_content(){
	$policy_privacy = get_option('cosmosfarm_members_policy_privacy', '');
	return stripslashes($policy_privacy);
}

function get_cosmosfarm_members_option(){
	global $cosmosfarm_members_option;
	if($cosmosfarm_members_option === null){
		$cosmosfarm_members_option = new Cosmosfarm_Members_Option();
	}
	return $cosmosfarm_members_option;
}

function get_cosmosfarm_members_profile_url(){
	global $cosmosfarm_members_option;

	$profile_url = '';
	if($cosmosfarm_members_option->account_page_id || $cosmosfarm_members_option->account_page_url){
		if($cosmosfarm_members_option->account_page_id){
			$profile_url = get_permalink($cosmosfarm_members_option->account_page_id);
		}
		else if($cosmosfarm_members_option->account_page_url){
			$profile_url = $cosmosfarm_members_option->account_page_url;
		}
	}
	else if(wpmem_profile_url()){
		$profile_url = wpmem_profile_url();
	}
	return esc_url_raw($profile_url);
}

function get_cosmosfarm_members_file_handler(){
	if(!class_exists('Cosmosfarm_Members_File_Handler')){
		include_once COSMOSFARM_MEMBERS_DIR_PATH . '/class/Cosmosfarm_Members_File_Handler.class.php';
	}
	return new Cosmosfarm_Members_File_Handler();
}

function cosmosfarm_members_send_verify_email($user, $verify_code=''){
	if($user->ID && $user->user_email){
		
		if(!$verify_code) $verify_code = md5(uniqid());
		$option = get_cosmosfarm_members_option();
		
		if($option->verify_email_title && $option->verify_email_content){
			
			$blogname = get_option('blogname');
			$home_url = home_url();
			$verify_email_url = home_url('?action=cosmosfarm_members_verify_email_confirm&verify_code='.$verify_code);
			
			$subject = str_replace('[blogname]', $blogname, $option->verify_email_title);
			$subject = str_replace('[home_url]', sprintf('<a href="%s" target="_blank">%s</a>', $home_url, $home_url), $subject);
			$subject = str_replace('[verify_email_url]', sprintf('<a href="%s" target="_blank">%s</a>', $verify_email_url, $verify_email_url), $subject);
			
			$message = str_replace('[blogname]', $blogname, $option->verify_email_content);
			$message = str_replace('[home_url]', sprintf('<a href="%s" target="_blank">%s</a>', $home_url, $home_url), $message);
			$message = str_replace('[verify_email_url]', sprintf('<a href="%s" target="_blank">%s</a>', $verify_email_url, $verify_email_url), $message);
			
			if($option->allow_email_login){
				$subject = str_replace('[id_or_email]', $user->user_email, $subject);
				$message = str_replace('[id_or_email]', $user->user_email, $message);
			}
			else{
				$subject = str_replace('[id_or_email]', $user->display_name, $subject);
				$message = str_replace('[id_or_email]', $user->display_name, $message);
			}
			
			$mail = new Cosmosfarm_Members_Mail();
			$mail->send(array(
					'to' => $user->user_email,
					'subject' => $subject,
					'message' => $message,
			));
		}
	}
	return $verify_code;
}

function cosmosfarm_members_send_confirmed_email($user){
	if($user->ID && $user->user_email){
		$option = get_cosmosfarm_members_option();
		
		if($option->confirmed_email_title && $option->confirmed_email_content){
			
			$blogname = get_option('blogname');
			$home_url = home_url();
			
			$subject = str_replace('[blogname]', $blogname, $option->confirmed_email_title);
			$subject = str_replace('[home_url]', sprintf('<a href="%s" target="_blank">%s</a>', $home_url, $home_url), $subject);
			
			$message = str_replace('[blogname]', $blogname, $option->confirmed_email_content);
			$message = str_replace('[home_url]', sprintf('<a href="%s" target="_blank">%s</a>', $home_url, $home_url), $message);
			
			if($option->allow_email_login){
				$subject = str_replace('[id_or_email]', $user->user_email, $subject);
				$message = str_replace('[id_or_email]', $user->user_email, $message);
			}
			else{
				$subject = str_replace('[id_or_email]', $user->display_name, $subject);
				$message = str_replace('[id_or_email]', $user->display_name, $message);
			}
			
			$mail = new Cosmosfarm_Members_Mail();
			$mail->send(array(
					'to' => $user->user_email,
					'subject' => $subject,
					'message' => $message,
			));
		}
	}
}

function cosmosfarm_members_skins(){
	$dir = COSMOSFARM_MEMBERS_DIR_PATH . '/skin';
	if($dh = opendir($dir)){
		while(($name = readdir($dh)) !== false){
			if($name == "." || $name == ".." || $name == "readme.txt") continue;
			$skin = new stdClass();
			$skin->name = $name;
			$skin->dir = COSMOSFARM_MEMBERS_DIR_PATH . "/skin/{$name}";
			$skin->url = COSMOSFARM_MEMBERS_URL . "/skin/{$name}";
			$ist[$name] = $skin;
		}
	}
	closedir($dh);
	return apply_filters('cosmosfarm_members_skin_list', $ist);
}

function cosmosfarm_members_user_value_exists($meta_key, $meta_value){
	global $wpdb;
	
	if(in_array($meta_key, array('username', 'user_login', 'user_nicename', 'user_email', 'user_url', 'display_name'))){
		if($meta_key == 'username') $meta_key = 'user_login';
		$meta_value = esc_sql($meta_value);
		$count = $wpdb->get_var("SELECT COUNT(*) FROM `$wpdb->users` WHERE `$meta_key`='$meta_value'");
		if($count) return true;
	}
	else{
		$meta_key = esc_sql($meta_key);
		$meta_value = esc_sql($meta_value);
		$count = $wpdb->get_var("SELECT COUNT(*) FROM `$wpdb->usermeta` WHERE `$meta_key`='$meta_value'");
		if($count) return true;
	}
	return false;
}

add_shortcode('cosmosfarm_members_social_buttons', 'cosmosfarm_members_social_buttons');
function cosmosfarm_members_social_buttons($args=array()){
	global $cosmosfarm_members;
	
	$option = get_cosmosfarm_members_option();
	
	if((!is_user_logged_in() || $option->social_buttons_shortcode_display != '1') && $option->social_login_active){
		
		$redirect_to = isset($args['redirect_to']) && $args['redirect_to'] ? $args['redirect_to'] : $_SERVER['REQUEST_URI'];
		$skin = isset($args['skin']) && $args['skin'] ? $args['skin'] : '';
		$file = isset($args['file']) && $args['file'] ? $args['file'] : '';
		
		return $cosmosfarm_members->social_buttons('shortcode', $redirect_to, $skin, $file);
	}
	
	return '';
}

add_shortcode('cosmosfarm_members_account_links', 'cosmosfarm_members_account_links');
function cosmosfarm_members_account_links($args=array()){
	global $cosmosfarm_members_skin;
	return $cosmosfarm_members_skin->account_links();
}

add_filter('wpmem_settings', 'cosmosfarm_members_wpmem_settings', 10, 1);
function cosmosfarm_members_wpmem_settings($settings){
	$option = get_cosmosfarm_members_option();
	
	if($option->account_page_id){
		$settings['user_pages']['profile'] = $option->account_page_id;
	}
	
	if($option->register_page_id){
		$settings['user_pages']['register'] = $option->register_page_id;
	}
	
	if($option->login_page_id){
		$settings['user_pages']['login'] = $option->login_page_id;
	}
	
	return $settings;
}

add_action('mycred_init', 'cosmosfarm_members_mycred_init');
function cosmosfarm_members_mycred_init(){
	global $cosmosfarm_members_mycred;
	$cosmosfarm_members_mycred = new Cosmosfarm_Members_Mycred();
}

add_action('switch_blog', 'cosmosfarm_members_switch_blog');
function cosmosfarm_members_switch_blog(){
	global $cosmosfarm_members_option;
	$cosmosfarm_members_option = new Cosmosfarm_Members_Option();
}

add_action('init', 'cosmosfarm_members_languages');
function cosmosfarm_members_languages(){
	load_plugin_textdomain('cosmosfarm-members', false, dirname(plugin_basename(__FILE__)) . '/languages');
}

add_action('plugins_loaded', 'cosmosfarm_members_update_check');
function cosmosfarm_members_update_check(){
	global $wpdb;
	
	if(version_compare(COSMOSFARM_MEMBERS_VERSION, get_option('cosmosfarm_members_version'), '<=')) return;
	
	if(get_option('cosmosfarm_members_version') !== false){
		update_option('cosmosfarm_members_version', COSMOSFARM_MEMBERS_VERSION);
	}
	else{
		add_option('cosmosfarm_members_version', COSMOSFARM_MEMBERS_VERSION, null, 'yes');
	}
	
	cosmosfarm_members_activation_execute();
}

register_activation_hook(__FILE__, 'cosmosfarm_members_activation');
function cosmosfarm_members_activation($networkwide){
	global $wpdb;
	if(function_exists('is_multisite') && is_multisite()){
		if($networkwide){
			$old_blog = $wpdb->blogid;
			$blogids = $wpdb->get_col("SELECT `blog_id` FROM {$wpdb->blogs}");
			foreach($blogids as $blog_id){
				switch_to_blog($blog_id);
				cosmosfarm_members_activation_execute();
			}
			switch_to_blog($old_blog);
			return;
		}
	}
	cosmosfarm_members_activation_execute();
}

function cosmosfarm_members_activation_execute(){
	global $wpdb;
	
	require_once ABSPATH . 'wp-admin/includes/upgrade.php';
	$charset_collate = $wpdb->get_charset_collate();
	
	dbDelta("CREATE TABLE `{$wpdb->prefix}cosmosfarm_members_login_history` (
	`login_history_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
	`user_id` bigint(20) unsigned NOT NULL,
	`login_datetime` datetime NOT NULL,
	`ip_address` varchar(20) NOT NULL,
	`browser` varchar(127) NOT NULL,
	`operating_system` varchar(127) NOT NULL,
	`country_name` varchar(127) NOT NULL,
	`country_code` varchar(127) NOT NULL,
	`login_result` varchar(20) NOT NULL,
	`user_agent` TEXT NOT NULL,
	PRIMARY KEY (`login_history_id`),
	KEY `user_id` (`user_id`)
	) {$charset_collate};");
	
	dbDelta("CREATE TABLE `{$wpdb->prefix}cosmosfarm_members_activity_history` (
	`activity_history_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
	`user_id` bigint(20) unsigned NOT NULL,
	`related_user_id` bigint(20) unsigned NOT NULL,
	`activity_datetime` datetime NOT NULL,
	`ip_address` varchar(20) NOT NULL,
	`comment` varchar(127) NOT NULL,
	PRIMARY KEY (`activity_history_id`),
	KEY `user_id` (`user_id`),
	KEY `related_user_id` (`related_user_id`)
	) {$charset_collate};");
}

register_uninstall_hook(__FILE__, 'cosmosfarm_members_uninstall');
function cosmosfarm_members_uninstall(){
	global $wpdb;
	if(function_exists('is_multisite') && is_multisite()){
		$old_blog = $wpdb->blogid;
		$blogids = $wpdb->get_col("SELECT `blog_id` FROM {$wpdb->blogs}");
		foreach($blogids as $blog_id){
			switch_to_blog($blog_id);
			cosmosfarm_members_uninstall_execute();
		}
		switch_to_blog($old_blog);
		return;
	}
	cosmosfarm_members_uninstall_execute();
}

function cosmosfarm_members_uninstall_execute(){
	$option = get_cosmosfarm_members_option();
	$option->truncate();
}