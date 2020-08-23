<?php

namespace App\Http\Services;

use App\User;
use App\Models\Category;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\Word;
class CategoryService
{
    public function getCategories($params)
    {
        $limit = array_get($params, 'limit', 10);
        return Category::when(!empty(array_get($params, 'search')), function ($query) use ($params) {
            $search = array_get($params, 'search');
            return $query->where('title', 'like', "%$search%");
        })->orderBy('created_at', 'desc')->paginate($limit);
    }

    public function getAllWordsByCategory($categoryId) {
        return Word::where('category_id', $categoryId)->get();
    }

    public function storeCategory($params)
    {
        $category = Category::create([
            'title' => array_get($params, 'title'),
            'cover' => array_get($params, 'cover'),
            'is_visible' => array_get($params, 'is_visible'),
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
        if(array_get($params, 'passcategory')) {
          $category->update(['passcategory' => bcrypt(array_get($params, 'passcategory'))]);
        }
        return $category;
    }

    public function getOneCategory(Category $category)
    {
        return $category;
    }

    public function deleteOneCategory(User $category)
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
