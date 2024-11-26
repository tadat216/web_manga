<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;

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
        return view('admin.books.create');
    }

    /**
     * Lưu sách mới
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255|unique:books',
            'description' => 'nullable|string',
            'status' => 'required|in:incoming,ongoing,compelete'
        ]);

        Book::create([
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
            'is_active' => $request->is_active,
        ]);

        return redirect()->route('admin.books')
            ->with('success', 'Thêm sách thành công');
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
        $book = Book::findOrFail($id);
        return view('admin.books.edit', compact('book'));
    }

    /**
     * Cập nhật thông tin sách
     */
    public function update(Request $request, $id)
    {
        $book = Book::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255|unique:books,title,'.$id,
            'description' => 'nullable|string',
            'status' => 'required|in:incoming,ongoing,compelete'
        ]);

        $book->update([
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
            'is_active' => $request->is_active
        ]);

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
