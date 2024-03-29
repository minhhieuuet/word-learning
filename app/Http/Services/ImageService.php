<?php

namespace App\Http\Services;

use App\User;
use App\Models\Category;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ImageService
{
    public function storeImageToFolder($request, $folder) {
        if(!$request->file('file')) {
            return '';
        }
        $image = $request->file('file');
        $fileName   = time() . '.' . $image->getClientOriginalExtension();
        $image->storeAs("public/$folder", $fileName);
        return env('APP_URL')."/storage/$folder/$fileName";
    }

    public function saveImageFromUrl($url) {
        $img = "external_images/".time() . '.jpg';
        if(!strpos(substr($url, strrpos($url, '/') + 1), '.')){
            $img = $img.'.jpg';
        }  
        // Function to write image into file 
        file_put_contents($img, file_get_contents($url));
        $contents = file_get_contents($url);
        return  env('APP_URL').'/'.$img;
    }
}