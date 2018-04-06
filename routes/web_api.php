<?php

/*
|--------------------------------------------------------------------------
| Web API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group.
|
 */

Route::middleware('auth')->group(function () {
    // These APIs can be used after authentication
});

Route::post('login', 'SessionsController@store')->name('login');
Route::delete('logout', 'SessionsController@destroy')->name('logout');
Route::post('codesubmit', 'StatusesController@store')->name('codesubmit');

Route::get('users', 'UsersController@index');
Route::get('user', 'UsersController@api_profile');
Route::get('user/{username}', 'UsersController@api_profile');
Route::get('topics', 'TopicsController@index');
Route::get('announcements', 'AnnouncementsController@index');
Route::get('problem/{problem}', 'ProblemsController@show');

Route::resource('user', 'UsersController', ['only' => ['store', 'update', 'destroy']]);
