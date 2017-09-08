<?php
/**
 * Cosmosfarm_Members_Page_Builder
 * @link http://www.cosmosfarm.com/
 * @copyright Copyright 2017 Cosmosfarm. All rights reserved.
 */
class Cosmosfarm_Members_Page_Builder {

	public function __construct(){
		add_filter('wpmem_login_form', array($this, 'form_layout'), 10, 2);
		add_filter('wpmem_member_links_args', array($this, 'member_links_args'), 10, 1);
		add_filter('wpmem_register_links_args', array($this, 'register_links_args'), 10, 1);
		add_filter('wpmem_login_links_args', array($this, 'login_links_args'), 10, 1);
	}
	
	public function form_layout($form, $action){
		global $cosmosfarm_members_skin;
		
		if($action == 'login'){
			$form = $cosmosfarm_members_skin->login_form($form, $action);
		}
		else if($action == 'pwdchange'){
			$form = $cosmosfarm_members_skin->change_password_form($form, $action);
		}
		
		return $form;
	}
	
	public function member_links_args($args){
		global $wpmem;
		
		if(!is_array($args)){
			$args = array();
		}
		
		$current_user = wp_get_current_user();
		
		if($current_user->cosmosfarm_members_social_id && $current_user->cosmosfarm_members_social_channel){
			unset($args['rows'][1]);
		}
		
		if(isset($_POST['cosmosfarm_members_avatar_nonce']) && wp_verify_nonce($_POST['cosmosfarm_members_avatar_nonce'], 'cosmosfarm_members_avatar')){
			
			$file_handler = get_cosmosfarm_members_file_handler();
			$upload_file = $file_handler->upload_avatar('cosmosfarm_members_avatar_file');
			
			if($upload_file){
				$cosmosfarm_members_avatar = get_user_meta($current_user->ID, 'cosmosfarm_members_avatar', true);
				
				if($cosmosfarm_members_avatar){
					$upload_dir = wp_upload_dir();
					@unlink("{$upload_dir['basedir']}{$cosmosfarm_members_avatar}");
				}
				
				update_user_meta($current_user->ID, 'cosmosfarm_members_avatar', $upload_file['url']);
			}
		}
		
		$args['wrapper_before'] = '<div class="cosmosfarm-members-form">';
		
		$args['wrapper_before'] .= '<div class="profile-header"><form id="cosmosfarm_members_avatar_form" method="post" enctype="multipart/form-data">';
		$args['wrapper_before'] .= wp_nonce_field('cosmosfarm_members_avatar', 'cosmosfarm_members_avatar_nonce');
		$args['wrapper_before'] .= '';
		
		$args['wrapper_before'] .= '<div class="avatar-img"><label for="cosmosfarm_members_avatar_file" title="'.__('Change Avatar', 'cosmosfarm-members').'">'.get_avatar(get_current_user_id(), '150').'<p class="change-avatar-message">'.__('Change Avatar', 'cosmosfarm-members').'</p><input type="file" name="cosmosfarm_members_avatar_file" id="cosmosfarm_members_avatar_file" multiple="false" accept="image/*" onchange="cosmosfarm_members_avatar_form_submit(this)"></label></div>';
		$args['wrapper_before'] .= '<div class="display-name">'.$current_user->display_name.'</div>';
		
		$args['wrapper_before'] .= '</form></div>';
		
		$args['wrapper_before'] .= '<ul class="members-link">';
		$args['wrapper_after'] = '</ul></div>';
		
		if(class_exists('WooCommerce')){
			$woocommerce_myaccount_url = get_permalink(get_option('woocommerce_myaccount_page_id'));
			
			$rows[] = '<li class="orders"><a href="'.$woocommerce_myaccount_url.'orders/">'.__('Orders', 'cosmosfarm-members').'</a></li>';
			
			if(class_exists( 'MShop_Point' )){
				$rows[] = '<li class="mshop-point"><a href="'.$woocommerce_myaccount_url.'mshop-point/">'.__('My Points', 'cosmosfarm-members').' : ' . number_format(get_user_meta(get_current_user_id(), '_mshop_point', true)) . '</a></li>';
			}
		}
		
		if(class_exists('myCRED_Core')){
			$rows[] ='<li class="mycred"><a href="#" onclick="alert(\''.__('Thank you.', 'cosmosfarm-members').'\');return false;">'.__('My Points', 'cosmosfarm-members').' : ' . number_format(mycred_get_users_cred(get_current_user_id())) . '</a></li>';
		}
		
		if(isset($rows)){
			$args['rows'] = array_merge($rows, $args['rows']);
		}
		
		$logout_url = wp_logout_url(wp_login_url());
		$args['rows'][] ='<li class="logout"><a href="'.$logout_url.'">'.__('Log Out', 'cosmosfarm-members').'</a></li>';
		
		$option = get_cosmosfarm_members_option();
		if($option->use_delete_account){
			$delete_account_url = wp_nonce_url(add_query_arg(array('action'=>'cosmosfarm_members_delete_account'), $_SERVER['REQUEST_URI']), 'cosmosfarm_members_delete_account', 'cosmosfarm_members_delete_account_nonce');
			$args['rows'][] ='<li class="delete-account"><a href="'.$delete_account_url.'" onclick="return confirm(\''.__('Press OK button to delete all information from DB.\nDo you want to delete account?\nYou can also re-register at any time.', 'cosmosfarm-members').'\')">'.__('Delete account', 'cosmosfarm-members').'</a></li>';
		}
		
		return $args;
	}
	
	public function register_links_args($args){
		global $wpmem;
		
		if(!is_array($args)){
			$args = array();
		}
		/*
		if(is_user_logged_in()){
			$profile_url = get_cosmosfarm_members_profile_url();
			if($profile_url){
				echo "<script>window.location.href='{$profile_url}';</script>";
			}
		}
		*/
		return $args;
	}
	
	public function login_links_args($args){
		global $wpmem;
		
		if(!is_array($args)){
			$args = array();
		}
		/*
		if(is_user_logged_in()){
			$profile_url = get_cosmosfarm_members_profile_url();
			if($profile_url){
				echo "<script>window.location.href='{$profile_url}';</script>";
			}
		}
		*/
		return $args;
	}
}
?>