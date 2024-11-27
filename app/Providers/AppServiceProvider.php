<?php

namespace App\Providers;

use App\Models\Genre;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('layouts.app', function ($view) {
            $genres = Genre::all();
            $view->with('genres', $genres);
        });

        View::composer('partials.last_read_chapters', function ($view) {
            $lastReadChapters = auth()->user()->lastReadChapters ?? []; // Lấy từ model hoặc logic của bạn
            $view->with('lastReadChapters', $lastReadChapters);
        });
    }
}
