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

    Route::post('/news-category/bulk-update-status', [\App\Http\Controllers\Admin\NewsCategoryController::class,'bulkUpdateStatus'])->name('news-category.bulk-update-status');
    Route::post('/news-category/bulk-delete', [\App\Http\Controllers\Admin\NewsCategoryController::class, 'bulkDelete'])->name('news-category.bulk-delete');

    // News
    Route::resource('news', \App\Http\Controllers\Admin\NewsController::class);
    Route::post('upload', [\App\Http\Controllers\Admin\NewsController::class, 'upload'])->name('upload');
    Route::delete('revert', [\App\Http\Controllers\Admin\NewsController::class, 'revert'])->name('revert');
    Route::get('/load/{filename}', [\App\Http\Controllers\Admin\NewsController::class, 'load'])->name('load');
    Route::get('/fetch/{filename}', [\App\Http\Controllers\Admin\NewsController::class, 'fetch'])->name('fetch');
    Route::patch('/news/update-status/{id}', [\App\Http\Controllers\Admin\NewsController::class, 'updateStatus'])->name('news.update-status');

    Route::post('/news/bulk-update-status', [\App\Http\Controllers\Admin\NewsController::class,'bulkUpdateStatus'])->name('news.bulk-update-status');
    Route::post('/news/bulk-delete', [\App\Http\Controllers\Admin\NewsController::class, 'bulkDelete'])->name('news.bulk-delete');

    //User
    Route::resource('user', \App\Http\Controllers\Admin\UserController::class);
    Route::patch('/user/update-status/{id}', [\App\Http\Controllers\Admin\UserController::class, 'updateStatus'])->name('user.update-status');
    Route::get('/user/password/{id}', [\App\Http\Controllers\Admin\UserController::class,  'password'])->name('password');
    Route::put('/user/password/change/{id}', [\App\Http\Controllers\Admin\UserController::class,  'updatepassword'])->name('user.password.change');

    Route::post('/user/bulk-update-status', [\App\Http\Controllers\Admin\UserController::class,'bulkUpdateStatus'])->name('user.bulk-update-status');
    Route::post('/user/bulk-delete', [\App\Http\Controllers\Admin\UserController::class, 'bulkDelete'])->name('user.bulk-delete');

    //Album
    Route::resource('album', \App\Http\Controllers\Admin\AlbumController::class);
    Route::patch('/album/update-status/{id}', [\App\Http\Controllers\Admin\AlbumController::class, 'updateStatus'])->name('albums.update-status');
    Route::post('/multipleupload', [\App\Http\Controllers\Admin\AlbumController::class, 'multipleUpload'])->name('multipleUpload');

    //Image
    Route::resource('album-image', \App\Http\Controllers\Admin\ImageController::class);
    Route::get('/albums/{album}/images', [\App\Http\Controllers\Admin\ImageController::class, 'albumImage'])->name('album-image.albumImage');



});

require __DIR__.'/auth.php';
