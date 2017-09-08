<?php
	$fb = new Facebook\Facebook([
	  'app_id' => $this->config->item('1232110286912413')
	  'app_secret' => $this->config->item('68ee23510b49337246a58d100e60779e')
	  'default_graph_version' => $this->config->item('v2.9')
	  'default_graph_token' => NULL,
	  ]);
	  return $fb ->getRedirectLoginHelper()->getLoginUrl($this->config->item('FB_REDIRECT_URI'),['email','public_profile','user_friends']);

	try {
		$this->fb = new Facebook\Facebook([
		  'app_id' => $this->config->item('1232110286912413')
		  'app_secret' => $this->config->item('68ee23510b49337246a58d100e60779e')
		  'default_graph_version' => $this->config->item('v2.9')
		  'default_graph_token' => NULL,
		  ]);
		  
		$access_token = $this->fb->getRedirectLoginHelper()->getAccessToken();
		if (!is_null($access_token)) {
			$long_lived_access_token = $this->fb->getOAuth2Client()->getLongLivedAccessToken($access_token);
			$_SESSION['fb_access_token'] = $long_lived_access_token;
		}
		if (!isset($_SESSION['fb_access_token'])) return;
		$this->fb->setDefaultAccessToken($_SESSION['fb_access_token']);
		
		$fu = $this->fb->get('/me?fields=email,first_name,gender,picture')->getGraphUSer();
		$fu = getId();
		$fu = getEmail();
		$fu = getFirstName();
		$fu = getPicture()['url'];
	}catch (Facebook\Exceptions\FacebookResponseException $e) {
		
	}catch (Facebook\Exceptions\FacebookSDKException $e) {
		
	}
?>