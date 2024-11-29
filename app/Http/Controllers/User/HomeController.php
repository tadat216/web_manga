<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Book;
use App\Models\BookUser;
use App\Models\User;

class HomeController extends Controller
{
    public function index()
    {
        $savedBoks = collect();
        $continueBooks = collect();
        
        if(Auth::check()){
            $user = User::with([
                'books' => function($query) {
                    $query->with(['chapters' => function($q) {
                        $q->select('id', 'book_id', 'title', 'chapter_number');
                    }]);
                    $query->with(['genres' => function($q) {
                        $q->select('genres.id', 'title'); 
                    }]);
                    $query->select('books.id', 'title', 'author_name', 'status', 'avatar_image', 'view_count');
                    $query->orderBy('book_user.updated_at', 'desc');
                }
            ])->find(Auth::id());

            $savedBoks = $user->books->where('pivot.is_saved', 1);
            $continueBooks = $user->books->where('pivot.is_read', 1);
        }
        return view('user.home.index', compact('savedBooks', 'continueBooks'));
    }
}
