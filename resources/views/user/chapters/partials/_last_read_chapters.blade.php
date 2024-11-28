@if ($lastReadChapters->count() > 0)
  <div class="mt-4">
    <div class="bg-light dark:bg-dark rounded-lg shadow p-4">
      <h4 class="text-base font-semibold mb-4 text-light dark:text-dark">Đã đọc gần đây</h4>
      <div class="space-y-3 h-64 overflow-y-auto">
        @foreach ($lastReadChapters as $chapter)
          <a href="{{ route('user.chapters.show', ['id' => $chapter->book_id, 'chapter_id' => $chapter->id]) }}"
            class="block hover:bg-gray-50 dark:hover:bg-gray-800 rounded p-3 transition duration-150">
            <div class="flex justify-between items-center">
              <div class="flex-1 min-w-0">
                <div class="flex flex-col">
                  <span class="font-medium text-sm mb-1 truncate text-light dark:text-dark">{{ $chapter->book->title }}...</span>
                  <span class="text-gray-500 dark:text-gray-400 text-sm">{{ $chapter->title }}</span>
                </div>
              </div>
            </div>
          </a>
        @endforeach
      </div>
    </div>
  </div>
@endif
