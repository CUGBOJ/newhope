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
Route::post('notifications', 'NotificationsController@readAll')->name('notifications.readAll');

Route::get('topics', 'TopicsController@index');
Route::get('topic/{topic}', 'TopicsController@show');

Route::get('announcements', 'AnnouncementsController@index');

//contest
Route::get('contests', 'ContestsController@index');
Route::get('contest/{contest}', 'ContestsController@show');
Route::post('contest/{contest}', 'ContestsController@update');
Route::delete('contest/{contest}', 'ContestsController@destroy');
Route::post('contest', 'ContestsController@store');
// Route::get('contest/{contest}/{problem}','ProblemsController@showByContest');

Route::get('problemsByContest/{contest}', 'ContestsController@getProblems');
Route::get('getProblemId', 'ContestsController@getProblem');

Route::get('usersByContest/{contest}', 'ContestsController@getUser');
Route::get('rejectUserByContest/{contest}', 'ContestsController@getRejectUser');
Route::get('statusByContest/{contest}', 'ContestsController@getStatus');
Route::get('topicsByContest/{contest}', 'ContestsController@getTopics');


Route::get('problem/{problem}', 'ProblemsController@show');
Route::post('problem/{problem}', 'ProblemsController@update');
Route::delete('problem/{problem}', 'ProblemsController@destroy');
Route::post('problem', 'ProblemsController@store');

Route::post('announcement/{announcement}', 'AnnouncementsController@update');
Route::delete('announcement/{announcement}', 'AnnouncementsController@destroy');
Route::post('announcement', 'AnnouncementsController@store');

Route::post('codeSubmit', 'StatusesController@store');

Route::get('problem', 'ProblemsController@getProblems');

Route::get('status', 'StatusesController@show');

Route::get('standing/{contest}', 'ContestsController@getStanding');

Route::post('uploadFile', function (Illuminate\Http\Request $request) {
    $handler = new App\Handlers\ImageUploadHandler;
    $result = $handler->save($request->file('file'), Auth::user()->username, uniqid());
    if ($result) {
        return response()->json($result, 200);
    }
    else {
        return response()->json('upload failed', 500);
    }
});

Route::get('team/{team}','TeamsController@show');
Route::post('teams','TeamsController@store');
Route::get('teams','TeamsController@index');
Route::delete('team/{team}','TeamsController@destroy');
Route::post('team/{team}','TeamsController@apply');

Route::get('applyList/{team}','TeamsController@getApplyList');
Route::post('dealApply/{team}','TeamsController@dealApply');
Route::post('subMember/{team}','TeamsController@subMember');