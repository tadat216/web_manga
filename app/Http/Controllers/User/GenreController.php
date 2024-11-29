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
        $genre = Genre::with(['books' => function($query) {
            $query->where('is_active', 1)
                  ->with('chapters')
                  ->withCount('chapters')
                  ->when(Auth::check(), function($q) {
                      $q->with(['users' => function($userQuery) {
                          $userQuery->where('user_id', Auth::id());
                      }]);
                  });
        }])->findOrFail($id);

        $books = $genre->books()->paginate(12);
        return view('user.genres.show', compact('genre', 'books'));
    }

    public function search(Request $request, $id)
    {
        $genre = Genre::findOrFail($id);
        $query = $genre->books()->where('is_active', 1);

        // Tìm kiếm theo từ khóa (tên truyện hoặc tác giả)
        if ($keyword = $request->input('keyword')) {
            $query->where(function($q) use ($keyword) {
                $q->where('title', 'like', "%{$keyword}%")
                  ->orWhere('description', 'like', "%{$keyword}%");
            });
        }

        // Tìm kiếm theo tác giả
        if ($authorName = $request->input('author')) {
            $query->where('author_name', 'like', "%{$authorName}%");
        }

        // Tìm kiếm theo trạng thái
        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        // Thêm các quan hệ và đếm số chương
        $query->with('chapters')->withCount('chapters');

        // Thêm thông tin người dùng nếu đã đăng nhập
        if (Auth::check()) {
            $query->with(['users' => function($q) {
                $q->where('user_id', Auth::id());
            }]);
        }

        $books = $query->paginate(12);
        
        return view('user.genres.show', compact('genre', 'books', 'keyword', 'authorName', 'status'));
    }
}
