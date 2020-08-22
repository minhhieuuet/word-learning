<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Google\Cloud\Translate\V2\TranslateClient;
use Google\Cloud\TextToSpeech\V1\AudioConfig;
use Google\Cloud\TextToSpeech\V1\AudioEncoding;
use Google\Cloud\TextToSpeech\V1\SynthesisInput;
use Google\Cloud\TextToSpeech\V1\TextToSpeechClient;
use Google\Cloud\TextToSpeech\V1\VoiceSelectionParams;

class TranslatorController extends Controller
{
    public function translate(Request $request) {
        $text = array_get($request, 'text') ?? '';
        $translate = new TranslateClient([
            'key' => 'AIzaSyCoo8kiRxc_ulEBgitaJBnTmFB_DqIJ8bc'
        ]);
        
        // Translate text from english to french.
        $result = $translate->translate($text, [
            'target' => 'vi'
        ]);
        
        echo $result['text'] . "\n";
        
    }

    public function textToSpeech() {
        $textToSpeechClient = new TextToSpeechClient();
        $input = new SynthesisInput();
        $input->setText('Japan\'s national soccer team won against Colombia!');
        $voice = new VoiceSelectionParams();
        $voice->setLanguageCode('en-US');
        $audioConfig = new AudioConfig();
        $audioConfig->setAudioEncoding(AudioEncoding::MP3);

        $resp = $textToSpeechClient->synthesizeSpeech($input, $voice, $audioConfig);
        file_put_contents('test.mp3', $resp->getAudioContent());
    }
}
