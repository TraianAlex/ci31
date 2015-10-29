<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Fbconnect{

	public function set_ids(){
		$ci =& get_instance();
		$ci->config->load('facebook', TRUE);
		return $ci->config->item('facebook');
	}

	public function set_fb(){
		
		require_once APPPATH . 'libraries/facebook-sdk-v5/autoload.php';
		return new Facebook\Facebook([
			  'app_id' => $this->set_ids()['app_id'],
			  'app_secret' => $this->set_ids()['app_secret'],
			  'default_graph_version' => 'v2.4',
			]);
	}

	public function set_login(){

		$fb = $this->set_fb();
		$helper = $fb->getRedirectLoginHelper();
		$permissions = ['email']; // Optional permissions
		$loginUrl = $helper->getLoginUrl(base_url().'auths/fb_callback', $permissions);
		return $loginUrl;
	}
}


//app id 798807486854593
//version v2.4
//app secret 2ee753c83b0bfed567a8da3aca674a01