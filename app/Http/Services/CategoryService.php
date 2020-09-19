<?php

namespace App\Http\Services;

use App\Models\Bucket;
use App\Models\Category;
use App\Models\Word;
use App\User;

class CategoryService
{
    public function getCategories($userId)
    {
        return Bucket::where('user_id', $userId)->first()->categories()->get();
    }

    public function shareCategory($userId, $categoryId)
    {
        $bucketId = Bucket::where('user_id', $userId)->first()->id;
        $category = Category::where(['id' => $categoryId, 'bucket_id' => $bucketId])->first();
        $category->is_public = !$category->is_public;
        $category->save();
        return $category;
    }

    private static function getUserByCategoryId($categoryId)
    {
        $bucketId = Category::find($categoryId)->bucket_id;
        $userId = Bucket::find($bucketId)->user_id;
        return User::find($userId);
    }

    public function getPublicCategories($userId, $searchKey)
    {
        return Category::when($searchKey, function ($query) use ($searchKey) {
            return $query->where('title', 'like', "%$searchKey%");
        })->get()->filter(function ($category) {
            return ($category->title != 'Phrase' && $category->is_public);
        })->map(function ($category) {
            $category->author = self::getUserByCategoryId($category->id)->name;
            return $category;
        })->toArray();
    }

    public function cloneCategory($userId, $categoryId)
    {
        $bucketId = Bucket::where('user_id', $userId)->first()->id;
        $category = Category::find($categoryId);
        //Clone category
        $cloneCategory = Category::create([
            'bucket_id' => $bucketId,
            'title' => $category->title,
            'cover' => $category->cover,
            'slug' => $category->slug . '-' . time(),
            'is_visible' => 1,
        ]);
        //Clone words
        $words = $category->words()->get();
        foreach ($words as $word) {
            Word::create([
                'category_id' => $cloneCategory->id,
                'word' => $word->word,
                'meaning' => $word->meaning,
                'hint' => $word->hint,
                'image' => $word->image,
                'is_important' => $word->is_important,
            ]);
        }
        return $words;
    }

    public function getAllWordsByCategory($categoryId)
    {
        return Word::where('category_id', $categoryId)->get();
    }

    public function getTotalWordByCategories($ids)
    {
        return Category::whereIn('id', $ids)->get()->reduce(function ($carry, $item) {
            return $carry + $item["total_word"];
        }, 0);
    }

    public function getIdBySlug($userId, $slug)
    {
        $bucketId = Bucket::where('user_id', $userId)->firstOrFail()->id;
        return Category::where([
            'bucket_id' => $bucketId,
            'slug' => $slug,
        ])->first()->id;
    }

    public function storeCategory($userId, $params)
    {
        $bucket = Bucket::where('user_id', $userId)->first();
        $category = Category::create([
            'title' => array_get($params, 'title'),
            'slug' => str_slug(array_get($params, 'title')),
            'cover' => array_get($params, 'cover'),
            'is_visible' => array_get($params, 'is_visible'),
            'bucket_id' => $bucket->id,
        ]);

        return $this->getOneCategory($category);
    }

    public function updateCategory(User $category, $params)
    {
        $category->update([
            'full_name' => array_get($params, 'full_name'),
            'name' => array_get($params, 'name'),
            'email' => array_get($params, 'email'),
        ]);
        if (array_get($params, 'passcategory')) {
            $category->update(['passcategory' => bcrypt(array_get($params, 'passcategory'))]);
        }
        return $category;
    }

    public function getOneCategory(Category $category)
    {
        return $category;
    }

    public function deleteOneCategory(Category $category)
    {
        $category->delete();

        return 'ok';
    }

    public function deleteManyCategory($params)
    {
        $categoryIds = array_get($params, 'ids', []);
        if (count($categoryIds) > 0) {
            User::whereIn('id', $categoryIds)->delete();
        }
        return 'ok';
    }
}
