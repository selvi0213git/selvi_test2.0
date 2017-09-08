<?php
/**
 * Cosmosfarm_Members_Skin
 * @link http://www.cosmosfarm.com/
 * @copyright Copyright 2017 Cosmosfarm. All rights reserved.
 */
class Cosmosfarm_Members_Skin {
	
	public function __construct(){
		
	}
	
	public function login_form($form, $action){
		global $post;
		
		$option = get_cosmosfarm_members_option();
		$redirect_to = isset($_REQUEST['redirect_to']) ? $_REQUEST['redirect_to'] : '';
		
		if(!$redirect_to && $post->ID == $option->login_page_id){
			$redirect_to = home_url();
		}
		else if(!$redirect_to){
			$redirect_to = get_permalink();
		}
		
		$skin_path = COSMOSFARM_MEMBERS_URL . "/skin/{$option->skin}";
		$redirect_to = apply_filters('cosmosfarm_members_login_redirect_to', $redirect_to);
		
		$login_action_url = remove_query_arg(array('verify_email_confirm', 'register_success', 'login_timeout'));
		
		if(file_exists(COSMOSFARM_MEMBERS_DIR_PATH . "/skin/{$option->skin}/login-form.php")){
			ob_start();
			include_once COSMOSFARM_MEMBERS_DIR_PATH . "/skin/{$option->skin}/login-form.php";
			$form = ob_get_clean();
		}
		
		return $form;
	}
	
	public function change_password_form($form, $action){
		global $post;
		
		$option = get_cosmosfarm_members_option();
		$skin_path = COSMOSFARM_MEMBERS_URL . "/skin/{$option->skin}";
		$form_action_url = get_permalink();
		
		if(file_exists(COSMOSFARM_MEMBERS_DIR_PATH . "/skin/{$option->skin}/change-password-form.php")){
			ob_start();
			include_once COSMOSFARM_MEMBERS_DIR_PATH . "/skin/{$option->skin}/change-password-form.php";
			$form = ob_get_clean();
		}
		
		return $form;
	}
	
	public function account_links(){
		global $post;
		
		$option = get_cosmosfarm_members_option();
		$skin_path = COSMOSFARM_MEMBERS_URL . "/skin/{$option->skin}";
		
		if(file_exists(COSMOSFARM_MEMBERS_DIR_PATH . "/skin/{$option->skin}/account-links.php")){
			ob_start();
			include_once COSMOSFARM_MEMBERS_DIR_PATH . "/skin/{$option->skin}/account-links.php";
			$form = ob_get_clean();
		}
		
		return $form;
	}
}
?>