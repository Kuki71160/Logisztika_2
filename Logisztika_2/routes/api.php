<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/products', [ProductController::class,'index']);

Route::get('/products/{id}', [ProductController::class, 'show']);

Route::post('/products/create', [ProductController::class, 'store']);

Route::put('/products/{id}', [ProductController::class, 'update']);

Route::delete('/products/{id}', [ProductController::class, 'destroy']);



Route::get('/users', [UserController::class, 'index']); // Get all users

Route::get('/users/{id}', [UserController::class, 'show']); // Get a single user

Route::post('/users', [UserController::class, 'store']); // Create a new user

Route::put('/users/{id}', [UserController::class, 'update']); // Update a user

Route::delete('/users/{id}', [UserController::class, 'destroy']); // Delete a user


Route::get('/categories', [CategoryController::class, 'index']);

Route::get('/categories/{id}', [CategoryController::class,'show']);

Route::post('/categories', [CategoryController::class, 'store']);

Route::put('/categories/{id}', [CategoryController::class, 'update']);

Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);
