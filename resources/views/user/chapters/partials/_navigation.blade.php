<div class="flex items-center justify-center gap-4">
  <a href="{{ $prevChapter ? route('user.chapters.show', ['id' => $book->id, 'chapter_id' => $prevChapter->id]) : '#' }}"
     class="px-4 py-2 bg-blue-500 text-white rounded {{ !$prevChapter ? 'opacity-50 cursor-not-allowed' : 'hover:bg-blue-600' }} dark:bg-blue-600 dark:hover:bg-blue-700">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
      </svg>
  </a>

  <select class="px-4 py-2 border rounded bg-light dark:bg-dark text-light dark:text-dark border-light dark:border-dark" onchange="window.location.href=this.value">
      @foreach($chapters as $c)
          <option value="{{ route('user.chapters.show', ['id' => $book->id, 'chapter_id' => $c->id]) }}"
                  {{ $c->id == $chapter->id ? 'selected' : '' }}>
              {{ $c->title }}
          </option>
      @endforeach
  </select>

  <a href="{{ $nextChapter ? route('user.chapters.show', ['id' => $book->id, 'chapter_id' => $nextChapter->id]) : '#' }}"
     class="px-4 py-2 bg-blue-500 text-white rounded {{ !$nextChapter ? 'opacity-50 cursor-not-allowed' : 'hover:bg-blue-600' }} dark:bg-blue-600 dark:hover:bg-blue-700">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
      </svg>
  </a>
</div>