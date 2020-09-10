<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class NotificationController extends Controller
{
    public function saveToken(Request $request)
    {
        $userId = $request->user()->id;
        $token = array_get($request, 'token');

        $notification = Notification::updateOrCreate([
            'user_id' => $userId,
            'token' => $token,
        ], [
            'user_id' => $userId,
            'token' => $token,
        ]);
        return $notification;
    }

    public function sendNotification()
    {
        $curl = curl_init();
        $token = "c1wpaVg_c80O02X0oQ948W:APA91bHkgsBMNsmaeRXa98Iony8Jy_8ISAOE0gtG3LxNMs1A4F5EG8jb5h9SxZ5otTBW9YMApDtyBMDNurh3sUKOBjgddNmgDQkUbbc9OtUiWso-Zn8cy9JgruJuWthUVVPevJoCnbmu";
        $content = "Coconut: Dừa - nhiều nước, rất ngọt";
        $title = "Từ mới hôm nay:";
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://fcm.googleapis.com/fcm/send",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "{\n\"to\":\"$token\",\n \"notification\" : {\n  \"sound\" : \"default\",\n  \"body\" :  \"$content\",\n  \"title\" : \"$title\",\n  \"content_available\" : true,\n  \"priority\" : \"high\",\n },\n \"data\" : {\n  \"sound\" : \"default\",\n  \"body\" :  \"test body\",\n  \"title\" : \"test title\",\n  \"content_available\" : true,\n  \"priority\" : \"high\",\n }\n}",
            CURLOPT_HTTPHEADER => array(
                "authorization: key=".env('FIREBASE_PUSH_KEY'),
                "cache-control: no-cache",
                "content-type: application/json",
                // "postman-token: f5de4dbc-5394-7798-ef04-3f51ba36e46f",
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            echo $response;
        }
    }

}
