<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    public function index()
    {
        $genres = Genre::all();
        return view('genres.index', compact('genres'));
    }

    public function show($slug) 
    {
        $genre = Genre::where('slug', $slug)->firstOrFail();
        $stories = $genre->stories()->paginate(12);
        return view('genres.show', compact('genre', 'stories'));
    }
}
