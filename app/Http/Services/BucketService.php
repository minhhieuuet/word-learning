<?php

namespace App\Http\Services;

use App\Models\Bucket;
use App\Models\Category;

class BucketService
{
    public function initBucketUser($userId)
    {
        $newBucket = Bucket::create([
            'user_id' => $userId,
        ]);

        Category::create([
            'title' => 'Phrase',
            'bucket_id' => $newBucket->id,
            'is_visible' => false,
        ]);
        Category::create([
            'title' => 'Other',
            'bucket_id' => $newBucket->id,
            'cover' => '/images/other-category.png',
            'is_visible' => true,
        ]);
        // return Bucket::where('user_id', $userId)->first()->categories()->get();
    }

}
