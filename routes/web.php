<?php

use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/category', [App\Http\Controllers\CategoryController::class, 'index'])->name('category');
// Route::post('/store','CategoryController@store');

Route::post('/store', [App\Http\Controllers\CategoryController::class, 'store'])->name('store');
Route::post('/savetodb', [App\Http\Controllers\CategoryController::class, 'saveTODB'])->name('savetodb');

// Route::get('{any}', function () {
//     return view('layouts.app');
// })->where('any', '.*');

Route::get('/article',[App\Http\Controllers\ArticleController::class,'index'])->name('article');
Route::post('/article',[App\Http\Controllers\ArticleController::class,'store'])->name('article.store');
Route::get('/article/{id}/edit', [App\Http\Controllers\ArticleController::class, 'edit'])->name('article.edit');
Route::post('/article/update', [App\Http\Controllers\ArticleController::class, 'update'])->name('article.update');
Route::get('/article/{id}/delete', [App\Http\Controllers\ArticleController::class, 'destroy'])->name('article.delete');
