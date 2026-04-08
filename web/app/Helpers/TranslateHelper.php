<?php

use Illuminate\Support\Facades\Http;

if (!function_exists('autoTranslate')) {
    function autoTranslate($text)
    {
        $target = app()->getLocale();

        // Replace with your API KEY
        $url = "https://translation.googleapis.com/language/translate/v2?key=API_KEY";

        $response = Http::post($url, [
            'q' => $text,
            'target' => $target
        ]);

        return $response['data']['translations'][0]['translatedText'] ?? $text;
    }
}
