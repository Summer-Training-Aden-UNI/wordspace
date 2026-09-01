<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;


// =========================
// Public
// =========================

Route::get('/', function () {
    return redirect()->route('posts.index');
});


// =========================
// Authenticated Users
// =========================

Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [PostController::class, 'dashboard'])
        ->name('dashboard');


    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');


    // Posts
    Route::resource('posts', PostController::class)
        ->except(['index', 'show']);


    // Comments
    Route::post('/posts/{post}/comments', [CommentController::class, 'store'])
        ->name('comments.store');

    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])
        ->name('comments.destroy');


    // Likes
    Route::post('/posts/{post}/likes', [LikeController::class, 'store'])
        ->name('likes.store');

    Route::delete('/posts/{post}/likes', [LikeController::class, 'destroy'])
        ->name('likes.destroy');


    // My Writing
    Route::get('/my-writing', [PostController::class, 'myWriting'])
        ->name('my-writing');
});


// =========================
// Public Posts
// =========================

Route::get('/posts', [PostController::class, 'index'])
    ->name('posts.index');

Route::get('/posts/{post}', [PostController::class, 'show'])
    ->name('posts.show');


// =========================
// Admin
// =========================

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/', [AdminController::class, 'index'])
            ->name('dashboard');

        Route::get('/posts', [AdminController::class, 'posts'])
            ->name('posts');

        Route::delete('/posts/{post}', [AdminController::class, 'destroyPost'])
            ->name('posts.destroy');

        Route::get('/comments', [AdminController::class, 'comments'])
            ->name('comments');

        Route::delete('/comments/{comment}', [AdminController::class, 'destroyComment'])
            ->name('comments.destroy');

        Route::get('/users', [AdminController::class, 'users'])
            ->name('users');

        Route::delete('/users/{user}', [AdminController::class, 'destroyUser'])
            ->name('users.destroy');
    });


require __DIR__.'/auth.php';