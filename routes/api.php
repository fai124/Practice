<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\UserServiceController;
use App\Http\Controllers\ServController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [UserController::class, 'register']);
Route::get('/serv/{serv}', [ServController::class, 'show']);
Route::post('/auth', [UserController::class, 'auth']);
Route::get('/user/{user}', [ServController::class, 'servuser']);
Route::get('/servs', [ServController::class, 'index']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/my-services', [UserServiceController::class, 'getUserServices']);
    Route::get('/available-services', [UserServiceController::class, 'getAvailableServices']);
    Route::post('/add-service', [UserServiceController::class, 'addServiceToUser']);

    Route::get('/servAuth/{post}', [ServController::class, 'show']);
    Route::get('/logout', [UserController::class, 'logout']);
    Route::post('/servadd', [ServController::class, 'store']);
    Route::post('/useredit', [UserController::class, 'update']);
    Route::post('/comment/{serv}', [CommentController::class, 'store']);
    Route::post('/comment/update/{comment}', [CommentController::class, 'update']);
    Route::post('/like/{comment}', [LikeController::class, 'store']);
    Route::delete('/destroy/{comment}', [ServController::class, 'destroy']);
});