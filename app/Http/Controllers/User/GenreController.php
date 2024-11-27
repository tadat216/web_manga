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

    public function show($id) 
    {
        $genre = Genre::findOrFail($id);
        $books = $genre->books()->where('is_active', 1)->with('chapters')->withCount('chapters')->paginate(12);
        return view('user.genres.show', compact('genre', 'books'));
    }
}
