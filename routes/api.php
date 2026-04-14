<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [UserController::class, 'register']);
Route::get('/post/{post}', [PostController::class, 'show']);
Route::post('/auth', [UserController::class, 'auth']);
Route::get('/user/{user}', [PostController::class, 'postuser']);
Route::get('/posts', [PostController::class, 'index']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::get('/postAuth/{post}', [PostController::class, 'show']);
    Route::get('/logout', [UserController::class, 'logout']);
    Route::post('/postadd', [PostController::class, 'store']);
    Route::post('/postedit/{post}', [PostController::class, 'update']);
    Route::post('/comment/{post}', [CommentController::class, 'store']);
    Route::get('/like/{post}', [LikeController::class, 'store']);
    Route::get('/destroy/{post}', [PostController::class, 'destroy']);
});