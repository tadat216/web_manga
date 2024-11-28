@extends('layouts.app')

@section('content')
  <div class="bg-light dark:bg-dark rounded-lg shadow-md p-4 md:p-6">
    <div class="flex flex-col md:flex-row">
      <!-- Cột 1: Avatar và thông tin cơ bản -->
      <div class="w-full md:w-1/4 md:pr-6 mb-6 md:mb-0">
        <img src="{{ $book->avatar ?? asset('user/static/img/default-avatar.png') }}" alt="{{ $book->title }}"
          class="w-full max-w-[200px] mx-auto md:max-w-none h-auto rounded-lg shadow-md mb-4">

        <div class="space-y-2">
          <div>
            <span class="font-semibold text-gray-700 dark:text-gray-300">Tác giả:</span>
            <span class="text-gray-600 dark:text-gray-400">{{ $book->author_name }}</span>
          </div>
          <div>
            <span class="font-semibold text-gray-700 dark:text-gray-300">Trạng thái:</span>
            <span class="text-gray-600 dark:text-gray-400">{{ $book->status }}</span>
          </div>
          <div>
            <span class="font-semibold text-gray-700 dark:text-gray-300">Lượt xem:</span>
            <span class="text-gray-600 dark:text-gray-400">{{ $book->view_count }}</span>
          </div>
        </div>
      </div>

      <!-- Cột 2: Thông tin chi tiết -->
      <div class="w-full md:w-3/4">
        <h1 class="text-2xl md:text-3xl font-bold text-gray-800 dark:text-gray-100 mb-4">{{ $book->title }}</h1>

        <div class="space-y-4">
          <div>
            <span class="font-semibold text-gray-700 dark:text-gray-300">Số chương:</span>
            <span class="text-gray-600 dark:text-gray-400">{{ $book->chapters->count() }} chương</span>
          </div>

          <div>
            <span class="font-semibold text-gray-700 dark:text-gray-300">Thể loại:</span>
            <div class="flex flex-wrap gap-2 mt-2">
              @foreach ($book->genres as $genre)
                <span class="bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 px-3 py-1 rounded-full text-sm">
                  {{ $genre->title }}
                </span>
              @endforeach
            </div>
          </div>

          <div>
            <span class="font-semibold text-gray-700 dark:text-gray-300">Giới thiệu:</span>
            <p class="text-gray-600 dark:text-gray-400 mt-2 text-sm md:text-base">{{ $book->description }}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
  @if ($bookUser && $bookUser->chapter)
    <div class="mt-6">
      <div class="bg-blue-50 dark:bg-blue-900 p-4 rounded-lg flex items-center">
        <h3 class="text-lg font-semibold text-blue-800 dark:text-blue-200 mr-2">Tiếp tục đọc:</h3>
        <a href="{{ route('user.chapters.show', ['id' => $book->id, 'chapter_id' => $bookUser->chapter->id]) }}"
          class="text-blue-600 dark:text-blue-300 hover:text-blue-800 dark:hover:text-blue-100">
          {{ $bookUser->chapter->title }}
        </a>
      </div>
    </div>
  @endif
  <div class="mt-8">
    <h2 class="text-2xl font-bold mb-4 text-gray-800 dark:text-gray-100">Danh sách chương</h2>
    <div class="space-y-2">
      @foreach ($chapters as $chapter)
        <a href="{{ route('user.chapters.show', ['id' => $book->id, 'chapter_id' => $chapter->id]) }}"
          class="block bg-light dark:bg-dark p-3 rounded-lg shadow hover:shadow-md transition">
          <h3 class="text-gray-800 dark:text-gray-100 truncate">{{ $chapter->title }}</h3>
        </a>
      @endforeach
    </div>
    <div class="mt-4">
      {{ $chapters->links() }}
    </div>
  </div>
@endsection

@section('sidebar')
  <!-- Để trống cho các partial khác -->
@endsection
