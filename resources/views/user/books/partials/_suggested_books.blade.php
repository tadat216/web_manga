@if ($suggestedBooks->count() > 0)
  <div class="mt-4">
    <div class="bg-light dark:bg-dark rounded-lg shadow p-4">
      <h4 class="text-base font-semibold mb-4 text-light dark:text-dark">Đề xuất cho bạn</h4>
      <div class="space-y-3 h-96 overflow-y-auto">
        @foreach ($suggestedBooks as $book)
          <a href="{{ route('user.books.show', $book->id) }}"
            class="block hover:bg-gray-50 dark:hover:bg-gray-800 rounded p-3 transition duration-150">
            <div class="flex space-x-4">
              <div class="flex-shrink-0">
                <img src="{{ $book->avatar ?? asset('user/static/img/default-avatar.png') }}" alt="{{ $book->title }}"
                  class="w-16 h-20 object-cover rounded">
              </div>
              <div class="flex-1 min-w-0">
                <h5 class="font-medium text-sm truncate text-light dark:text-dark">{{ $book->title }}</h5>
                <p class="text-gray-500 dark:text-gray-400 text-sm">{{ $book->chapters->count() }} chương</p>
                <div class="flex flex-wrap gap-1 mt-1">
                  @foreach ($book->genres as $genre)
                    <span class="inline-block bg-gray-100 dark:bg-gray-800 rounded px-2 py-0.5 text-xs text-gray-600 dark:text-gray-300">
                      {{ $genre->title }}
                    </span>
                  @endforeach
                </div>
              </div>
            </div>
          </a>
        @endforeach
      </div>
    </div>
  </div>
@endif
