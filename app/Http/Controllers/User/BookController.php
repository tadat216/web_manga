<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\BookUser;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    //code hàm show truyện để hiển thị trang truyện cùng chương của truyện
    public function show($id)
    {
        $book = Book::find($id);
        $chapters = $book->chapters()->paginate(6);
        $bookUser = null;
        
        if (Auth::check()) {
            $bookUser = BookUser::where('user_id', Auth::id())
                               ->where('book_id', $id)
                               ->first() ?? null;
        }

        return view('user.books.show', compact('book', 'chapters', 'bookUser'));
    }
}
