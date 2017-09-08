<?php
/**
 * Cosmosfarm_Members
 * @link http://www.cosmosfarm.com/
 * @copyright Copyright 2017 Cosmosfarm. All rights reserved.
 */
final class Cosmosfarm_Members {
	
	static $register_form_page = false;
	
	public function __construct(){
		add_filter('wp_get_nav_menu_items', array($this, 'nav_menu_items'), 20, 3);
		add_filter('wpmem_login_form_args', array($this, 'login_form_args'), 10, 2);
		add_filter('wpmem_login_form_buttons', array($this, 'login_form_buttons'), 10, 2);
		add_filter('wpmem_register_form_args', array($this, 'register_form_args'), 10, 1);
		add_filter('wpmem_register_fields_arr', array($this, 'register_fields_arr'), 10, 2);
		add_filter('wpmem_register_form_rows', array($this, 'register_form_rows'), 10, 2);
		add_filter('wpmem_login_failed_args', array($this, 'login_failed_args'), 10, 1);
		add_filter('wpmem_msg_dialog_arr', array($this, 'msg_dialog_arr'), 10, 2);
		add_filter('wpmem_restricted_msg', array($this, 'restricted_msg'), 10, 1);
		add_filter('wpmem_inc_login_inputs', array($this, 'inc_login_inputs'), 10, 1);
		add_filter('wpmem_pre_validate_form', array($this, 'pre_validate_form'), 10, 1);
		add_filter('wpmem_register_data', array($this, 'register_data'), 10, 2);
		add_filter('wpmem_pwdreset_args', array($this, 'pwdreset_args'), 10, 1);
		add_filter('wpmem_inc_resetpassword_inputs', array($this, 'inc_resetpassword_inputs'), 10, 1);
		add_filter('wpmem_default_text_strings', array($this, 'default_text_strings'), 10, 1);
		add_filter('login_url', array($this, 'login_url'), 10, 2);
		add_filter('login_redirect', array($this, 'login_redirect'), 10, 3);
		add_filter('wpmem_login_redirect', array($this, 'login_redirect'), 10, 1);
		add_filter('register_url', array($this, 'register_url'));
		add_filter('woocommerce_checkout_fields' , array($this, 'woocommerce_checkout_fields'), 10, 1);
		add_filter('get_avatar', array($this, 'get_avatar'), 1, 5);
		add_filter('get_avatar_url', array($this, 'get_avatar_url'), 1, 3);
		add_action('wp_footer', array($this, 'user_required'));
		add_action('wpmem_pre_register_data', array($this, 'pre_register_data'));
		add_action('wpmem_pre_update_data', array($this, 'pre_update_data'));
		add_action('kboard_comments_login_content', array($this, 'kboard_comments_login_content'), 20, 3);
		add_action('wpmem_post_register_data', array($this, 'post_register_data'), 10, 1);
		add_action('wpmem_register_redirect', array($this, 'register_redirect'), 10, 1);
		add_filter('the_content', array($this, 'page_restriction'), 10, 1);
		add_filter('the_content', array($this, 'login_page_message'), 10, 1);
	}
	
	public function add_admin_menu(){
		global $_wp_last_utility_menu;
		
		$_wp_last_utility_menu++;
		add_menu_page('코스모스팜 회원관리', '회원가입관리', 'activate_plugins', 'cosmosfarm_members_setting', array($this, 'setting'), COSMOSFARM_MEMBERS_URL . '/images/icon.png', $_wp_last_utility_menu);
		add_submenu_page('cosmosfarm_members_setting', '설정', '설정', 'activate_plugins', 'cosmosfarm_members_setting');
		add_submenu_page('cosmosfarm_members_setting', '이용약관', '이용약관', 'activate_plugins', 'cosmosfarm_members_policy_service', array($this, 'policy_service'));
		add_submenu_page('cosmosfarm_members_setting', '개인정보', '개인정보', 'activate_plugins', 'cosmosfarm_members_policy_privacy', array($this, 'policy_privacy'));
		add_submenu_page('cosmosfarm_members_setting', '이메일 인증 가입', '이메일 인증 가입', 'activate_plugins', 'cosmosfarm_members_verify_email', array($this, 'verify_email_setting'));
		add_submenu_page('cosmosfarm_members_setting', '자동 등업 관리', '자동 등업 관리', 'activate_plugins', 'cosmosfarm_members_change_role', array($this, 'change_role_setting'));
		add_submenu_page('cosmosfarm_members_setting', '보인인증', '본인인증', 'activate_plugins', 'cosmosfarm_members_certification', array($this, 'certification'));
		add_submenu_page('cosmosfarm_members_setting', '보안설정', '보안설정', 'activate_plugins', 'cosmosfarm_members_security', array($this, 'security_setting'));
		
		$option = get_cosmosfarm_members_option();
		if($option->save_activity_history){
			add_submenu_page('cosmosfarm_members_setting', '개인정보 활동 기록', '개인정보 활동 기록', 'activate_plugins', 'cosmosfarm_members_activity_history', array($this, 'activity_history'));
		}
		
		add_submenu_page('cosmosfarm_members_setting', '중복확인 설정', '중복확인 설정', 'activate_plugins', 'cosmosfarm_members_exists_check', array($this, 'exists_check_setting'));
		
		do_action('cosmosfarm_members_admin_menu');
	}
	
	public function setting(){
		wp_enqueue_script('jquery-ui-sortable');
		$nav_menus = wp_get_nav_menus();
		$option = get_cosmosfarm_members_option();
		include COSMOSFARM_MEMBERS_DIR_PATH . '/admin/setting.php';
	}
	
	public function policy_service(){
		include COSMOSFARM_MEMBERS_DIR_PATH . '/admin/policy_service.php';
	}
	
	public function policy_privacy(){
		include COSMOSFARM_MEMBERS_DIR_PATH . '/admin/policy_privacy.php';
	}
	
	public function certification(){
		$option = get_cosmosfarm_members_option();
		include COSMOSFARM_MEMBERS_DIR_PATH . '/admin/certification.php';
	}
	
	public function verify_email_setting(){
		$option = get_cosmosfarm_members_option();
		include COSMOSFARM_MEMBERS_DIR_PATH . '/admin/verify_email.php';
	}
	
	public function change_role_setting(){
		$option = get_cosmosfarm_members_option();
		include COSMOSFARM_MEMBERS_DIR_PATH . '/admin/change_role.php';
	}
	
	public function security_setting(){
		$option = get_cosmosfarm_members_option();
		include COSMOSFARM_MEMBERS_DIR_PATH . '/admin/security.php';
	}
	
	public function activity_history(){
		include_once COSMOSFARM_MEMBERS_DIR_PATH . '/class/Cosmosfarm_Members_Activity_History_Table.class.php';
		$table = new Cosmosfarm_Members_Activity_History_Table();
		if(isset($_POST['activity_history_id'])){
			$action = $table->current_action();
			if($action == 'delete'){
				foreach($_POST['activity_history_id'] as $key=>$value){
			
				}
			}
		}
		$table->prepare_items();
		$option = get_cosmosfarm_members_option();
		include COSMOSFARM_MEMBERS_DIR_PATH . '/admin/activity_history.php';
	}
	
	public function exists_check_setting(){
		$option = get_cosmosfarm_members_option();
		include COSMOSFARM_MEMBERS_DIR_PATH . '/admin/exists_check.php';
	}

	public function nav_menu_items($items, $menu, $args){
		if(!is_admin()){
			if(get_cosmosfarm_menu_add_login() && in_array($menu->slug, get_cosmosfarm_login_menus())){
				$profile_url = get_cosmosfarm_members_profile_url();
				
				$menu_items['register'] = array('title'=>__('Register', 'cosmosfarm-members'), 'url'=>wp_registration_url(), 'order'=>1, 'classes'=>'cosmosfarm-members-register');
				$menu_items['account'] = array('title'=>__('Account', 'cosmosfarm-members'), 'url'=>$profile_url, 'order'=>1, 'classes'=>'cosmosfarm-members-account');
				$menu_items['login'] = array('title'=>__('Log In', 'cosmosfarm-members'), 'url'=>wp_login_url($_SERVER['REQUEST_URI']), 'order'=>2, 'classes'=>'cosmosfarm-members-login');
				$menu_items['logout'] = array('title'=>__('Log Out', 'cosmosfarm-members'), 'url'=>wp_logout_url($_SERVER['REQUEST_URI']), 'order'=>2, 'classes'=>'cosmosfarm-members-logout');
				
				$menu_items = apply_filters('cosmosfarm_members_menu_items', $menu_items, $menu, $args);
				
				if(is_user_logged_in()){
					if($menu_items['account']['order'] <= $menu_items['logout']['order']){
						if($menu_items['account']['url']) $items[] = cosmosfarm_members_menu_item($menu_items['account']);
						if($menu_items['logout']['url']) $items[] = cosmosfarm_members_menu_item($menu_items['logout']);
					}
					else{
						if($menu_items['logout']['url']) $items[] = cosmosfarm_members_menu_item($menu_items['logout']);
						if($menu_items['account']['url']) $items[] = cosmosfarm_members_menu_item($menu_items['account']);
					}
				}
				else{
					if($menu_items['register']['order'] <= $menu_items['login']['order']){
						if($menu_items['register']['url']) $items[] = cosmosfarm_members_menu_item($menu_items['register']);
						if($menu_items['login']['url']) $items[] = cosmosfarm_members_menu_item($menu_items['login']);
					}
					else{
						if($menu_items['login']['url']) $items[] = cosmosfarm_members_menu_item($menu_items['login']);
						if($menu_items['register']['url']) $items[] = cosmosfarm_members_menu_item($menu_items['register']);
					}
				}
			}
		}
		return $items;
	}

	public function login_form_args($args, $action){
		$option = get_cosmosfarm_members_option();
		
		switch($action){
			case 'login'; $class_name = 'signin-form'; break;
			case 'pwdreset'; $class_name = 'pwdreset-form'; break;
			case 'pwdchange'; $class_name = 'pwdchange-form'; break;
			case 'getusername'; $class_name = 'getusername-form'; break;
		}
		
		$args['main_div_before'] = "<div class=\"cosmosfarm-members-form {$class_name} {$option->skin}\">";
		return $args;
	}

	public function login_form_buttons($args, $action){
		global $wpmem;

		switch($action){
			case 'login'; $button_text = $wpmem->get_text("login_button"); break;
			case 'pwdreset'; $button_text = $wpmem->get_text("pwdreset_button"); break;
			case 'pwdchange'; $button_text = $wpmem->get_text("pwdchg_button"); break;
			case 'getusername'; $button_text = $wpmem->get_text("username_button"); break;
		}

		if($action == 'login'){
			$args = '<div class="button_div"><label><input name="rememberme" type="checkbox" id="rememberme" value="forever">' . $wpmem->get_text('remember_me') . '</label><input type="submit" value="' . $button_text . '" class="buttons"></div>';

			$option = get_cosmosfarm_members_option();
			$redirect_to = isset($_GET['redirect_to']) ? $_GET['redirect_to'] : home_url();

			if($option->social_login_active){
				$args .= $this->social_buttons($action, $redirect_to);
			}
		}
		else{
			$args = '<div class="button_div"><input type="submit" value="' . $button_text . '" class="buttons"></div>';
		}

		return $args;
	}

	public function social_buttons($action='', $redirect_to='', $skin='', $file=''){
		$option = get_cosmosfarm_members_option();
		
		if(!$skin){
			$skin = $option->skin;
		}
		
		if(!$file){
			$file = 'social-buttons';
		}
		
		ob_start();
		$skin_path = COSMOSFARM_MEMBERS_URL . "/skin/{$skin}";
		include COSMOSFARM_MEMBERS_DIR_PATH . "/skin/{$skin}/{$file}.php";
		return ob_get_clean();
	}

	public function register_form_args($args){
		$option = get_cosmosfarm_members_option();
		if(!is_array($args)){
			$args = array();
		}
		$args['main_div_before'] = "<div class=\"cosmosfarm-members-form signup-form {$option->skin}\">";
		return $args;
	}

	public function register_fields_arr($rows, $toggle){
		if(isset($rows['user_email'])){
			$rows['user_email'][1] = __('Email', 'cosmosfarm-members');
			$rows['user_email']['label'] = __('Email', 'cosmosfarm-members');
		}
		return $rows;
	}

	public function register_form_rows($rows, $toggle){
		self::$register_form_page = true;
		
		$option = get_cosmosfarm_members_option();
		$keys = array_keys($rows);
		
		foreach($rows as $meta_key=>$field){
			if($field['type'] == 'checkbox' && !in_array($meta_key, array('policy_service', 'policy_privacy'))){
				$field['label'] = $field['field_before'] . $field['label'];
				$field['field'] = $field['field'] . $field['field_after'];
				$field['field_before'] = '';
				$field['field_after'] = '';
				$rows[$meta_key] = $field;
			}
		}
		
		foreach($option->exists_check as $exists_check_field){
			if(isset($rows[$exists_check_field])){
				$rows[$exists_check_field]['field'] = '<div class="add-buttons">' . $rows[$exists_check_field]['field'] . '<div class="add-buttons-wrap"><button type="button" onclick="cosmosfarm_members_exists_check(\'' . $exists_check_field . '\')">'.__('Check Availability', 'cosmosfarm-members').'</button></div></div>';
			}
		}
		
		if(defined('COSMOSFARM_MEMBERS_JAPAN_ZIP') && COSMOSFARM_MEMBERS_JAPAN_ZIP === true){
			if(isset($rows['zip'])){
				$rows['zip']['field'] = '<div class="add-buttons"><input name="zip" type="text" id="zip" value="' . $rows['zip']['value'] . '" class="textbox"><div class="add-buttons-wrap"><button type="button" onclick="cosmosfarm_find_japan_address()">'.__('Find', 'cosmosfarm-members').'</button></div></div>';
			}
		}
		else{
			if(isset($rows['zip'])){
				wp_enqueue_script('daum-postcode');
				$rows['zip']['field'] = '<input name="zip" type="text" id="zip" value="' . $rows['zip']['value'] . '" class="textbox cursor-pointer" onclick="cosmosfarm_members_open_postcode()" readonly>';
			}
			
			if(isset($rows['addr1'])){
				wp_enqueue_script('daum-postcode');
				$rows['addr1']['field'] = '<input name="addr1" type="text" id="addr1" value="' . $rows['addr1']['value'] . '" class="textbox cursor-pointer" onclick="cosmosfarm_members_open_postcode()" readonly>';
			}
		}
		
		if(isset($rows['policy_service'])){
			$policy_service = wpautop(get_cosmosfarm_policy_service_content());
			$rows['policy_service']['field_before'] = '<div class="div_checkbox agree">';
			$rows['policy_service']['field_before'] .= "<div class=\"policy_content\">{$policy_service}</div><label>";
			$rows['policy_service']['field'] = '<lable>' . $rows['policy_service']['field'] . sprintf(__('I agree to %s.', 'cosmosfarm-members'), $rows['policy_service']['label_text']) . '</lable>';
		}
		
		if(isset($rows['policy_privacy'])){
			$policy_privacy = wpautop(get_cosmosfarm_policy_privacy_content());
			$rows['policy_privacy']['field_before'] = '<div class="div_checkbox agree">';
			$rows['policy_privacy']['field_before'] .= "<div class=\"policy_content\">{$policy_privacy}</div><label>";
			$rows['policy_privacy']['field'] = '<lable>' . $rows['policy_privacy']['field'] . sprintf(__('I agree to %s.', 'cosmosfarm-members'), $rows['policy_privacy']['label_text']) . '</lable>';
		}
		
		if(isset($rows['username'])){
			if($option->allow_email_login){
				unset($rows['username']);
			}
		}
		
		if(isset($rows['birthday'])){
			wp_enqueue_script('jquery-ui-datepicker');
			wp_register_style('jquery-ui', 'https://code.jquery.com/ui/1.12.1/themes/flick/jquery-ui.css');
			wp_enqueue_style('jquery-ui');
		}
		
		if($option->iamport_id && $option->use_certification){
			if($option->certification_name_field && in_array($option->certification_name_field, $keys)) $add_certify_index[$option->certification_name_field] = array_search($option->certification_name_field, $keys);
			if($option->certification_gender_field && in_array($option->certification_gender_field, $keys)) $add_certify_index[$option->certification_gender_field] = array_search($option->certification_gender_field, $keys);
			if($option->certification_birth_field && in_array($option->certification_birth_field, $keys)) $add_certify_index[$option->certification_birth_field] = array_search($option->certification_birth_field, $keys);
			if(COSMOSFARM_MEMBERS_CERTIFIED_PHONE){
				if($option->certification_carrier_field && in_array($option->certification_carrier_field, $keys)) $add_certify_index[$option->certification_carrier_field] = array_search($option->certification_carrier_field, $keys);
				if($option->certification_phone_field && in_array($option->certification_phone_field, $keys)) $add_certify_index[$option->certification_phone_field] = array_search($option->certification_phone_field, $keys);
			}
			if(isset($add_certify_index) && is_array($add_certify_index)){
				asort($add_certify_index);
				reset($add_certify_index);
				$add_certify = key($add_certify_index);
				
				if($option->certification_name_field){
					if(isset($rows[$option->certification_name_field]) && $add_certify == $option->certification_name_field){
						$rows[$option->certification_name_field]['field'] = '<div class="add-buttons"><input name="'.$option->certification_name_field.'" type="text" id="'.$option->certification_name_field.'" value="' . $rows[$option->certification_name_field]['value'] . '" class="textbox cursor-default" onclick="cosmosfarm_members_certification()" readonly><div class="add-buttons-wrap"><button type="button" onclick="cosmosfarm_members_certification()">'.__('Certify', 'cosmosfarm-members').'</button></div></div>';
						$rows[$option->certification_name_field]['field'] .= "<script>jQuery(document).ready(function(){IMP.init('{$option->iamport_id}')})</script>";
						wp_enqueue_script('iamport-payment');
					}
					else{
						$rows[$option->certification_name_field]['field'] = '<input name="'.$option->certification_name_field.'" type="text" id="'.$option->certification_name_field.'" value="' . $rows[$option->certification_name_field]['value'] . '" class="textbox cursor-default" onclick="cosmosfarm_members_certification()" readonly>';
					}
				}
				
				if($option->certification_gender_field){
					if(isset($rows[$option->certification_gender_field]) && $add_certify == $option->certification_gender_field){
						$rows[$option->certification_gender_field]['field'] = '<div class="add-buttons"><input name="'.$option->certification_gender_field.'" type="text" id="'.$option->certification_gender_field.'" value="' . $rows[$option->certification_gender_field]['value'] . '" class="textbox cursor-default" onclick="cosmosfarm_members_certification()" readonly><div class="add-buttons-wrap"><button type="button" onclick="cosmosfarm_members_certification()">'.__('Certify', 'cosmosfarm-members').'</button></div></div>';
						$rows[$option->certification_gender_field]['field'] .= "<script>jQuery(document).ready(function(){IMP.init('{$option->iamport_id}')})</script>";
						wp_enqueue_script('iamport-payment');
					}
					else{
						$rows[$option->certification_gender_field]['field'] = '<input name="'.$option->certification_gender_field.'" type="text" id="'.$option->certification_gender_field.'" value="' . $rows[$option->certification_gender_field]['value'] . '" class="textbox cursor-default" onclick="cosmosfarm_members_certification()" readonly>';
					}
				}
				
				if($option->certification_birth_field){
					if(isset($rows[$option->certification_birth_field]) && $add_certify == $option->certification_birth_field){
						$rows[$option->certification_birth_field]['field'] = '<div class="add-buttons"><input name="'.$option->certification_birth_field.'" type="text" id="'.$option->certification_birth_field.'" value="' . $rows[$option->certification_birth_field]['value'] . '" class="textbox cursor-default" onclick="cosmosfarm_members_certification()" readonly><div class="add-buttons-wrap"><button type="button" onclick="cosmosfarm_members_certification()">'.__('Certify', 'cosmosfarm-members').'</button></div></div>';
						$rows[$option->certification_birth_field]['field'] .= "<script>jQuery(document).ready(function(){IMP.init('{$option->iamport_id}')})</script>";
						wp_enqueue_script('iamport-payment');
					}
					else{
						$rows[$option->certification_birth_field]['field'] = '<input name="'.$option->certification_birth_field.'" type="text" id="'.$option->certification_birth_field.'" value="' . $rows[$option->certification_birth_field]['value'] . '" class="textbox cursor-default" onclick="cosmosfarm_members_certification()" readonly>';
					}
				}
				
				if(COSMOSFARM_MEMBERS_CERTIFIED_PHONE){
					if($option->certification_carrier_field){
						if(isset($rows[$option->certification_carrier_field]) && $add_certify == $option->certification_carrier_field){
							$rows[$option->certification_carrier_field]['field'] = '<div class="add-buttons"><input name="'.$option->certification_carrier_field.'" type="text" id="'.$option->certification_carrier_field.'" value="' . $rows[$option->certification_carrier_field]['value'] . '" class="textbox cursor-default" onclick="cosmosfarm_members_certification()" readonly><div class="add-buttons-wrap"><button type="button" onclick="cosmosfarm_members_certification()">'.__('Certify', 'cosmosfarm-members').'</button></div></div>';
							$rows[$option->certification_carrier_field]['field'] .= "<script>jQuery(document).ready(function(){IMP.init('{$option->iamport_id}')})</script>";
							wp_enqueue_script('iamport-payment');
						}
						else{
							$rows[$option->certification_carrier_field]['field'] = '<input name="'.$option->certification_carrier_field.'" type="text" id="'.$option->certification_carrier_field.'" value="' . $rows[$option->certification_carrier_field]['value'] . '" class="textbox cursor-default" onclick="cosmosfarm_members_certification()" readonly>';
						}
					}
					
					if($option->certification_phone_field){
						if(isset($rows[$option->certification_phone_field]) && $add_certify == $option->certification_phone_field){
							$rows[$option->certification_phone_field]['field'] = '<div class="add-buttons"><input name="'.$option->certification_phone_field.'" type="text" id="'.$option->certification_phone_field.'" value="' . $rows[$option->certification_phone_field]['value'] . '" class="textbox cursor-default" onclick="cosmosfarm_members_certification()" readonly><div class="add-buttons-wrap"><button type="button" onclick="cosmosfarm_members_certification()">'.__('Certify', 'cosmosfarm-members').'</button></div></div>';
							$rows[$option->certification_phone_field]['field'] .= "<script>jQuery(document).ready(function(){IMP.init('{$option->iamport_id}')})</script>";
							wp_enqueue_script('iamport-payment');
						}
						else{
							$rows[$option->certification_phone_field]['field'] = '<input name="'.$option->certification_phone_field.'" type="text" id="'.$option->certification_phone_field.'" value="' . $rows[$option->certification_phone_field]['value'] . '" class="textbox cursor-default" onclick="cosmosfarm_members_certification()" readonly>';
						}
					}
				}
			}
		}
		
		if($toggle == 'new'){
			if($option->use_strong_password){
				wp_enqueue_script('password-strength-meter');
				$password_strength_meter_display = '<span class="password-strength-meter-display bad">' . __('Password must consist of 8 digits, including English, numbers and special characters.', 'cosmosfarm-members') . '</span>';
				if(isset($rows['confirm_password'])){
					$rows['confirm_password']['field'] = '<input name="confirm_password" type="password" id="confirm_password" class="textbox" onkeyup="cosmosfarm_members_check_password_strength()" required>' . $password_strength_meter_display;
					$password_strength_meter_display = '';
				}
				if(isset($rows['password'])){
					$rows['password']['field'] = '<input name="password" type="password" id="password" class="textbox" onkeyup="cosmosfarm_members_check_password_strength()" required><span class="password-text"></span>' . $password_strength_meter_display;
				}
			}
		}
		
		return $rows;
	}

	public function login_failed_args($args){
		global $wpmem;
		
		$user_login = isset($_POST['log'])?sanitize_user($_POST['log']):'';
		$user_password = isset($_POST['pwd'])?$_POST['pwd']:'';
		
		$option = get_cosmosfarm_members_option();
		
		$user = get_user_by('login', $user_login);
		if(!$user){
			$user = get_user_by('email', $user_login);
		}
		
		if($user && wp_check_password($user_password, $user->data->user_pass, $user->ID)){
			if(($wpmem->mod_reg == 1) && (get_user_meta($user->ID, 'active', true) != 1)){
				$args['message'] = __('<strong>ERROR</strong>: User has not been activated.', 'wp-members');
			}

			if($option->verify_email && get_user_meta($user->ID, 'wait_verify_email', true)){
				$args['message'] = __('Please check the email sent to your email address.', 'cosmosfarm-members');
			}
		}
		
		if($user && $option->use_login_protect){
			$login_protect_lockdown_timestamp = get_user_meta($user->ID, 'login_protect_lockdown_timestamp', true);
			if($login_protect_lockdown_timestamp){
				if(current_time('timestamp') - $login_protect_lockdown_timestamp <= $option->login_protect_lockdown * 60){
					$args['message'] = sprintf(__('You have exceeded the maximum number of %d attempts, try again in %d minutes.', 'cosmosfarm-members'), $option->login_protect_count, $option->login_protect_lockdown);
				}
			}
		}

		$args['div_before'] = '<div class="cosmosfarm-members-form loginfailed"><div class="message">';
		$args['div_after'] = '</div></div>';
		return $args;
	}
	
	public function msg_dialog_arr($args, $toggle){
		$args['div_before'] = "<div class=\"cosmosfarm-members-form {$toggle}\"><div class=\"message\">";
		$args['div_after'] = '</div></div>';
		return $args;
	}
	
	public function restricted_msg($args){
		global $wpmem;
		$args = '<p style="text-align:center">' . $wpmem->get_text("restricted_msg") . '</p>';
		return $args;
	}
	
	public function inc_login_inputs($array){
		global $wpmem;
		if($array[0]['tag'] == 'log'){
			$option = get_cosmosfarm_members_option();
			if($option->allow_email_login){
				$array[0]['name'] = $wpmem->get_text('user_email');
			}
		}
		return $array;
	}
	
	public function pre_validate_form($fields){
		$option = get_cosmosfarm_members_option();
		if($option->allow_email_login){
			if(!isset($fields['username']) || !$fields['username']){
				if(is_multisite()){
					$fields['username'] = uniqid();
				}
				else{
					$fields['username'] = sanitize_user($fields['user_email']);
				}
			}
		}
		return $fields;
	}
	
	public function register_data($fields, $toggle){
		$option = get_cosmosfarm_members_option();
		if($toggle == 'new'){
			if($option->allow_email_login){
				if(is_multisite()){
					$fields['username'] = sanitize_user($fields['user_email']);
				}

				$user_nicename = isset($_POST['user_nicename']) ? sanitize_user($_POST['user_nicename']) : '';
				$display_name = isset($_POST['display_name']) ? sanitize_user($_POST['display_name']) : '';
				$nickname = isset($_POST['nickname']) ? sanitize_user($_POST['nickname']) : '';

				$user_email = explode('@', $fields['user_email']);
				$display = reset($user_email);
				$display = sanitize_user($display);

				$fields['user_nicename'] = $user_nicename ? $user_nicename : $display;
				$fields['display_name'] = $display_name ? $display_name : $display;
				$fields['nickname'] = $nickname ? $nickname : $display;
			}
		}
		else if($toggle == 'edit'){
			unset($fields['username']);
		}
		return $fields;
	}

	public function pwdreset_args($args){
		$option = get_cosmosfarm_members_option();
		if($option->allow_email_login){
			if(!isset($args['user']) || !$args['user']){
				if(is_object($user = get_user_by('email', $args['email']))){
					$args['user'] = $user->user_login;
				}
				else if(is_object($user = get_user_by('login', $args['email']))){
					$args['user']  = $user->user_login;
					$args['email'] = $user->user_email;
				}
				else{
					$args['user'] = $args['email'];
				}
			}
		}
		return $args;
	}

	public function inc_resetpassword_inputs($array){
		$option = get_cosmosfarm_members_option();
		if($option->allow_email_login){
			foreach($array as $input){
				if($input['tag'] == 'email'){
					$new_array[] = $input;
				}
			}
			$array = $new_array;
		}
		return $array;
	}

	public function default_text_strings($args){
		if(!is_array($args)) $args = array();
		$args['login_username'] = __('Username', 'cosmosfarm-members');
		$args['pwdreset_username'] = __('Username', 'cosmosfarm-members');
		$args['user_email'] = __('Email', 'cosmosfarm-members');
		$args['remember_me'] = __('Keep me signed in', 'cosmosfarm-members');
		$args['forgot_link_before'] = '';
		$args['forgot_link'] = __('Forgot Password', 'cosmosfarm-members');
		$args['register_link_before'] = '';
		$args['register_link'] = __('Register', 'cosmosfarm-members');
		$args['register_required'] = '<span class="req">*</span>'.__('Required', 'cosmosfarm-members');
		$args['username_email'] = __('Email', 'cosmosfarm-members');
		$args['username_link_before'] = '';
		$args['username_link'] = __('Forgot Username', 'cosmosfarm-members');
		$args['username_button'] = __('Forgot Username', 'cosmosfarm-members');
		$args['usernamefailed'] = __('Email address does not exist.', 'cosmosfarm-members');
		$args['pwdchangesuccess'] = __('Password successfully changed!', 'cosmosfarm-members');
		return $args;
	}

	public function login_url($login_url, $redirect_to){
		if(!is_admin()){
			$option = get_cosmosfarm_members_option();

			if(isset($_GET['redirect_to']) && $_GET['redirect_to']){
				$redirect_to = '';
			}
			else if($option->login_page_id == get_the_ID()){
				$redirect_to = '';
			}
			else if(wpmem_login_url() == get_permalink()){
				$redirect_to = '';
			}
			
			$redirect_to = $this->login_redirect($redirect_to);
			
			if($option->login_page_id || $option->login_page_url){
				if($option->login_page_id){
					if($redirect_to){
						$login_url = add_query_arg(array('redirect_to'=>urlencode($redirect_to)), get_permalink($option->login_page_id));
					}
					else{
						$login_url = get_permalink($option->login_page_id);
					}
				}
				else if($option->login_page_url){
					if($redirect_to){
						$login_url = add_query_arg(array('redirect_to'=>urlencode($redirect_to)), $option->login_page_url);
					}
					else{
						$login_url = $option->login_page_url;
					}
				}
			}
			else if(wpmem_login_url()){
				$login_url = wpmem_login_url($redirect_to);
			}
		}
		return $login_url;
	}

	public function login_redirect($redirect_to, $request='', $user=''){
		$option = get_cosmosfarm_members_option();
		if($option->login_redirect_page == 'main'){
			$redirect_to = home_url();
		}
		else if($option->login_redirect_page == 'url' && $option->login_redirect_url){
			$redirect_to = $option->login_redirect_url;
		}
		return esc_url_raw($redirect_to);
	}

	public function register_url($register_url){
		if(!is_admin()){
			$option = get_cosmosfarm_members_option();

			if($option->register_page_id || $option->login_page_url){
				if($option->register_page_id){
					$register_url = get_permalink($option->register_page_id);
				}
				else if($option->register_page_url){
					$register_url = $option->register_page_url;
				}
			}
			else if(wpmem_register_url()){
				$register_url = wpmem_register_url();
			}
		}
		return $register_url;
	}

	public function woocommerce_checkout_fields($fields){
		global $woocommerce;
		if(is_user_logged_in()){

			if(isset($fields['billing']['billing_first_name'])){
				$fields['billing']['billing_first_name']['default'] = get_user_meta(get_current_user_id(), 'first_name', true);
			}
			if(isset($fields['billing']['billing_last_name'])){
				$fields['billing']['billing_last_name']['default'] = get_user_meta(get_current_user_id(), 'last_name', true);
			}
			if(isset($fields['billing']['billing_phone'])){
				$fields['billing']['billing_phone']['default'] = get_user_meta(get_current_user_id(), 'phone1', true);
			}
			if(isset($fields['billing']['billing_country'])){
				$fields['billing']['billing_country']['default'] = get_user_meta(get_current_user_id(), 'country', true);
			}
			if(isset($fields['billing']['billing_address_1'])){
				$fields['billing']['billing_address_1']['default'] = get_user_meta(get_current_user_id(), 'addr1', true);
			}
			if(isset($fields['billing']['billing_address_2'])){
				$fields['billing']['billing_address_2']['default'] = get_user_meta(get_current_user_id(), 'addr2', true);
			}
			if(isset($fields['billing']['billing_city'])){
				$fields['billing']['billing_city']['default'] = get_user_meta(get_current_user_id(), 'city', true);
			}
			if(isset($fields['billing']['billing_state'])){
				$fields['billing']['billing_state']['default'] = get_user_meta(get_current_user_id(), 'state', true);
			}

			if(isset($fields['shipping']['shipping_first_name'])){
				$fields['shipping']['shipping_first_name']['default'] = get_user_meta(get_current_user_id(), 'first_name', true);
			}
			if(isset($fields['shipping']['shipping_last_name'])){
				$fields['shipping']['shipping_last_name']['default'] = get_user_meta(get_current_user_id(), 'last_name', true);
			}
			if(isset($fields['shipping']['shipping_country'])){
				$fields['shipping']['shipping_country']['default'] = get_user_meta(get_current_user_id(), 'country', true);
			}
			if(isset($fields['shipping']['shipping_address_1'])){
				$fields['shipping']['shipping_address_1']['default'] = get_user_meta(get_current_user_id(), 'addr1', true);
			}
			if(isset($fields['shipping']['shipping_address_2'])){
				$fields['shipping']['shipping_address_2']['default'] = get_user_meta(get_current_user_id(), 'addr2', true);
			}
			if(isset($fields['shipping']['shipping_city'])){
				$fields['shipping']['shipping_city']['default'] = get_user_meta(get_current_user_id(), 'city', true);
			}
			if(isset($fields['shipping']['shipping_state'])){
				$fields['shipping']['shipping_state']['default'] = get_user_meta(get_current_user_id(), 'state', true);
			}

			$woocommerce->customer->set_postcode(get_user_meta(get_current_user_id(), 'zip', true));
			$woocommerce->customer->set_shipping_postcode(get_user_meta(get_current_user_id(), 'zip', true));
		}
		return $fields;
	}

	public function get_avatar($avatar, $id_or_email, $size, $default, $alt){
		$user = false;
		
		if(is_numeric($id_or_email)){
			$id = (int) $id_or_email;
			$user = get_user_by('id', $id);
		}
		else if(is_object( $id_or_email)){
			if(!empty($id_or_email->user_id)){
				$id = (int) $id_or_email->user_id;
				$user = get_user_by('id' , $id);
			}
		}
		else{
			$user = get_user_by('email', $id_or_email);
		}
		
		if(isset($user->ID) && $user->ID){
			
			$cosmosfarm_members_avatar = get_user_meta($user->ID, 'cosmosfarm_members_avatar', true);
			if($cosmosfarm_members_avatar){
				$cosmosfarm_members_avatar = content_url("/uploads{$cosmosfarm_members_avatar}");
				$avatar = "<img alt='{$alt}' src='{$cosmosfarm_members_avatar}' class='avatar avatar-{$size} photo' height='{$size}' width='{$size}' />";
			}
			else{
				$social_picture = get_user_meta($user->ID, 'cosmosfarm_members_social_picture', true);
				if($social_picture){
					$avatar = "<img alt='{$alt}' src='{$social_picture}' class='avatar avatar-{$size} photo' height='{$size}' width='{$size}' />";
				}
			}
		}
		
		return $avatar;
	}
	
	public function get_avatar_url($url, $id_or_email, $args){
		$user = false;
		
		if(is_numeric($id_or_email)){
			$id = (int) $id_or_email;
			$user = get_user_by('id', $id);
		}
		else if(is_object( $id_or_email)){
			if(!empty($id_or_email->user_id)){
				$id = (int) $id_or_email->user_id;
				$user = get_user_by('id' , $id);
			}
		}
		else{
			$user = get_user_by('email', $id_or_email);
		}
		
		if(isset($user->ID) && $user->ID){
			
			$cosmosfarm_members_avatar = get_user_meta($user->ID, 'cosmosfarm_members_avatar', true);
			if($cosmosfarm_members_avatar){
				$cosmosfarm_members_avatar = content_url("/uploads{$cosmosfarm_members_avatar}");
				$url = $cosmosfarm_members_avatar;
			}
			else{
				$social_picture = get_user_meta($user->ID, 'cosmosfarm_members_social_picture', true);
				if($social_picture){
					$url = $social_picture;
				}
			}
		}
		
		return $url;
	}

	public function user_required(){
		$option = get_cosmosfarm_members_option();
		if($option->user_required){
			if(!self::$register_form_page && is_user_logged_in()){
				$user_id = get_current_user_id();
				$current_user = get_userdata($user_id);
				$profile_url = get_cosmosfarm_members_profile_url();
					
				if($profile_url){
					$profile_url = add_query_arg(array('a'=>'edit'), $profile_url);
				}
				else{
					$profile_url = admin_url('profile.php');
				}
					
				$wpmem_fields = apply_filters('wpmem_register_fields_arr', wpmem_fields(), 'user_required');
				foreach($wpmem_fields as $meta_key=>$field){
					if($field['required'] && !in_array($meta_key, array('password', 'confirm_password', 'password_confirm'))){
						if(!$current_user->{$meta_key}){
							echo '<script>alert("'.__('Please enter the required information.', 'cosmosfarm-members').'");</script>';
							echo "<script>window.location.href='{$profile_url}';</script>";
							return;
						}
					}
				}
					
				do_action('cosmosfarm_members_user_required', $current_user, $profile_url);
			}
		}
	}
	
	public function pre_register_data($fields){
		global $wpmem_themsg, $wpdb;
		
		add_filter('wp_handle_upload_prefilter', array($this, 'file_rename'));
		
		$option = get_cosmosfarm_members_option();
		
		foreach($option->exists_check as $exists_check_field){
			if(isset($fields[$exists_check_field])){
				if(cosmosfarm_members_user_value_exists($exists_check_field, $fields[$exists_check_field])){
					$fields = wpmem_fields();
					$wpmem_themsg = sprintf(__('%s already exists.', 'cosmosfarm-members'), $fields[$exists_check_field]['label']);
					break;
				}
			}
		}
	}
	
	public function pre_update_data($fields){
		global $wpmem_themsg, $wpdb;
		
		add_filter('wp_handle_upload_prefilter', array($this, 'file_rename'));
		
		$option = get_cosmosfarm_members_option();
		$current_user = wp_get_current_user();
		
		foreach($option->exists_check as $exists_check_field){
			if(isset($fields[$exists_check_field])){
				if($fields[$exists_check_field] != $current_user->{$exists_check_field}){
					if(cosmosfarm_members_user_value_exists($exists_check_field, $fields[$exists_check_field])){
						$fields = wpmem_fields();
						$wpmem_themsg = sprintf(__('%s already exists.', 'cosmosfarm-members'), $fields[$exists_check_field]['label']);
						break;
					}
				}
			}
		}
	}

	public function file_rename($file){
		$file['name'] = uniqid() . '-' . $file['name'];
		return $file;
	}

	public function kboard_comments_login_content($board, $content_uid, $comment_builder){
		echo cosmosfarm_members_social_buttons();
	}

	public function post_register_data($fields){
		$option = get_cosmosfarm_members_option();
		if($option->verify_email && $fields['ID']){

			$user = new WP_User($fields['ID']);
			if($user->ID && $user->user_email){

				$verify_code = cosmosfarm_members_send_verify_email($user);
				update_user_meta($user->ID, 'wait_verify_email', $verify_code);
			}
		}
	}

	public function register_redirect($fields){
		wp_redirect(add_query_arg(array('register_success'=>'1'), wp_login_url()));
		exit;
	}
	
	public function page_restriction($content){
		global $post;
		
		if(is_single() || is_page()){
			$option = get_cosmosfarm_members_option();
			
			$page_restriction = get_post_meta($post->ID, 'cosmosfarm_members_page_restriction', true);
			if($page_restriction){
				
				if(!is_user_logged_in()){
					
					if($option->page_restriction_redirect == '1'){
						echo '<script>alert("'.__('Log in to view this page.', 'cosmosfarm-members').'");</script>';
						echo '<script>window.location.href="' . wp_login_url($_SERVER['REQUEST_URI']) . '";</script>';
						exit;
					}
					else if($option->page_restriction_redirect == '2'){
						echo '<script>window.location.href="' . wp_login_url($_SERVER['REQUEST_URI']) . '";</script>';
						exit;
					}
					else{
						$_GET['redirect_to'] = $_SERVER['REQUEST_URI'];
						$content = wpmem_inc_regmessage('page_restriction', '<p>'.__('Log in to view this page.', 'cosmosfarm-members').'</p>') . wpmem_inc_login('page_restriction');
					}
				}
				else{
					$current_user = wp_get_current_user();
					$restriction_roles = get_post_meta($post->ID, 'cosmosfarm_members_page_restriction_roles', true);
					
					$this_restriction = true;
					foreach($current_user->roles as $role){
						if(in_array($role, $restriction_roles)){
							$this_restriction = false;
							break;
						}
					}
					
					if($this_restriction){
						$content = wpmem_inc_regmessage('page_restriction', '<p>'.__('You do not have permission to view this page.', 'cosmosfarm-members').'</p>');
					}
				}
			}
		}
		
		return $content;
	}

	public function login_page_message($content){
		global $post;
		
		if(is_page()){
			$option = get_cosmosfarm_members_option();
			
			if(isset($_GET['verify_email_confirm']) && $_GET['verify_email_confirm']){
				$content = wpmem_inc_regmessage('verify_email_confirm', '<p>'.__('Your email has been verified. Please log in.', 'cosmosfarm-members').'</p>') . $content;
			}
			
			if(isset($_GET['register_success']) && $_GET['register_success']){
				if($option->verify_email){
					$content = wpmem_inc_regmessage('register_success', '<p>'.__('Congratulations! Register was successful.', 'cosmosfarm-members').'</p><p>'.__('An email sent to the email address you signed up with, please check.', 'cosmosfarm-members').'</p>') . $content;
				}
				else{
					$content = wpmem_inc_regmessage('register_success', '<p>'.__('Congratulations! Register was successful.', 'cosmosfarm-members').'</p>') . $content;
				}
			}
			
			if(isset($_GET['login_timeout']) && $_GET['login_timeout']){
				$content = wpmem_inc_regmessage('login_timeout', '<p>'.__('You have been automatically logged out to protect your privacy.', 'cosmosfarm-members').'</p>') . $content;
			}
		}
		
		return $content;
	}
}
?>