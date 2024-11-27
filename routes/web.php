<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;

Route::get('/', function () {
    return view('user.home.index');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/the-loai', [CategoryController::class, 'index'])->name('categories.index');
//Route::get('/the-loai/{slug}', [CategoryController::class, 'show'])->name('categories.show');

require __DIR__.'/auth.php';
require __DIR__.'/route_user.php';
require __DIR__.'/route_admin.php';
