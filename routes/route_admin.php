<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\GenreController;
use App\Http\Controllers\Admin\BookController;

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', function () {
        return view('admin.home');
    })->name('home');
    // Quản lý sách
    Route::get('/books', function() {
        return view('admin.books.index');
    })->name('books');

    // Quản lý thể loại
    Route::get('/genres', [GenreController::class, 'index'])->name('genres');
    Route::get('/genres/create', [GenreController::class, 'create'])->name('genres.create');
    Route::post('/genres', [GenreController::class, 'store'])->name('genres.store');
    Route::get('/genres/{id}', [GenreController::class, 'show'])->name('genres.show');
    Route::get('/genres/{id}/edit', [GenreController::class, 'edit'])->name('genres.edit');
    Route::put('/genres/{id}', [GenreController::class, 'update'])->name('genres.update');
    Route::delete('/genres/{id}', [GenreController::class, 'destroy'])->name('genres.destroy');
    Route::patch('genres/{id}/update-is-active', [GenreController::class, 'updateIsActive'])->name('genres.update-is-active');

    // Quản lý sách
    Route::get('/books', [BookController::class, 'index'])->name('books');
    Route::get('/books/create', [BookController::class, 'create'])->name('books.create');
    Route::post('/books', [BookController::class, 'store'])->name('books.store');
    Route::get('/books/{id}', [BookController::class, 'show'])->name('books.show');
    Route::get('/books/{id}/edit', [BookController::class, 'edit'])->name('books.edit');
    Route::put('/books/{id}', [BookController::class, 'update'])->name('books.update');
    Route::delete('/books/{id}', [BookController::class, 'destroy'])->name('books.destroy');
    Route::patch('/books/{id}/update-is-active', [BookController::class, 'updateIsActive'])->name('books.update-is-active');

    // Quản lý người dùng
    Route::get('/users', function() {
        return view('admin.users.index');
    })->name('users');
});
