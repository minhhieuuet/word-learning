<?php

namespace App\Http\Services;

use App\User;
use App\Models\Category;

use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\Bucket;
use App\Models\Word;

class GameService
{
    public function getGame3Resource($categoryIds, $userId)
    {  
     
       $bucketId = Bucket::where('user_id', $userId)->first()->id;

       $categories = Category::where('bucket_id', $bucketId)
       ->whereIn('id', $categoryIds)->get();

       $words = $categories->map(function ($category) {
           return Word::where('category_id', $category->id)->inRandomOrder()->get();
       })->flatten()->shuffle()->take(8);

       return $words;
    }

    public function getGame2Resource($categoryIds, $userId)
    {  
     
       $bucketId = Bucket::where('user_id', $userId)->first()->id;

       $categories = Category::where('bucket_id', $bucketId)
       ->whereIn('id', $categoryIds)->get();

       $words = $categories->map(function ($category) {
           return Word::where('category_id', $category->id)->inRandomOrder()->get();
       })->flatten()->shuffle()->take(8);

       return $words;
    }

}
