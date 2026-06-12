<?php

namespace App\Http\Controllers;

use Stichoza\GoogleTranslate\GoogleTranslate;
use Illuminate\Support\Facades\Cache;

class TranslationController extends Controller
{
public function test()
{
    $original = "Cache translations to avoid repeated API calls for the same text.";
    $cacheKey = 'translation_' . md5($original . '_ar'); // Unique cache key
    
    $translated = Cache::remember($cacheKey, now()->addDays(30), function () use ($original) {
        $translator = new GoogleTranslate();
        $translator->setTarget('ar');
        return $translator->translate($original);
    });
dd($translated,$original);
    return response()->json([
        'original' => $original,
        'translated' => $translated,
    ]);
}
}