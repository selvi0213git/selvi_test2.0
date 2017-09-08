<?php
/**
 * Cosmosfarm_Members_Controller
 * @link http://www.cosmosfarm.com/
 * @copyright Copyright 2017 Cosmosfarm. All rights reserved.
 */
final class Cosmosfarm_Members_Controller {

	public function __construct(){
		add_action('admin_post_cosmosfarm_members_setting_save', array($this, 'setting_save'));
		add_action('admin_post_cosmosfarm_members_service_save', array($this, 'policy_service_save'));
		add_action('admin_post_cosmosfarm_members_privacy_save', array($this, 'policy_privacy_save'));
		add_action('admin_post_cosmosfarm_members_certification_save', array($this, 'certification_save'));
		add_action('admin_post_cosmosfarm_members_verify_email_save', array($this, 'verify_email_save'));
		add_action('admin_post_cosmosfarm_members_change_role_save', array($this, 'change_role_save'));
		add_action('admin_post_cosmosfarm_members_security_save', array($this, 'security_save'));
		add_action('admin_post_cosmosfarm_members_exists_check_save', array($this, 'exists_check_save'));
		
		$action = isset($_REQUEST['action'])?$_REQUEST['action']:'';
		switch($action){
			case 'cosmosfarm_members_social_login': $this->social_login(); break;
			case 'cosmosfarm_members_social_login_callback_naver': $this->social_login_callback('naver'); break;
			case 'cosmosfarm_members_social_login_callback_facebook': $this->social_login_callback('facebook'); break;
			case 'cosmosfarm_members_social_login_callback_kakao': $this->social_login_callback('kakao'); break;
			case 'cosmosfarm_members_social_login_callback_google': $this->social_login_callback('google'); break;
			case 'cosmosfarm_members_social_login_callback_twitter': $this->social_login_callback('twitter'); break;
			case 'cosmosfarm_members_social_login_callback_instagram': $this->social_login_callback('instagram'); break;
			case 'cosmosfarm_members_verify_email_confirm': $this->verify_email_confirm(); break;
			case 'cosmosfarm_members_delete_account': $this->delete_account(); break;
			case 'cosmosfarm_members_login_timeout': $this->login_timeout(); break;
			case 'cosmosfarm_members_certification_confirm': $this->certification_confirm(); break;
			case 'cosmosfarm_members_exists_check': $this->exists_check(); break;
		}
		
		$code = isset($_GET['code'])?$_GET['code']:'';
		$state = isset($_GET['state'])?$_GET['state']:'';
		if(!$action && $code && $state){
			$this->social_login_callback('line');
		}
	}

	public function setting_save(){
		if(current_user_can('activate_plugins') && isset($_POST['cosmosfarm-members-setting-save-nonce']) && wp_verify_nonce($_POST['cosmosfarm-members-setting-save-nonce'], 'cosmosfarm-members-setting-save')){

			$option_name = 'cosmosfarm_menu_add_login';
			$new_value = trim($_POST[$option_name]);
			if(!$new_value){
				delete_option($option_name);
			}
			else{
				if(get_option($option_name) !== false) update_option($option_name, $new_value, 'yes');
				else add_option($option_name, $new_value, '', 'yes');
			}

			$option_name = 'cosmosfarm_login_menus';
			$new_value = isset($_POST[$option_name])?$_POST[$option_name]:'';
			if(!$new_value){
				delete_option($option_name);
			}
			else{
				if(get_option($option_name) !== false) update_option($option_name, $new_value, 'yes');
				else add_option($option_name, $new_value, '', 'yes');
			}

			$option = new Cosmosfarm_Members_Option();
			$option->save();
			
			wp_redirect(wp_get_referer());
			exit;
		}
		else{
			wp_die(__('You will not be able to perform this task.', 'cosmosfarm-members'));
		}
	}
	
	public function policy_service_save(){
		if(current_user_can('activate_plugins') && isset($_POST['cosmosfarm-members-service-save-nonce']) && wp_verify_nonce($_POST['cosmosfarm-members-service-save-nonce'], 'cosmosfarm-members-service-save')){
			$option_name = 'cosmosfarm_members_policy_service';
			$new_value = trim($_POST[$option_name]);
			if(!$new_value){
				delete_option($option_name);
			}
			else{
				if(get_option($option_name) !== false) update_option($option_name, $new_value, 'no');
				else add_option($option_name, $new_value, '', 'no');
			}
			
			wp_redirect(wp_get_referer());
			exit;
		}
		else{
			wp_die(__('You will not be able to perform this task.', 'cosmosfarm-members'));
		}
	}
	
	public function policy_privacy_save(){
		if(current_user_can('activate_plugins') && isset($_POST['cosmosfarm-members-privacy-save-nonce']) && wp_verify_nonce($_POST['cosmosfarm-members-privacy-save-nonce'], 'cosmosfarm-members-privacy-save')){
			$option_name = 'cosmosfarm_members_policy_privacy';
			$new_value = trim($_POST[$option_name]);
			if(!$new_value){
				delete_option($option_name);
			}
			else{
				if(get_option($option_name) !== false) update_option($option_name, $new_value, 'no');
				else add_option($option_name, $new_value, '', 'no');
			}
			
			wp_redirect(wp_get_referer());
			exit;
		}
		else{
			wp_die(__('You will not be able to perform this task.', 'cosmosfarm-members'));
		}
	}
	
	public function certification_save(){
		if(current_user_can('activate_plugins') && isset($_POST['cosmosfarm-members-certification-save-nonce']) && wp_verify_nonce($_POST['cosmosfarm-members-certification-save-nonce'], 'cosmosfarm-members-certification-save')){
			$option = new Cosmosfarm_Members_Option();
			$option->save();
				
			wp_redirect(wp_get_referer());
			exit;
		}
		else{
			wp_die(__('You will not be able to perform this task.', 'cosmosfarm-members'));
		}
	}

	public function verify_email_save(){
		if(current_user_can('activate_plugins') && isset($_POST['cosmosfarm-members-verify-email-save-nonce']) && wp_verify_nonce($_POST['cosmosfarm-members-verify-email-save-nonce'], 'cosmosfarm-members-verify-email-save')){
			$option = new Cosmosfarm_Members_Option();
			$option->save();
			
			wp_redirect(wp_get_referer());
			exit;
		}
		else{
			wp_die(__('You will not be able to perform this task.', 'cosmosfarm-members'));
		}
	}
	
	public function change_role_save(){
		if(current_user_can('activate_plugins') && isset($_POST['cosmosfarm-members-change-role-save-nonce']) && wp_verify_nonce($_POST['cosmosfarm-members-change-role-save-nonce'], 'cosmosfarm-members-change-role-save')){
			$option = new Cosmosfarm_Members_Option();
			$option->save();
			
			wp_redirect(wp_get_referer());
			exit;
		}
		else{
			wp_die(__('You will not be able to perform this task.', 'cosmosfarm-members'));
		}
	}
	
	public function security_save(){
		if(current_user_can('activate_plugins') && isset($_POST['cosmosfarm-members-security-save-nonce']) && wp_verify_nonce($_POST['cosmosfarm-members-security-save-nonce'], 'cosmosfarm-members-security-save')){
			$option = new Cosmosfarm_Members_Option();
			$option->save();
			
			wp_redirect(wp_get_referer());
			exit;
		}
		else{
			wp_die(__('You will not be able to perform this task.', 'cosmosfarm-members'));
		}
	}
	
	public function exists_check_save(){
		if(current_user_can('activate_plugins') && isset($_POST['cosmosfarm-members-exists-check-save-nonce']) && wp_verify_nonce($_POST['cosmosfarm-members-exists-check-save-nonce'], 'cosmosfarm-members-exists-check-save')){
			
			if(!isset($_POST['cosmosfarm_members_exists_check'])){
				$_POST['cosmosfarm_members_exists_check'] = array();
			}
			
			$option = new Cosmosfarm_Members_Option();
			$option->save();
			
			wp_redirect(wp_get_referer());
			exit;
		}
		else{
			wp_die(__('You will not be able to perform this task.', 'cosmosfarm-members'));
		}
	}

	private function social_login(){
		$channel = isset($_GET['channel'])?$_GET['channel']:'';
		if(is_object($api = $this->get_social_api($channel))){
			
			$redirect_to = isset($_GET['redirect_to']) ? esc_url_raw(trim($_GET['redirect_to'])) : '';
			if($redirect_to){
				$_SESSION['cosmosfarm_members_social_login_redirect_to'] = $redirect_to;
			}
			
			wp_redirect($api->get_request_url());
			exit;
		}
		wp_redirect(home_url());
		exit;
	}

	private function social_login_callback($channel){
		if(is_object($api = $this->get_social_api($channel))){
			$api->init_access_token();
			$profile = $api->get_profile();
			
			if($profile->id){
				$social_id = "{$channel}@{$profile->id}";
				$user = reset(get_users(array('meta_key'=>'cosmosfarm_members_social_id','meta_value'=>$social_id, 'number'=>1, 'count_total'=>false)));
				$random_password = wp_generate_password(128, true, true);
				
				if(!isset($user->ID) || !$user->ID){
					
					$profile->user_login = sanitize_user($profile->user_login);
					$profile->email = sanitize_email($profile->email);
					$profile->nickname = sanitize_text_field($profile->nickname);
					$profile->picture = sanitize_text_field($profile->picture);
					$profile->url = sanitize_text_field($profile->url);
					
					if(!$profile->user_login || username_exists($profile->user_login)){
						$profile->user_login = "{$channel}_" . uniqid();
					}
					
					if(!$profile->email || email_exists($profile->email)){
						// 무작위 이메일 주소로 회원 등록후, 등록된 이메일을 지우기 위해서 $update_email에 빈 값을 등록해준다.
						$profile->email = "{$channel}_" . uniqid() . '@example.com';
						$update_email = '';
					}
					else{
						$update_email = $profile->email;
					}
					
					include_once COSMOSFARM_MEMBERS_DIR_PATH . '/class/Cosmosfarm_Members_Social_Login.class.php';
					$social_login = new Cosmosfarm_Members_Social_Login();
					$social_login->social_id = $social_id;
					$social_login->channel = $channel;
					$social_login->picture = $profile->picture;
					$social_login->user_url = $profile->url;
					$social_login->user_email = $update_email;
					$social_login->display_name = $profile->nickname;
					$social_login->nickname = $profile->nickname;
					add_action('user_register', array($social_login, 'user_register'), 10, 1);
					
					$user_id = wp_create_user($profile->user_login, $random_password, $profile->email);
					
					$user = new WP_User($user_id);
				}
				else{
					wp_set_password($random_password, $user->ID);
				}
				
				add_user_meta($user->ID, 'cosmosfarm_members_social_picture', $profile->picture);
				
				wp_set_current_user($user->ID, $user->user_login);
				wp_set_auth_cookie($user->ID, false);
				do_action('wp_login', $user->user_login, $user);
				
				$option = get_cosmosfarm_members_option();
				if($option->login_redirect_page == 'main'){
					$redirect_to = home_url();
					wp_redirect($redirect_to);
					exit;
				}
				else if($option->login_redirect_page == 'url' && $option->login_redirect_url){
					$redirect_to = $option->login_redirect_url;
					wp_redirect($redirect_to);
					exit;
				}
				else if(isset($_SESSION['cosmosfarm_members_social_login_redirect_to']) && $_SESSION['cosmosfarm_members_social_login_redirect_to']){
					$redirect_to = $_SESSION['cosmosfarm_members_social_login_redirect_to'];
					$_SESSION['cosmosfarm_members_social_login_redirect_to'] = '';
					unset($_SESSION['cosmosfarm_members_social_login_redirect_to']);
					wp_redirect($redirect_to);
					exit;
				}
			}
		}
		wp_redirect(home_url());
		exit;
	}

	private function get_social_api($channel){
		switch($channel){
			
			case 'naver':
				include_once COSMOSFARM_MEMBERS_DIR_PATH . '/class/api/Cosmosfarm_Members_API_Naver.class.php';
				$api = new Cosmosfarm_Members_API_Naver();
				break;
				
			case 'facebook':
				include_once COSMOSFARM_MEMBERS_DIR_PATH . '/class/api/Cosmosfarm_Members_API_Facebook.class.php';
				$api = new Cosmosfarm_Members_API_Facebook();
				break;
				
			case 'kakao':
				include_once COSMOSFARM_MEMBERS_DIR_PATH . '/class/api/Cosmosfarm_Members_API_Kakao.class.php';
				$api = new Cosmosfarm_Members_API_Kakao();
				break;
				
			case 'google':
				include_once COSMOSFARM_MEMBERS_DIR_PATH . '/class/api/Cosmosfarm_Members_API_Google.class.php';
				$api = new Cosmosfarm_Members_API_Google();
				break;
				
			case 'twitter':
				include_once COSMOSFARM_MEMBERS_DIR_PATH . '/class/api/Cosmosfarm_Members_API_Twitter.class.php';
				$api = new Cosmosfarm_Members_API_Twitter();
				break;
				
			case 'instagram':
				include_once COSMOSFARM_MEMBERS_DIR_PATH . '/class/api/Cosmosfarm_Members_API_Instagram.class.php';
				$api = new Cosmosfarm_Members_API_Instagram();
				break;
				
			case 'line':
				include_once COSMOSFARM_MEMBERS_DIR_PATH . '/class/api/Cosmosfarm_Members_API_Line.class.php';
				$api = new Cosmosfarm_Members_API_Line();
				break;
				
			default: $api = false;
		}
		return $api;
	}

	private function verify_email_confirm(){
		$verify_code = isset($_GET['verify_code'])?$_GET['verify_code']:'';
		
		if($verify_code){
			$users = get_users(array('meta_key'=>'wait_verify_email', 'meta_value'=>$verify_code));
			
			foreach($users as $user){
				delete_user_meta($user->ID, 'wait_verify_email');
				update_user_meta($user->ID, 'verify_email', '1');
				
				$option = get_cosmosfarm_members_option();
				if($option->confirmed_email){
					cosmosfarm_members_send_confirmed_email($user);
				}
				
				wp_redirect(add_query_arg(array('verify_email_confirm'=>'1'), wp_login_url()));
				exit;
			}
		}
		
		if(is_user_logged_in()){
			wp_redirect(home_url());
		}
		else{
			wp_redirect(wp_login_url());
		}
		exit;
	}
	
	private function delete_account(){
		if(current_user_can('activate_plugins')){
			wp_die(__('You will not be able to perform this task.', 'cosmosfarm-members'));
		}
		
		if(is_user_logged_in() && isset($_GET['cosmosfarm_members_delete_account_nonce']) || wp_verify_nonce($_GET['cosmosfarm_members_delete_account_nonce'], 'cosmosfarm_members_delete_account')){
			$current_user = wp_get_current_user();
			
			if($current_user->ID){
				header('Content-Type: text/html; charset=UTF-8');
				
				if(!function_exists('wp_delete_user')){
					include_once ABSPATH . '/wp-admin/includes/user.php';
				}
				
				do_action('cosmosfarm_members_delete_account');
				
				if(wp_delete_user($current_user->ID)){
					wp_clear_auth_cookie();
				}
				
				$message = __('Your account has been deleted.\nThank you.', 'cosmosfarm-members');
				$home_url = home_url();
				
				echo "<script>alert('{$message}');</script>";
				echo "<script>window.location.href='{$home_url}';</script>";
				exit;
			}
		}
		
		if(is_user_logged_in()){
			wp_redirect(home_url());
		}
		else{
			wp_redirect(wp_login_url());
		}
		exit;
	}
	
	private function login_timeout(){
		if(is_user_logged_in()){
			$option = get_cosmosfarm_members_option();
			$use_login_timeout = apply_filters('cosmosfarm_members_use_login_timeout', $option->use_login_timeout, $option);
			if($use_login_timeout){
				
				wp_logout();
				
				if($use_login_timeout == '1'){
					wp_redirect(add_query_arg(array('login_timeout'=>'1'), wp_login_url(wp_get_referer())));
					exit;
				}
				else if($use_login_timeout == '2'){
					wp_redirect(wp_get_referer());
					exit;
				}
			}
		}
		
		if(is_user_logged_in()){
			wp_redirect(home_url());
		}
		else{
			wp_redirect(wp_login_url());
		}
		exit;
	}
	
	private function certification_confirm(){
		$imp_uid = isset($_POST['imp_uid'])?sanitize_text_field($_POST['imp_uid']):'';
		if($imp_uid){
			include_once COSMOSFARM_MEMBERS_DIR_PATH . '/class/api/Cosmosfarm_Members_API_Iamport.class.php';
			$api = new Cosmosfarm_Members_API_Iamport();
			$certification = $api->getCertification($imp_uid);
			
			header('Content-type: application/json');
			echo json_encode($certification);
		}
		exit;
	}
	
	private function exists_check(){
		check_ajax_referer('cosmosfarm-members-check-ajax-referer', 'security');
		
		$mata_key = isset($_POST['mata_key']) ? sanitize_text_field($_POST['mata_key']) : '';
		$mata_value = isset($_POST['mata_value']) ? sanitize_text_field($_POST['mata_value']) : '';
		
		$exists = cosmosfarm_members_user_value_exists($mata_key, $mata_value);
		
		echo wp_send_json(array('exists'=>$exists));
		exit;
	}
}
?>