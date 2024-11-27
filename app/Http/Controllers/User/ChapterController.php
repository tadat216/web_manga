<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Chapter;
use App\Models\BookUser;
use Illuminate\Support\Facades\Auth;

class ChapterController extends Controller
{
    //
    public function show($id, $chapter_id)
    {
        $chapter = Chapter::findOrFail($chapter_id);
        $book = $chapter->book;
        
        // Lấy tất cả các chương của truyện này
        $chapters = $book->chapters;
        
        // Tìm chương trước và sau
        $prevChapter = null;
        $nextChapter = null;
        
        foreach($chapters as $key => $c) {
            if($c->id == $chapter->id) {
                if($key > 0) {
                    $prevChapter = $chapters[$key - 1];
                }
                if($key < count($chapters) - 1) {
                    $nextChapter = $chapters[$key + 1]; 
                }
                break;
            }
        }

        // Cập nhật thông tin đọc sách của người dùng
        if (Auth::check()) {
            BookUser::updateOrCreate(
                [
                    'user_id' => Auth::id(),
                    'book_id' => $book->id,
                    
                ],
                ['chapter_id' => $chapter_id, 'is_read' => true]
            );
        }

        return view('user.chapters.show', compact(
            'chapter',
            'book', 
            'chapters',
            'prevChapter',
            'nextChapter'
        ));
    }
}
