<?php
/**
 * Cosmosfarm_Members_API_Iamport
 * @link http://www.cosmosfarm.com/
 * @copyright Copyright 2017 Cosmosfarm. All rights reserved.
 */
final class Cosmosfarm_Members_API_Iamport {
	
	private $access_token;
	private $expired_at;
	
	private $certification_url = 'https://api.iamport.kr/certifications';
	private $accesstoken_url = 'https://api.iamport.kr/users/getToken';
	
	public function getCertification($imp_uid){
		$certification = new stdClass();
		$certification->name = '';
		$certification->birth = '';
		$certification->gender = '';
		$certification->error_message = '';
		
		if(COSMOSFARM_MEMBERS_CERTIFIED_PHONE){
			$certification->carrier = '';
			$certification->phone = '';
		}
		
		if($imp_uid && $this->getAccessToken()){
			$response = wp_safe_remote_get(sprintf('%s/%s?_token=%s', $this->certification_url, $imp_uid, $this->getAccessToken()));
			if($response['response']['code'] != '200'){
				$certification->error_message = $response['response']['message'];
			}
			else{
				$data = json_decode($response['body']);
				if($data->response){
					// 아임포트에서 보내주는 timestamp는 한국시간 기준으로 생성됐기 때문에 timezone을 변경해준다.
					date_default_timezone_set('Asia/Seoul');
					
					$certification->name = $data->response->name;
					$certification->birth = date('Y-m-d', $data->response->birth);
					$certification->gender = $data->response->gender;
					
					if(COSMOSFARM_MEMBERS_CERTIFIED_PHONE){
						$certification->carrier = isset($data->response->carrier)?$data->response->carrier:'';
						$certification->phone = isset($data->response->phone)?$data->response->phone:'';
					}
				}
				else{
					$certification->error_message = '죄송합니다. 에러가 발생했습니다. 다시 인증해주세요.';
				}
			}
		}
		
		return $certification;
	}
	
	public function getAccessToken(){
		if(time() < $this->expired_at && $this->access_token){
			return $this->access_token;
		}
		
		$option = get_cosmosfarm_members_option();
		
		$body['imp_key'] = $option->iamport_api_key;
		$body['imp_secret'] = $option->iamport_api_secret;
		$response = wp_safe_remote_post($this->accesstoken_url, array('body'=>$body));
		
		if($response['response']['code'] != '200'){
			echo $response['response']['message'];
			$this->access_token = '';
		}
		else{
			$data = json_decode($response['body']);
			if($data->response){
				$this->expired_at = time() + ($data->response->expired_at - $data->response->now);
				$this->access_token = $data->response->access_token;
			}
		}
		
		return $this->access_token;
	}
}
?>