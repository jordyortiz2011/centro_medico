<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once APPPATH . "libraries/google-api-php-client/Google_Client.php";
include_once APPPATH . "libraries/google-api-php-client/contrib/Google_Oauth2Service.php";

class Google extends CI_Controller {
	
	public $GP_CLIENT_ID = '42198852111-it7uj7m9lgvql84hi6psugl00edavlre.apps.googleusercontent.com';
    public $GP_CLIENT_SECRET = '7pn6WoQH4G8Mz_ffxh_Jezh7';
    public $GP_REDIRECT_URL =  'comun/autentificacion/google/gcallback';
	
	
	function glogin()
    {
            // Fill CLIENT ID, CLIENT SECRET ID, REDIRECT URI from Google Developer Console
        // Google Client Configuration
        
        $GP_REDIRECT_URL =  base_url() . 'comun/autentificacion/google/gcallback';
        
        $gClient = new Google_Client();
        $gClient->setApplicationName('Sigecou');
        $gClient->setClientId($this->GP_CLIENT_ID);
        $gClient->setClientSecret($this->GP_CLIENT_SECRET);
        $gClient->setRedirectUri(base_url() . $this->GP_REDIRECT_URL);
        $google_oauthV2 = new Google_Oauth2Service($gClient);
        $data['authUrl'] = $gClient->createAuthUrl();
        
        header('Location: '.$data['authUrl']);
    }
	
	
	 // this function to handle getting all news
    function gcallback() {
    	
		$GP_REDIRECT_URL =  base_url() . 'comun/autentificacion/google/gcallback';
		
        // Include the google api php libraries
        // https://github.com/googleplus/gplus-verifytoken-php/blob/master/google-api-php-client/src/contrib/Google_Oauth2Service.php
        // Google Project API Credentials
        // Google Client Configuration
        $gClient = new Google_Client();
        $gClient->setApplicationName('Sigecou');
        $gClient->setClientId($this->GP_CLIENT_ID);
        $gClient->setClientSecret($this->GP_CLIENT_SECRET);
        $gClient->setRedirectUri(base_url() . $this->GP_REDIRECT_URL);
        $google_oauthV2 = new Google_Oauth2Service($gClient);

        if ($this->input->get_post('code')) {
            $gClient->authenticate();
            $this->session->set_userdata('token', $gClient->getAccessToken());
            redirect(base_url() . $this->GP_REDIRECT_URL);
        }

        $token = $this->session->userdata('token');
        if (!empty($token)) {
            $gClient->setAccessToken($token);
        }

        if ($gClient->getAccessToken()) {
            $userProfile = $google_oauthV2->userinfo->get();

           // $userId = $this->procesarUsuarioSocial('G' . $userProfile['id'], $userProfile['email']);

           /* $this->session->set_userdata(array(
                'nombre' => $this->crearPersonaSocial($userProfile['given_name'], $userProfile['family_name'], $userId),
                'id' => $userId,
                'auth_level' => 1,
                'avatar' => $userProfile['picture'],
                'social' => true
            ));*/
			
			$_SESSION['correo_red_social'] = $userProfile['email'];

            redirect("users/social_login", 'refresh');;

        } else {
            $data['authUrl'] = $gClient->createAuthUrl();
        }
    }
	
}
