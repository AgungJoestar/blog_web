<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController; //load controller post
use App\Http\Controllers\CategoryController; //load controller post

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('index');
});

Route::get ('/category/delete/{id}', [CategoryController::class, 'destroy_with'])->name('category.delete');
Route::get ('/post/search', [PostController::class, 'search']);
Route::resource('post', PostController::class);
Route::resource('category', CategoryController::class);