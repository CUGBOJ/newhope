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

Route::post('user', 'UsersController@store');
Route::patch('user/{user}', 'UsersController@update');
Route::delete('user/{user}', 'UsersController@destroy');
Route::get('user', 'UsersController@profile');
Route::get('user/{username}', 'UsersController@profile');
Route::get('users', 'UsersController@index');

Route::post('login', 'SessionsController@store')->name('login');
Route::delete('logout', 'SessionsController@destroy')->name('logout');

Route::get('notifications', 'NotificationsController@index');
Route::post('notifications', 'NotificationsController@read_all')->name('notifications.read_all');

Route::get('topics', 'TopicsController@index');

Route::get('announcements', 'AnnouncementsController@index');
// Route::get('contests', 'ContestsController@index');

Route::get('problem/{problem}', 'ProblemsController@show');

Route::post('codesubmit', 'StatusesController@store')->name('codesubmit');
