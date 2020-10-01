<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bucket;
use App\Models\Category;
use App\Models\Word;
use Carbon\Carbon;

class StatisticController extends Controller
{
    public function getNewWordStatisticsByWeek(Request $request) {
        $userId = $request->user()->id;
        $bucketId = Bucket::where('user_id', $userId)->first()->id;
        $now = Carbon::now();
        $startWeek = Carbon::now()->startOfWeek();
        $endWeek = Carbon::now()->endOfWeek()->addDays(1);
        $dateArr = [];

        do {
            array_push($dateArr, $startWeek->format('Y-m-d'));
            $startWeek = $startWeek->addDays(1);
        }
        while($startWeek->format('Y-m-d') != $endWeek->format('Y-m-d'));

        $words = Category::where(['bucket_id' => $bucketId])->get()->map(function($category) {
            return $category->words()->get();
        })->flatten()->filter(function ($value) { return !is_null($value); });
        $arr = collect($dateArr)->map(function($date) use ($words) {
            return $words->filter(function($word) use ($date) {
                return Carbon::parse($word->created_at)->format('Y-m-d') == $date;
            })->count();
        });
        return $arr;
    }

    public function getStatistics(Request $request) {
        $userId = $request->user()->id;
        $bucketId = Bucket::where('user_id', $userId)->first()->id;

        $totalCategory = Category::where('bucket_id', $bucketId)->count();
        $totalSharingCategory = Category::where(['bucket_id' => $bucketId, 'is_public' => 1])->count();
        $totalClone = Category::where(['bucket_id' => $bucketId])->sum('download_time');
        
        $words = Category::where(['bucket_id' => $bucketId])->get()->map(function($category) {
            return $category->words()->get();
        })->flatten();
        $totalWord = $words->count();
        $totalDoneWord = $words->filter(function($word) {
            return $word->priority <= -5;
        })->count();
        $totalLearningWord = $words->filter(function($word) {
            return $word->priority > -5 && $word->priority < 0;
        })->count();
        $totalNewWord = $words->filter(function($word) {
            return $word->priority >= 0;
        })->count();

        return [
            'total_word' => $totalWord,
            'total_category' => $totalCategory,
            'total_sharing_category' => $totalSharingCategory,
            'download_time' => $totalClone,
            'word_count' => [
                'done' => $totalDoneWord,
                'learning' => $totalLearningWord,
                'new' => $totalNewWord
            ] 
        ];
    }


}
