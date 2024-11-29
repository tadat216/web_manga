@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
        <h1 class="text-3xl font-bold text-center text-gray-800 dark:text-gray-200 mb-4">
            Chào mừng đến trang chủ
        </h1>
        <p class="text-gray-600 dark:text-gray-400 text-center">
            <ul class="text-left">
                <li>Trang đọc truyện đơn giản, mục đích demo</li>
                <li>Phần đề xuất cho bạn sử dụng thuật toán đề xuất dựa trên sở thích của người dùng</li>
                <li>Tham khảo thuật toán được áp dụng tại <a href="https://en.wikipedia.org/wiki/Collaborative_filtering" target="_blank">Wikipedia</a></li>
                <li>User để đăng nhập trải nghiệm: user5@gmail.com, password: 12345678 (có thể đăng kí và user mới và trải nghiệm, có các user từ 3 đến 60)</li>
                <li>Link github: <a href="https://github.com/tadat216/web_manga" target="_blank">https://github.com/tadat216/web_manga</a></li>
            </ul>
        </p>
    </div>
    @auth
        @if($savedBooks->count() > 0)
            <div class="my-8">
                <h2 class="text-2xl font-bold mb-4">Truyện đã lưu</h2>
                <div class="grid gap-4 overflow-y-auto max-h-96">
                    @foreach($savedBooks as $book)
                        <x-book-horizontal-card :book="$book" />
                    @endforeach
                </div>
            </div>
        @endif

        @if($continueBooks->count() > 0) 
            <div class="mb-8">
                <h2 class="text-2xl font-bold mb-4">Truyện đã đọc</h2>
                <div class="grid gap-4 overflow-y-auto max-h-96">
                    @foreach($continueBooks as $book)
                        <x-book-horizontal-card :book="$book" />
                    @endforeach
                </div>
            </div>
        @endif
    @endauth
</div>

@endsection

@section('sidebar')
    @include('user.chapters.partials._last_read_chapters')
    @include('user.books.partials._suggested_books')
@endsection
