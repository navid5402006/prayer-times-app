<?php

namespace App\Http\Middleware;

use Closure;
// use App\Services\TranslatorService;

class TranslateContent
{
    // protected $translator;

    // public function __construct(TranslatorService $translator)
    // {
    //     $this->translator = $translator;
    // }

    public function handle($request, Closure $next)
    {
        $response = $next($request);
        
        // $locale = app()->getLocale();
        // if (in_array($locale, ['ar', 'ur'])) {
        //     $content = $response->getContent();
        //     $translated = $this->translateContent($content, $locale);
        //     $response->setContent($translated);
        // }

        return $response;
    }

    protected function translateContent($content, $locale)
    {
        // Translation temporarily disabled for performance
        return $content;

        /*
        $pattern = '/<translate>(.*?)<\/translate>/';
        return preg_replace_callback($pattern, function($matches) use ($locale) {
            return $this->translator->translate($matches[1], $locale);
        }, $content);
        */
    }
}
