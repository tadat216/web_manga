@extends('layouts.app')

@section('content')
  <h1 class="text-2xl font-bold mb-2 text-center"><a href="{{ route('user.books.show', $book->id) }}" class="hover:text-blue-500">{{ $book->title }}</a></h1>
  <h2 class="text-xl mb-6 text-center">{{ $chapter->title }}</h2>

  <!-- Điều hướng chương đầu -->
  @include('user.chapters.partials._navigation', [
      'book' => $book,
      'chapter' => $chapter,
      'chapters' => $chapters,
      'prevChapter' => $prevChapter,
      'nextChapter' => $nextChapter,
      'marginBottom' => true
  ])

  <!-- Nội dung chương -->
  <div class="prose max-w-none mb-8">
      {!! $chapter->content !!}
  </div>

  @include('user.chapters.partials._navigation', [
    'book' => $book,
    'chapter' => $chapter,
    'chapters' => $chapters,
    'prevChapter' => $prevChapter,
    'nextChapter' => $nextChapter,
    'marginBottom' => true
  ])
@endsection

@section('sidebar')
  <!-- Để trống cho các partial khác -->
@endsection
