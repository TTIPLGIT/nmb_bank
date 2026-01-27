<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use DateTime;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Models\Document;
use Illuminate\Support\Facades\Http;

class LanguageController extends Controller
{
    public function change($lang)
    {
        session(['locale' => $lang]);
        return redirect()->back();
    }

    function autoTranslate($text)
    {
        try {
            $target = app()->getLocale();

            if ($target == 'en') return $text;

                $url = "https://translation.googleapis.com/language/translate/v2?key=API_KEY";

            $response = Http::withoutVerifying()->post($url, [
                'q' => $text,
                'target' => $target
            ]);

            return $response['data']['translations'][0]['translatedText'] ?? $text;
        } catch (\Exception $e) {
            return $text; // fallback
        }
    }
}
