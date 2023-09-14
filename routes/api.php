<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\userController\AuthController;
use App\Http\Controllers\userController\BlogController;
use App\Http\Controllers\userController\ProfileController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/profile', [ProfileController::class, 'getProfile']);
    Route::post('/profile', [ProfileController::class, 'updateProfile']);

    Route::get('/blogs', [BlogController::class, 'getAllBlogs']);
    Route::get('/blogs/{id}', [BlogController::class, 'getBlogInfo']);
    Route::post('/blogs', [BlogController::class, 'createBlog']);
    Route::put('/blogs/{id}', [BlogController::class, 'updateBlog']);
    Route::delete('/blogs/{id}', [BlogController::class, 'deleteBlog']);
});