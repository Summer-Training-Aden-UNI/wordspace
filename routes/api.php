<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiPostController;
use App\Http\Controllers\Api\ApiSearchController;
use App\Http\Controllers\Api\ApiCommentController;
use App\Http\Controllers\Api\ApiLikeController;
use App\Http\Controllers\Api\ApiProfileController;
use App\Http\Controllers\Api\ApiAdminController;
use App\Http\Controllers\Api\ApiFollowController;
use App\Http\Controllers\Api\ApiUserController;
use App\Http\Resources\UserResource;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/posts', [ApiPostController::class, 'index']);
Route::get('/posts/{post}', [ApiPostController::class, 'show']);
Route::get('/posts/{post}/comments', [ApiCommentController::class, 'index']);

//Search
Route::get('/search', [ApiSearchController::class, 'index']);
Route::get('/users', [ApiUserController::class, 'index']);

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/user', function (Request $request) {
    return new UserResource($request->user());
});

    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/posts', [ApiPostController::class, 'store']);
    Route::post('/posts/{post}', [ApiPostController::class, 'update']);
    Route::delete('/posts/{post}', [ApiPostController::class, 'destroy']);
    Route::post('/posts/{post}/comments', [ApiCommentController::class, 'store']);
    Route::delete('/comments/{comment}', [ApiCommentController::class, 'destroy']);
    Route::get('/posts/{post}/comments', [ApiCommentController::class, 'index']);
    
    
    Route::post('/posts/{post}/likes', [ApiLikeController::class, 'store']);
    Route::delete('/posts/{post}/likes', [ApiLikeController::class, 'destroy']);
    Route::get('/posts/{post}/likes', [ApiLikeController::class, 'index']);
    Route::get('/user/liked-posts', [ApiPostController::class, 'likedPosts']);
    
    
    Route::get('/profile', [ApiProfileController::class, 'show']);
    Route::post('/profile', [ApiProfileController::class, 'update']);
    
    
    //admin:
    Route::middleware('admin')
    ->prefix('admin')
    ->group(function () {
        Route::get('/dashboard', [ApiAdminController::class, 'dashboard']);

        Route::get('/users', [ApiAdminController::class, 'users']);
        Route::delete('/users/{user}', [ApiAdminController::class, 'destroyUser']);
    });


    //Routes for following and unfollowing users
    Route::post('/users/{user}/follow', [ApiFollowController::class, 'store']);
    Route::delete('/users/{user}/follow', [ApiFollowController::class, 'destroy']);
    
    
    

});
//Public routes for viewing user posts
Route::get('/users/{user}/posts', [ApiUserController::class, 'posts']);

//Public routes for following and unfollowing users
Route::get('/users/{user}', [ApiUserController::class, 'show']);
Route::get('/users/{user}/followers', [ApiUserController::class, 'followers']);
Route::get('/users/{user}/following', [ApiUserController::class, 'following']);
