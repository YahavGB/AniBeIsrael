<?php

namespace App\Http\Controllers;

use Facebook\Facebook;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function index(Request $request)
    {
        $loginHelper = $this->_facebookClient->getRedirectLoginHelper();
        $userData    = $this->getUserData();
        if ($userData !== NULL)
        {
            return view('welcome', [
                'userData' => $userData,
                'facebookLogoutUrl' => $loginHelper->getLogoutUrl($this->getAccessToken(), url('/') . '/')
            ]);
        }
        
        $loginUrl    = $loginHelper->getLoginUrl(url('/authorization/resolve'), 
            explode(',', env('FACEBOOK_APP_PERMISSIONS'))
            );
        
        return view('welcome', [ 'facebookLoginUrl' => $loginUrl ]);
    }
}
