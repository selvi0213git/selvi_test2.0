<?php
/**
 * Cosmosfarm_Members_Mail
 * @link http://www.cosmosfarm.com/
 * @copyright Copyright 2017 Cosmosfarm. All rights reserved.
 */
class Cosmosfarm_Members_Mail {
	
	var $from_name;
	var $from;
	
	public function __construct(){
		global $wpms_options;
		if($wpms_options === null){
			$this->from_name = get_option('blogname');
			$this->from = get_option('admin_email');
		}
	}
	
	public function send($args){
		add_filter('wp_mail_content_type', array($this, 'content_type'));
		add_filter('wp_mail', array($this, 'message_template'));

		if($this->from_name && $this->from) $headers[] = "From: {$this->from_name} <{$this->from}>";
		else if($this->from) $headers[] = "From: {$this->from}";
		else $headers = '';

		$to = $args['to'];
		$subject = $args['subject'];
		$message = $args['message'];

		wp_mail($to, $subject, $message, $headers);

		remove_filter('wp_mail', array($this, 'message_template'));
		remove_filter('wp_mail_content_type', array($this, 'content_type'));
	}
	
	public function content_type(){
		return 'text/html';
	}
	
	public function message_template($args){

		$subject = $args['subject'];
		$message = wpautop($args['message']);

		ob_start();
		include_once COSMOSFARM_MEMBERS_DIR_PATH . '/email/template.php';
		$args['message'] = ob_get_clean();

		return $args;
	}
}
?>