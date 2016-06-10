<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Facebook\Facebook;

class Controller extends BaseController
{
    /**
     * The Facebook client.
     * @var Facebook
     */
    protected $_facebookClient;
    
    public function __construct()
    {
        $this->_facebookClient = new Facebook([
            'app_id' => env('FACEBOOK_APP_ID'),
            'app_secret' => env('FACEBOOK_APP_SECRET'),
            'default_graph_version' => 'v2.6',
            'default_access_token' => $this->getAccessToken()
        ]);
    }
    
    public function getAccessToken()
    {
        return (isset($_SESSION['fb_access_token'])) ?
            (string) $_SESSION['fb_access_token'] : '';
    }
    
    public function getUserData($fields = 'id,name')
    {
        $accessToken = $this->getAccessToken();
        if (empty($accessToken))
        {
            return null;
        }
        
        try {
            // Returns a `Facebook\FacebookResponse` object
            $response = $this->_facebookClient->get('/me?fields=' . $fields, $accessToken)
            ->getBody();
            $data = json_decode($response, TRUE);

            return $data;
        } catch(Facebook\Exceptions\FacebookResponseException $e) {
            return null;
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
            return null;
        }
    }
}
