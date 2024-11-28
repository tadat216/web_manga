<a href="{{ route('user.books.show', $book->id) }}" class="block">
    <div class="flex md:flex-row flex-col bg-white rounded-lg shadow-md overflow-hidden relative hover:shadow-lg transition duration-300">
        <div class="absolute top-2 right-2">
            <span class="bg-gray-100 text-gray-600 text-sm px-2 py-1 rounded">
                {{ $book->chapters()->count() }} chương
            </span>
        </div>
        <div class="md:w-24 w-full md:h-32 h-48 flex-shrink-0">
            <img 
                src="{{ $book->avatar ? $book->avatar : asset('user/static/img/default-avatar.png') }}" 
                alt="{{ $book->title }}"
                class="w-full h-full object-cover"
            >
        </div>
        
        <div class="flex-1 p-4 flex flex-col justify-between">
            <div>
                <h2 class="text-lg font-semibold flex items-center gap-2 flex-wrap">
                    {{ $book->title }}
                    <span class="text-sm font-normal px-2 py-1 rounded-full {{ $book->status === 'complete' ? 'bg-green-100 text-green-800' : ($book->status === 'ongoing' ? 'bg-blue-100 text-blue-800' : 'bg-yellow-100 text-yellow-800') }}">
                        {{ \App\Models\Book::getStatuses()[$book->status] ?? '' }}
                    </span>
                    @if(Auth::check() && isset($book->users) && $book->users->count() > 0)
                    <p class="text-sm text-green-600 flex items-center gap-1 mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Đã xem đến: Chương {{ optional($book->lastReadChapters->first())->chapter_number ?? '?' }}
                    </p>
                    @endif
                </h2>
                
                <p class="text-gray-600 flex items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    Tác giả: {{ $book->author_name ?? 'Không xác định' }}
                </p>
                <p class="text-gray-600 flex items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                    Thể loại: {{ optional($book->genres)->pluck('title')->join(', ') ?? 'Chưa phân loại' }}
                </p>
                <p class="text-gray-600 flex items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    Lượt xem: {{ $book->view_count ?? 0 }}
                </p>
            </div>
        </div>
    </div>
</a>