<a href="{{ route('user.books.show', $book->id) }}" class="block">
    <div class="flex bg-white rounded-lg shadow-md overflow-hidden relative hover:shadow-lg transition duration-300">
        <div class="absolute top-2 right-2">
            <span class="bg-gray-100 text-gray-600 text-sm px-2 py-1 rounded">
                {{ $book->chapters()->count() }} chương
            </span>
        </div>
        <div class="w-24 h-32 flex-shrink-0">
            <img 
                src="{{ $book->avatar ?? asset('user/static/img/default-avatar.png') }}" 
                alt="{{ $book->title }}"
                class="w-full h-full object-cover"
            >
        </div>
        
        <div class="flex-1 p-4 flex flex-col justify-between">
            <div>
                <h2 class="text-lg font-semibold">{{ $book->title }}</h2>
                <p class="text-gray-600">Tác giả: {{ $book->author_name }}</p>
            </div>
        </div>
    </div>
</a>