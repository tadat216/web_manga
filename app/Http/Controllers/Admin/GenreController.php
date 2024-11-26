<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Genre;

class GenreController extends Controller
{
    /**
     * Hiển thị danh sách thể loại
     */
    public function index()
    {
        $genres = Genre::paginate(10); // Phân trang mỗi trang 10 bản ghi
        return view('admin.genres.index', compact('genres'));
    }

    /**
     * Hiển thị form thêm thể loại
     */
    public function create()
    {
        return view('admin.genres.create');
    }

    /**
     * Lưu thể loại mới
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255|unique:genres',
            'description' => 'nullable|string'
        ]);
        Genre::create([
            'title' => $request->title,
            'description' => $request->description,
            'is_active' => $request->is_active,
        ]);

        return redirect()->route('admin.genres')
            ->with('success', 'Thêm thể loại thành công');
    }

    /**
     * Hiển thị chi tiết thể loại
     */
    public function show($id)
    {
        $genre = Genre::findOrFail($id);
        return view('admin.genres.show', compact('genre'));
    }

    /**
     * Hiển thị form chỉnh sửa thể loại
     */
    public function edit($id)
    {
        $genre = Genre::findOrFail($id);
        return view('admin.genres.edit', compact('genre'));
    }

    /**
     * Cập nhật thông tin thể loại
     */
    public function update(Request $request, $id)
    {
        $genre = Genre::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255|unique:genres,title,'.$id,
            'description' => 'nullable|string'
        ]);

        $genre->update([
            'title' => $request->title,
            'description' => $request->description,
            'is_active' => $request->is_active
        ]);

        //dd($genre);

        return redirect()->route('admin.genres')
            ->with('success', 'Cập nhật thể loại thành công');
    }

    /**
     * Xóa thể loại
     */
    public function destroy($id)
    {
        $genre = Genre::findOrFail($id);
        $genre->delete();

        return redirect()->route('admin.genres')
            ->with('success', 'Xóa thể loại thành công');
    }

    /**
     * Cập nhật trạng thái kích hoạt của thể loại
     */
    public function updateIsActive($id)
    {
        $genre = Genre::findOrFail($id);
        $genre->update([
            'is_active' => !$genre->is_active
        ]);
        //dd($genre);
        return response()->json([
            'success' => true
        ]);
    }
}
