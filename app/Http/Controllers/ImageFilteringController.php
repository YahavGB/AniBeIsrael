<?php

namespace App\Http\Controllers;

use Facebook\Facebook;
use Illuminate\Http\Request;

class ImageFilteringController extends Controller
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
    
    public function createFilteredImage()
    {
        $userData = $this->getUserData('id');
        if ($userData === NULL)
        {
            abort(404);
        }
    
    
        $filePath = storage_path('app/filtered-images/' . md5($userData['id']) . '.png');
        if (file_exists($filePath))
        {
            unlink($filePath);
        }
    
        try
        {
            //$query = 'SELECT url, real_width, real_height FROM profile_pic WHERE id=' . $userData['id'];
            //$this->_facebookClient->
            $profilePicture = $this->_facebookClient->get('/' . $userData['id'] . '/picture?width=9999&redirect=false', $this->getAccessToken())
            ->getBody();
    
            $profilePictureData = json_decode($profilePicture, true);
            $pictureUrl = '';
            $flagPath = storage_path('app/image-resources/israel-flag.png');
    
            app(\App\Services\Drawing\ImageFilterService::class)->saveFilteredImage(
                $profilePictureData['data']['url'],
                $flagPath,
                $filePath);
        }
        catch (\Exception $e)
        {
            return response(json_encode([ 'success' => false, 'message' => $e->getMessage() ]));
        }
    
        return response(json_encode([ 'success' => true, 'path' => url('/image-filter/render') ]));
    }
    
    public function renderFilteredImage()
    {
        $userData = $this->getUserData('id');
        if ($userData === NULL)
        {
            abort(404);
        }
    
    
        $filePath = storage_path('app/filtered-images/' . md5($userData['id']) . '.png');
        if (!file_exists($filePath))
        {
            abort(404);
        }
    
        header('Content-Type: image/png');
        print file_get_contents($filePath);
    }

    public function downloadFilteredImage()
    {
        $userData = $this->getUserData('id');
        if ($userData === NULL)
        {
            abort(404);
        }
    
    
        $filePath = storage_path('app/filtered-images/' . md5($userData['id']) . '.png');
        if (!file_exists($filePath))
        {
            abort(404);
        }
        
        return response()->download($filePath, 'profile-picture.png', [
        ]);
        
    
        header('Content-Type: image/png');
        print file_get_contents($filePath);
    }
    
}