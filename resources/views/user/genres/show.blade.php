@extends('layouts.app')

@section('content')
  <h1 class="text-2xl font-bold mb-6">Thể loại: {{ $genre->title }}</h1>

  <div class="mb-6">
    <form action="{{ route('user.genres.search', $genre->id) }}" method="GET" class="space-y-4">
      <div class="flex gap-4">
        <div class="flex-1">
          <input type="text" name="keyword" value="{{ $keyword ?? '' }}" 
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
            placeholder="Tên truyện...">
        </div>
        <div class="flex-1">
          <input type="text" name="author" value="{{ $authorName ?? '' }}"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" 
            placeholder="Tác giả...">
        </div>
        <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
          Tìm kiếm
        </button>
      </div>

      <div class="flex flex-wrap gap-2 items-center">
        <span class="font-medium text-gray-700 dark:text-gray-300">Lọc theo:</span>
        <select name="status" class="px-3 py-1 bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-300 rounded-lg border-0">
          <option value="">Tất cả trạng thái</option>
          @foreach (\App\Models\Book::getStatuses() as $key => $value)
            <option value="{{ $key }}" {{ ($status ?? '') == $key ? 'selected' : '' }}>{{ $value }}</option>
          @endforeach
        </select>
      </div>
    </form>
  </div>

  <div class="grid gap-4">
    @foreach ($books as $book)
      <x-book-horizontal-card :book="$book" />
    @endforeach
  </div>

  <div class="mt-6">
    {{ $books->links() }}
  </div>
@endsection

@section('sidebar')
  @include('user.chapters.partials._last_read_chapters')
  @include('user.books.partials._suggested_books')
@endsection
