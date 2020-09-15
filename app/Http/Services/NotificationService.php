<?php

namespace App\Http\Services;

use App\Models\Bucket;
use App\Models\Notification;
use App\Models\Category;
use Carbon\Carbon;
use App\Models\Word;

class NotificationService
{
    public function sendNotification($userId)
    {
        $curl = curl_init();
        $tokens = Notification::where('user_id', $userId)->pluck('token');

        $bucketId = Bucket::where('user_id', $userId)->first()->id;

        $categories = Category::where('bucket_id', $bucketId)->get();

        $word = $categories->map(function ($category) {
            return Word::where('category_id', $category->id)->inRandomOrder()->get();
        })->flatten()->shuffle()->first();
        
        $now = Carbon::now()->setTimezone('Asia/Ho_Chi_Minh');

        \Log::alert("$now :========= Send notification to user $userId ===".$word);
        // return $word;

        foreach ($tokens as $token) {
            $content = "$word->meaning".($word->hint ? " - $word->hint": "");
            $title = ucfirst($word->word);
            $image = $word['image'];
            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://fcm.googleapis.com/fcm/send",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => "{\n\"to\":\"$token\",\n \"notification\" : {\n  \"sound\" : \"default\",\n  \"image\" : \"$image\", \n  \"body\" :  \"$content\",\n  \"title\" : \"$title\",\n  \"icon\" : \"https://hoctumoi.tk/favicon.png\",\n  \"content_available\" : true,\n  \"priority\" : \"high\",\n },\n \"data\" : {\n  \"sound\" : \"default\",\n  \"body\" :  \"test body\",\n  \"title\" : \"test title\",\n  \"content_available\" : true,\n  \"priority\" : \"high\",\n }\n}",
                CURLOPT_HTTPHEADER => array(
                    "authorization: key=" . env('FIREBASE_PUSH_KEY'),
                    "cache-control: no-cache",
                    "content-type: application/json",
                    // "postman-token: f5de4dbc-5394-7798-ef04-3f51ba36e46f",
                ),
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);

            if ($err) {
                echo "cURL Error #:" . $err;
            } else {
                echo $response;
            }
        }
        curl_close($curl);
    }

}
