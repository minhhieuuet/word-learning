<?php

namespace App\Http\Services;

use App\User;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\Bucket;
use App\Models\Category;
class StudentService
{
    public function getStudents($params)
    {
        $limit = array_get($params, 'limit', 10);
        return User::where('role', 1)->when(!empty(array_get($params, 'search')), function ($query) use ($params) {
            $search = array_get($params, 'search');
            return $query->where('name', 'like', "%$search%")
                        ->orWhere('email', 'like', "%$search%")
                        ->orWhere('full_name', 'like', "%$search%");
        })->orderBy('created_at', 'desc')->paginate($limit);
    }

    public function storeStudent($params)
    {
        $student = User::create([
            'full_name' => array_get($params, 'full_name'),
            'name' => array_get($params, 'name'),
            'email' => array_get($params, 'email'),
            'password' => bcrypt(array_get($params, 'password')),
            'role' => 1
        ]);

        return $this->getOneStudent($student);
    }
    public function getStudentInfo($student) {
        $userId = $student->id;
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
    public function updateStudent(User $student, $params)
    {
        $student->update([
          'full_name' => array_get($params, 'full_name'),
          'name' => array_get($params, 'name'),
          'email' => array_get($params, 'email'),
        ]);
        if(array_get($params, 'password')) {
          $student->update(['password' => bcrypt(array_get($params, 'password'))]);
        }
        return $student;
    }

    public function getOneStudent(User $student)
    {
        $student->makeHidden('password');
        return $student;
    }

    public function deleteOneStudent(User $student)
    {
        $student->delete();

        return 'ok';
    }

    public function deleteManyStudent($params)
    {
        $studentIds = array_get($params, 'ids', []);
        if (count($studentIds) > 0) {
            User::whereIn('id', $studentIds)->delete();
        }
        return 'ok';
    }
}
