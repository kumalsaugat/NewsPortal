<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

    // News Category
    Route::resource('news-category', \App\Http\Controllers\Admin\NewsCategoryController::class);
    Route::patch('/news-category/update-status/{id}', [\App\Http\Controllers\Admin\NewsCategoryController::class, 'updateStatus'])->name('news-category.update-status');

    // News
    Route::resource('news', \App\Http\Controllers\Admin\NewsController::class);
    Route::post('upload', [\App\Http\Controllers\Admin\NewsController::class, 'upload'])->name('upload');
    Route::delete('revert', [\App\Http\Controllers\Admin\NewsController::class, 'revert'])->name('revert');
    Route::get('/load/{filename}', [\App\Http\Controllers\Admin\NewsController::class, 'load'])->name('load');
    Route::get('/fetch/{filename}', [\App\Http\Controllers\Admin\NewsController::class, 'fetch'])->name('fetch');
    Route::patch('/news/update-status/{id}', [\App\Http\Controllers\Admin\NewsController::class, 'updateStatus'])->name('news.update-status');

    //User
    Route::resource('user', \App\Http\Controllers\Admin\UserController::class);


});

require __DIR__.'/auth.php';