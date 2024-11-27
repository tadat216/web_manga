<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $query = $genre->books()->where('is_active', 1)->with('chapters')->withCount('chapters');
        
        if (Auth::check()) {
            $query->with(['users' => function($q) {
                $q->where('user_id', Auth::id());
            }]);
        }
        
        $books = $query->paginate(12);
        return view('user.genres.show', compact('genre', 'books'));
    }
}
