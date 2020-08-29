<?php

namespace App\Http\Services;

use App\User;
use App\Models\Word;
use Illuminate\Support\Str;
use Carbon\Carbon;

class WordService
{
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

    public function getRandomWord() {
        return Word::inRandomOrder()->limit(8)->get();;
    }

    public function getAllPhrases() {
        return Word::where('category_id', 1)->get();
    }

    public function storeWord($params)
    {
        $word = Word::create([
            'category_id' => array_get($params, 'category_id'),
            'word' => array_get($params, 'word'),
            'hint' => array_get($params, 'hint'),
            'meaning' => array_get($params, 'meaning'),
            'image' => array_get($params, 'image'),
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
