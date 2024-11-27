<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Genre;

class BookController extends Controller
{
    /**
     * Hiển thị danh sách sách
     */
    public function index()
    {
        $books = Book::paginate(10);
        return view('admin.books.index', compact('books'));
    }

    /**
     * Hiển thị form thêm sách
     */
    public function create()
    {
        $genres = Genre::all();
        return view('admin.books.create', compact('genres'));
    }

    /**
     * Lưu sách mới
     */
    public function store(Request $request)
    {
        // Validate dữ liệu sách
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author_name' => 'nullable|string|max:255', 
            'description' => 'nullable|string',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:incoming,ongoing,complete',
            'is_active' => 'boolean',
            'is_premium' => 'boolean',
            'genres' => 'nullable|string',
            'chapters' => 'nullable|array',
            'chapters.*.title' => 'required|string|max:255',
            'chapters.*.description' => 'nullable|string',
            'chapters.*.content' => 'nullable|string', 
            'chapters.*.chapter_number' => 'required|integer',
        ]);

        // Xử lý upload ảnh bìa
        if ($request->hasFile('cover')) {
            $coverPath = $request->file('cover')->store('books/covers', 'public');
            $validated['cover'] = $coverPath;
        }

        // Xử lý upload avatar
        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('books/avatars', 'public');
            $validated['avatar'] = $avatarPath;
        }

        // Tạo sách mới
        $book = Book::create([
            'title' => $validated['title'],
            'author_name' => $validated['author_name'],
            'description' => $validated['description'],
            'cover' => $validated['cover'] ?? null,
            'avatar' => $validated['avatar'] ?? null,
            'status' => $validated['status'],
            'is_active' => $validated['is_active'],
            'is_premium' => $validated['is_premium'],
        ]);

        // Xử lý thể loại
        if (!empty($validated['genres'])) {
            $genreIds = explode(',', $validated['genres']);
            $book->genres()->attach($genreIds);
        }

        // Xử lý chapters
        if (!empty($validated['chapters'])) {
            foreach ($validated['chapters'] as $chapterData) {
                $book->chapters()->create([
                    'title' => $chapterData['title'],
                    'description' => $chapterData['description'] ?? null,
                    'content' => $chapterData['content'] ?? null,
                    'chapter_number' => $chapterData['chapter_number'],
                ]);
            }
        }

        return redirect()
            ->route('admin.books')
            ->with('success', 'Sách đã được tạo thành công.');
    }

    /**
     * Hiển thị chi tiết sách
     */
    public function show($id)
    {
        $book = Book::findOrFail($id);
        return view('admin.books.show', compact('book'));
    }

    /**
     * Hiển thị form chỉnh sửa sách
     */
    public function edit($id)
    {
        $book = Book::with('chapters')->findOrFail($id);
        $genres = Genre::all();
        return view('admin.books.edit', compact('book', 'genres'));
    }

    /**
     * Cập nhật thông tin sách
     */
    public function update(Request $request, $id)
    {
        $book = Book::findOrFail($id);

        // Validate dữ liệu
        $request->validate([
            'title' => 'required|string|max:255',
            'author_name' => 'nullable|string|max:255', 
            'description' => 'nullable|string',
            'status' => 'required|in:incoming,ongoing,complete',
            'genres' => 'required|string',
            'chapters' => 'nullable|array',
            'chapters.*.title' => 'required|string|max:255',
            'chapters.*.description' => 'nullable|string',
            'chapters.*.content' => 'nullable|string',
            'chapters.*.chapter_number' => 'required|integer',
        ]);

        // Cập nhật thông tin cơ bản của sách
        $book->update([
            'title' => $request->title,
            'author_name' => $request->author_name,
            'description' => $request->description,
            'status' => $request->status,
            'is_active' => $request->boolean('is_active'),
            'is_premium' => $request->boolean('is_premium')
        ]);
        
        // Xử lý genres
        $genreIds = explode(',', $request->genres);
        $book->genres()->sync($genreIds);
        
        // Xử lý media
        if ($request->hasFile('cover')) {
            $book->clearMediaCollection('cover');
            $book->addMedia($request->file('cover'))
                ->toMediaCollection('cover');
        }

        if ($request->hasFile('avatar')) {
            $book->clearMediaCollection('avatar');
            $book->addMedia($request->file('avatar'))
                ->toMediaCollection('avatar');
        }

        // Xử lý chapters
        if ($request->has('chapters')) {
            // Lấy danh sách chapter_number hiện tại
            $existingChapterNumbers = $book->chapters->pluck('chapter_number')->toArray();
            $newChapterNumbers = collect($request->chapters)->pluck('chapter_number')->toArray();
            
            // Xóa các chapter không còn trong request
            $chaptersToDelete = array_diff($existingChapterNumbers, $newChapterNumbers);
            $book->chapters()->whereIn('chapter_number', $chaptersToDelete)->delete();

            // Cập nhật hoặc tạo mới chapters
            foreach ($request->chapters as $chapterData) {
                $book->chapters()->updateOrCreate(
                    ['chapter_number' => $chapterData['chapter_number']],
                    [
                        'title' => $chapterData['title'],
                        'description' => $chapterData['description'] ?? null,
                        'content' => $chapterData['content'] ?? null,
                    ]
                );
            }
        }

        return redirect()->route('admin.books')
            ->with('success', 'Cập nhật sách thành công');
    }

    /**
     * Xóa sách
     */
    public function destroy($id)
    {
        $book = Book::findOrFail($id);
        $book->delete();

        return redirect()->route('admin.books')
            ->with('success', 'Xóa sách thành công');
    }

    /**
     * Cập nhật trạng thái kích hoạt của sách
     */
    public function updateIsActive($id)
    {
        $book = Book::findOrFail($id);
        $book->update([
            'is_active' => !$book->is_active
        ]);
        
        return response()->json([
            'success' => true
        ]);
    }
}
