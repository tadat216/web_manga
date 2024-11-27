@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h1 class="text-3xl font-bold text-center text-gray-800 mb-4">
            Chào mừng đến trang chủ
        </h1>
        <p class="text-gray-600 text-center">
            Cảm ơn bạn đã ghé thăm website của chúng tôi
        </p>
    </div>
</div>
@endsection

@section('sidebar')
    @include('user.chapters.partials._last_read_chapters')
    @include('user.books.partials._suggested_books')
@endsection
