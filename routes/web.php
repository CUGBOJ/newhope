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

Route::get('/', 'StaticPagesController@home')->name('home');
Route::get('help', 'StaticPagesController@help')->name('help');
Route::get('about', 'StaticPagesController@about')->name('about');
Route::get('submit','StaticPagesController@submit_by_file')->name('submit');
Route::any('judge','StaticPagesController@judge')->name('judge');


Route::get('signup', 'UsersController@create')->name('signup');
Route::resource('users', 'UsersController');

Route::get('login', 'SessionsController@create')->name('login');
Route::post('login', 'SessionsController@store')->name('login');
Route::delete('logout', 'SessionsController@destroy')->name('logout');

Route::resource('problems', 'ProblemsController');
Route::get('statuses', 'StatusesController@index')->name('statuses');
Route::resource('topics', 'TopicsController');

Route::resource('replies', 'RepliesController', ['only' => ['store', 'destroy']]);
Route::resource('notifications', 'NotificationsController', ['only' => ['index',]]);
Route::resource('announcements', 'AnnouncementsController');
Route::resource('contests', 'ContestsController');
Route::post('/contests/{contest}','ContestsController@add_user')->name('contests.add_user');

Route::get('permission','StaticPagesController@permission')->name('permission');
