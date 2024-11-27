<?php

namespace App\Providers;

use App\Models\Genre;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class ViewServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        View::composer('layouts.app', function ($view) {
            $genres = Genre::all();
            $view->with('genres', $genres);
        });
    }
}