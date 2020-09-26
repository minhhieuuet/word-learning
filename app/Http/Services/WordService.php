<?php

namespace App\Http\Services;

use App\User;
use App\Models\Word;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\Bucket;
use App\Http\Services\ImageService;
use Storage;

class WordService
{
    protected $imageService;

    public function __construct(ImageService $imageService) {
        $this->imageService = $imageService;
    }
    
    public function getAllWords($userId, $params) {
        $bucket = Bucket::where('user_id', $userId)->first();
        $categories = $bucket->categories()->get();
        return $categories->map(function($category) {
            return $category->words()->get()->map(function($word) use ($category) {
                $word->category = $category;
                return $word;
            });
        })->flatten();
    }

    public function getWords($params)
    {
        $limit = array_get($params, 'limit', 10);
        return Word::where('role', 1)->when(!empty(array_get($params, 'search')), function ($query) use ($params) {
            $search = array_get($params, 'search');
            return $query->where('name', 'like', "%$search%")
                        ->orWhere('email', 'like', "%$search%")
                        ->orWhere('full_name', 'like', "%$search%");
        })->orderBy('created_at', 'desc')->paginate($limit);
    }

    public function quickStore($userId, $params) {
        $categories = array_get($params, 'categories');
        $externalImage = array_get($params, 'external_image');
        if($externalImage) {
            $imageUrl = $this->imageService->saveImageFromUrl($externalImage);
        } else {
            $imageUrl = array_get($params, 'image');
        }
        
        foreach($categories as $category) {
            Word::create([
                'category_id' => array_get($category, 'id'),
                'word' => array_get($params, 'word'),
                'hint' => array_get($params, 'hint'),
                'meaning' => array_get($params, 'meaning'),
                'image' => $imageUrl,
                'is_important' => array_get($params, 'is_important')
            ]);
        }
    }
    public function increasePriority($ids) {
        foreach($ids as $id) {
            $word = Word::find($id);
            $word->priority ++;
            $word->update();
        }
    }

    public function decreasePriority($ids) {
        foreach($ids as $id) {
            $word = Word::find($id);
            $word->priority --;
            $word->update();
        }
    }

    public function getYoutubeVideos($word) {
        return file_get_contents("https://api.tracau.vn/WBBcwnwQpV89/trans/$word");
    }

    public function getRandomWord() {
        return Word::inRandomOrder()->limit(8)->get();;
    }

    public function getAllPhrases($userId) {
        $phraseId = Bucket::where('user_id', $userId)->first()->categories()->where('title', 'Phrase')->first()->id;
        return [
            'id' => $phraseId,
            'data' => Word::where('category_id', $phraseId)->get()
        ];
    }

    public function updateImage(Word $word, $imageUrl) {
        $word->update([
            'image' => $imageUrl
        ]);
        return $word;
    }

    public function changeImportant(Word $word) {
        $word->update([
            'is_important' => !$word->is_important
        ]);
        return $word;
    }

    public function storeWord($params)
    {   
        $externalImage = array_get($params, 'external_image');
        $categoryId = array_get($params, 'category_id');
        $word = array_get($params, 'word');

        if(Word::where(['category_id' => $categoryId, 'word' => $word])->count()) {
            return response([
                "message" => "The given data was invalid.",
                "errors" => [
                    "word" => ["$word đã tồn tại trong danh mục, vui lòng chọn từ khác"]
                ]
            ], 422);
        }

        if($externalImage) {
            $imageUrl = $this->imageService->saveImageFromUrl($externalImage);
        } else {
            $imageUrl = array_get($params, 'image');
        }
        $word = Word::create([
            'category_id' => $categoryId,
            'word' => $word,
            'hint' => array_get($params, 'hint'),
            'meaning' => array_get($params, 'meaning'),
            'image' => $imageUrl,
            'is_important' => array_get($params, 'is_important')
        ]);

        return $this->getOneWord($word);
    }

    public function updateWord(Word $word, $params)
    {
        $word->update([
          'meaning' => array_get($params, 'meaning'),
          'hint' => array_get($params, 'hint'),
        ]);
        return $word;
    }

    public function getOneWord(Word $word)
    {
        return $word;
    }

    public function deleteOneWord(Word $word)
    {
        $word->delete();

        return 'ok';
    }

    public function deleteManyWord($params)
    {
        $wordIds = array_get($params, 'ids', []);
        if (count($wordIds) > 0) {
            User::whereIn('id', $wordIds)->delete();
        }
        return 'ok';
    }
}
