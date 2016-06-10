<?php

namespace App\Services\Drawing;

class ImageFilterService
{
    public function renderFilteredImage($imagePath, $filterPath)
    {
        //----------------------------------------------------------
        //  Load the actual picture
        //----------------------------------------------------------
        $imageSize           = getimagesize($imagePath);
        $imageResource       = NULL;
         
        switch ($imageSize['mime'])
        {
            case "image/png":
                $imageResource = imagecreatefrompng($imagePath);
                break;
            case "image/jpg":
            case "image/jpeg":
                $imageResource = imagecreatefromjpeg($imagePath);
                break;
            default:
                throw new \Exception("Invalid image format.");
        }
        
        //----------------------------------------------------------
        //  Load the filter
        //----------------------------------------------------------
        
        $filterResource = imagecreatefrompng($filterPath);
        
        //----------------------------------------------------------
        //  Fetch the images sizes
        //----------------------------------------------------------
        $pictureSize    = ['w' => $imageSize[0], 'h' => $imageSize[1]];
        $filterSize     = ['w' => imagesx($filterResource), 'h' => imagesy($filterResource)];

        //----------------------------------------------------------
        //  Resize the flag resource to match the picture
        //----------------------------------------------------------
        
        $filterResource = $this->resizeImage($filterResource, $filterSize, $pictureSize);
        
        //----------------------------------------------------------
        //  Apply the filter
        //----------------------------------------------------------
        
        $imageResource = $this->applyFilter($imageResource, $filterResource,
            $pictureSize, $filterSize);

        //----------------------------------------------------------
        //  Add watermark
        //----------------------------------------------------------
        
        $imageResource = $this->writeText($imageResource, $pictureSize, '#AniBeIsrael');
        
        //----------------------------------------------------------
        //  Draw it!
        //----------------------------------------------------------
        header("Content-Type: image/png");
        imagepng($imageResource);
        imagedestroy($filterResource);
        imagedestroy($imageResource);
    }
    
    public function saveFilteredImage($imagePath, $filterPath, $destinationFilePath)
    {
        //----------------------------------------------------------
        //  Load the actual picture
        //----------------------------------------------------------
        $imageSize           = getimagesize($imagePath);
        $imageResource       = NULL;
         
        switch ($imageSize['mime'])
        {
            case "image/png":
                $imageResource = imagecreatefrompng($imagePath);
                break;
            case "image/jpg":
            case "image/jpeg":
                $imageResource = imagecreatefromjpeg($imagePath);
                break;
            default:
                throw new \Exception("Invalid image format.");
        }
    
        //----------------------------------------------------------
        //  Load the filter
        //----------------------------------------------------------
    
        $filterResource = imagecreatefrompng($filterPath);
    
        //----------------------------------------------------------
        //  Fetch the images sizes
        //----------------------------------------------------------
        $pictureSize    = ['w' => $imageSize[0], 'h' => $imageSize[1]];
        $filterSize     = ['w' => imagesx($filterResource), 'h' => imagesy($filterResource)];
    
        //----------------------------------------------------------
        //  Resize the flag resource to match the picture
        //----------------------------------------------------------
    
        $filterResource = $this->resizeImage($filterResource, $filterSize, $pictureSize);
    
        //----------------------------------------------------------
        //  Apply the filter
        //----------------------------------------------------------
    
        $imageResource = $this->applyFilter($imageResource, $filterResource,
            $pictureSize, $filterSize);
        
        //----------------------------------------------------------
        //  Add watermark
        //----------------------------------------------------------
        
        $imageResource = $this->writeText($imageResource, $pictureSize, '#AniBeIsrael');
        
        //----------------------------------------------------------
        //  Draw it!
        //----------------------------------------------------------
        imagepng($imageResource, $destinationFilePath);
        imagedestroy($filterResource);
        imagedestroy($imageResource);
        
        return $destinationFilePath;
    }
    
    public function resizeImage($imageResource, $sourceSize, $destinationSize)
    {
        $newImage = imagecreatetruecolor($destinationSize['w'], $destinationSize['h']);
        imagecopyresized($newImage, $imageResource, 0, 0, 0, 0, 
            $destinationSize['w'], $destinationSize['h'],
            $sourceSize['w'], $sourceSize['h']);
        imagedestroy($imageResource);
        return $newImage;
    }
    
    public function applyFilter($imageResource, $filterResource, $imageSize, $filterSize)
    {
        //----------------------------------------------------------
        //  Enable the alpha blending
        //----------------------------------------------------------
        
        imagealphablending($imageResource, true);
        imagealphablending($filterResource, true);
        
        $this->filterOpacity($filterResource, 35);
        
        //----------------------------------------------------------
        //  Draw the filter on the top of the image resoucre
        //----------------------------------------------------------
        
        imagecopyresampled($imageResource, $filterResource,
            0, 0,
            0, 0,
            $imageSize['w'], $imageSize['h'],
            $imageSize['w'], $imageSize['h']);
        
        return $imageResource;
    }
    
    public function filterOpacity(&$img, $opacity) //params: image resource id, opacity in percentage (eg. 80)
    {
        if (!isset($opacity))
        {
            return false;
        }
    
        $opacity /= 100;
    
        // get image width and height
        $w = imagesx($img);
        $h = imagesy($img);
    
        // turn alpha blending off
        imagealphablending($img, false);
    
        // find the most opaque pixel in the image (the one with the smallest alpha value)
        $minalpha = 127;
        for ($x = 0; $x < $w; $x++)
        {
            for ($y = 0; $y < $h; $y++)
            {
                $alpha = (imagecolorat($img, $x, $y) >> 24) & 0xFF;
                if ($alpha < $minalpha)
                {
                    $minalpha = $alpha;
                }
            }
        }
        
        // loop through image pixels and modify alpha for each
        for ($x = 0; $x < $w; $x++)
        {
            for ($y = 0; $y < $h; $y++)
            {
    
                // get current alpha value (represents the TANSPARENCY!)
                $colorxy = imagecolorat($img, $x, $y);
                $alpha = ($colorxy >> 24) & 0xFF;
    
                // calculate new alpha
                if ($minalpha !== 127)
                {
                    $alpha = 127 + 127 * $opacity * ($alpha - 127) / (127 - $minalpha);
                }
                else
                {
                    $alpha+= 127 * $opacity;
                }
    
                // get the color index with new alpha
                $alphacolorxy = imagecolorallocatealpha($img, ($colorxy >> 16) & 0xFF, ($colorxy >> 8) & 0xFF, $colorxy & 0xFF, $alpha);
    
                // set pixel with the new color + opacity
    
                if (!imagesetpixel($img, $x, $y, $alphacolorxy))
                {
                    return false;
                }
            }
        }
    
        return true;
    }

    public function writeText($imageResource, $imageSize, $text)
    {
        //----------------------------------------------------------
        //  Settings
        //----------------------------------------------------------
        $margin         = 15;
        $textSize       = 30;
        
        //----------------------------------------------------------
        //  Setup
        //----------------------------------------------------------
        $fontPath       = storage_path('app/OpenSans-Light.ttf');
        $black          = imagecolorallocate($imageResource, 0, 0, 0);
        
        //----------------------------------------------------------
        //  Get the text size
        //----------------------------------------------------------
        $bbox           = imagettfbbox($textSize, 0, $fontPath, $text);
        //$textWidth      = abs($bbox[4] - $bbox[0]);
        $textHeight     = abs($bbox[5] - $bbox[1]);
        
        //----------------------------------------------------------
        //  Write
        //----------------------------------------------------------
        imagettftext($imageResource,
            $textSize,
            0,
            $margin,
            $imageSize['h'] - $textHeight,
            $black,
            $fontPath,
            $text);
        
        //imagettftext($im, 20, 0, 10, 20, $black, $font, $text);
        
        return $imageResource;
    }
}