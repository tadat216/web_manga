<?php

namespace App\Providers;

use App\Models\Genre;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
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

        View::composer('user.chapters.partials._last_read_chapters', function ($view) {
            $lastReadChapters = Auth::check() ? User::find(Auth::id())->getLastReadChapters() : collect([]);
            $view->with('lastReadChapters', $lastReadChapters);
        });

        View::composer('user.books.partials._suggested_books', function ($view) {
            $suggestedBooks = Auth::check() ? User::find(Auth::id())->getSuggestedBooks() : collect([]);
            $view->with('suggestedBooks', $suggestedBooks);
        });
    }
}
