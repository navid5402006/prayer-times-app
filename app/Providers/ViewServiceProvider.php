<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $firstSegment = request()->segment(1);
            $isLanguage = (strlen($firstSegment) == 2);
            $view->with('lang', $isLanguage ? $firstSegment : null);
            
        });
    }
}