<?php

use App\Http\Controllers\LoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SupplierController;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/products', [ProductController::class,'index']);

Route::get('/products/{id}', [ProductController::class, 'show']);

Route::post('/products', [ProductController::class, 'store']);

Route::put('/products/{id}', [ProductController::class, 'update']);

Route::delete('/products/{id}', [ProductController::class, 'destroy']);

Route::post('/products/{id}/use', [ProductController::class, 'useStock']);


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


Route::get('/suppliers', [SupplierController::class, 'index']);

Route::get('/suppliers/{id}', [SupplierController::class, 'show']);

Route::post('/suppliers', [SupplierController::class, 'store']);

Route::put('/suppliers/{id}', [SupplierController::class, 'update']);

Route::delete('/suppliers/{id}', [SupplierController::class, 'destroy']);


Route::post('/login',[LoginController::class,'store']);