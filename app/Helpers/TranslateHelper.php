<?php

use Illuminate\Support\Facades\Request;

if (!function_exists('translate')) {
    /**
     * Dummy translate function (no API, no cache)
     * Null-safe for Blade usage
     * 
     * @param string|null $text
     * @param string|null $targetLanguage
     * @param string|null $sourceLanguage
     * @return string
     */
    function translate(?string $text, ?string $targetLanguage = null, ?string $sourceLanguage = null): string
    {
        // If input is null, return empty string — prevents Blade errors
        if (!$text) {
            return '';
        }

        // Optional: Get target lang from URL (won't be used for now)
        $targetLanguage = $targetLanguage ?: Request::segment(1) ?: 'en';

        // Just return original text — no translation
        return $text;

        /*
        // Uncomment this later when enabling API
        $cacheKey = 'translation_' . md5($text . '_' . $targetLanguage);
        return Cache::remember($cacheKey, now()->addDays(30), function () use ($text, $targetLanguage, $sourceLanguage) {
            try {
                $translator = new GoogleTranslate();
                $translator->setTarget($targetLanguage);
                
                if ($sourceLanguage) {
                    $translator->setSource($sourceLanguage);
                }
                
                return $translator->translate($text);
            } catch (\Exception $e) {
                \Log::error("Translation failed: " . $e->getMessage());
                return $text;
            }
        });
        */
    }
}