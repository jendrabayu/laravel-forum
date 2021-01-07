<?php

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

use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/', 'ThreadController@index')->name('home');
Route::get('/{id}-{slug}', 'ThreadController@show')->name('threads.show');

Route::middleware('auth')->group(function () {
    Route::resource('threads', 'ThreadController')->except(['index', 'show']);
    Route::resource('answers', 'AnswerController')->except(['index', 'show', 'create']);
    Route::put('answers/{id}/like', 'AnswerController@like')->name('answers.like');
    Route::resource('answer_comments', 'AnswerCommentController')->only(['store', 'update', 'destroy']);
    Route::put('threads/{id}/like', 'ThreadController@like')->name('threads.like');
    Route::put('threads/{id}/solved', 'ThreadController@solved')->name('threads.solved');

    Route::name('account.')->prefix('account')->group(function () {
        Route::get('/', 'AccountController@account')->name('index');
        Route::put('/', 'AccountController@updateAccount')->name('update_account');
        Route::get('password', 'AccountController@password')->name('password');
        Route::put('password', 'AccountController@updatePassword')->name('update_password');
    });

    Route::name('admin.')->prefix('admin')->middleware('role:admin')->group(function () {
        Route::get('/', 'UserController')->name('users');
        Route::resource('categories', 'CategoryController')->except(['create', 'edit', 'show']);
    });
});
