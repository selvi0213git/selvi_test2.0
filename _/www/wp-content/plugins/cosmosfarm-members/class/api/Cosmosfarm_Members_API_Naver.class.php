<?php
/**
 * 코스모스팜 회원관리 네이버 연동
 * @link http://www.cosmosfarm.com/
 * @copyright Copyright 2017 Cosmosfarm. All rights reserved.
 */
final class Cosmosfarm_Members_API_Naver {
	
	private $client_id;
	private $client_secret;
	private $redirect_url;
	private $authorize_url = 'https://nid.naver.com/oauth2.0/authorize';
	private $accesstoken_url = 'https://nid.naver.com/oauth2.0/token';
	private $userinfo_url = 'https://apis.naver.com/nidlogin/nid/getUserProfile.xml';
	private $token;
	
	public function __construct(){
		$option = get_cosmosfarm_members_option();
		$this->client_id = $option->naver_client_id;
		$this->client_secret = $option->naver_client_secret;
		$this->redirect_url = home_url('?action=cosmosfarm_members_social_login_callback_naver');
	}
	
	private function get_state(){
		$microtime = microtime();
		$rand = mt_rand();
		return md5($microtime . $rand);
	}
	
	public function get_request_url(){
		$_SESSION['state'] = $this->get_state();
		return $this->authorize_url . '?response_type=code&client_id=' . $this->client_id . '&state=' . $_SESSION['state'] . '&redirect_url=' . urlencode($this->redirect_url);
	}
	
	public function init_access_token(){
		$code = isset($_GET['code'])?$_GET['code']:'';
		if($code){
			$args['grant_type'] = 'authorization_code';
			$args['client_id'] = $this->client_id;
			$args['client_secret'] = $this->client_secret;
			$args['state'] = $_SESSION['state'];
			$args['code'] = $code;
			$response = wp_remote_get(add_query_arg($args, $this->accesstoken_url));
			$data = json_decode($response['body']);
			$this->token = array('Authorization'=>"{$data->token_type} {$data->access_token}");
		}
	}
	
	public function get_profile(){
		$profile = new stdClass();
		if($this->token){
			$response = wp_remote_get($this->userinfo_url, array('headers'=>$this->token));
			$xml = simplexml_load_string($response['body']);
			$profile->id = (string)$xml->response->enc_id;
			$profile->user_login = (string)$xml->response->email;
			$profile->email = (string)$xml->response->email;
			$profile->nickname = (string)$xml->response->nickname;
			$profile->picture = (string)$xml->response->profile_image;
			$profile->url = 'http://blog.naver.com/' . reset(explode('@', $profile->email));
		}
		return $profile;
	}
}
?>