<?php
namespace App\Http\Controllers;
use App\FileUpload;

use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function store(Request $request)
    {
       if($request->hasFile('file'))
       {
          $image = $request->file('file');
          $fileName   = time() . '.' . $image->getClientOriginalExtension();
          $image->storeAs('public/clients', $fileName);
          return $fileName;
        }

       return response()->json(['success' => 'You have successfully uploaded an image'], 200);
     }
}