@extends('layouts.app')

@section('content')
  <h1 class="text-2xl font-bold mb-6">Thể loại: {{ $genre->title }}</h1>

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
