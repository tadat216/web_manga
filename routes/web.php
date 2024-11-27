<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\GenreController;
use App\Http\Controllers\User\BookController;
use App\Http\Controllers\User\ChapterController;

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/', function () {
    return view('user.home.index');
})->name('user.home');

// route cho thể loại
Route::get('/the-loai/{id}', [GenreController::class, 'show'])->name('user.genres.show');

// route cho truyện
Route::get('/truyen/{id}', [BookController::class, 'show'])->name('user.books.show');

// route cho chương
Route::get('/truyen/{id}/chuong/{chapter_id}', [ChapterController::class, 'show'])->name('user.chapters.show');

require __DIR__.'/auth.php';
require __DIR__.'/route_user.php';
require __DIR__.'/route_admin.php';
