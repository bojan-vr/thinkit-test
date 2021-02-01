<?php

use App\Http\Controllers\CrewController;
use App\Http\Controllers\NotificationsController;
use App\Http\Controllers\RankController;
use App\Http\Controllers\ShipsController;
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
    return redirect('/login');
});

Auth::routes();


Route::group(['middleware' => 'auth'], function () {
	Route::get('/home', function() {return redirect('/ships');})->name('home');
	Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);

	Route::post('/ships/remove_crew/{id}', 'App\Http\Controllers\ShipsController@removeCrewMember')->name('remove_crew_member');
	Route::post('/ships/add_crew/{id}', 'App\Http\Controllers\ShipsController@addCrewMember')->name('add_crew_members');
	Route::post('/notifications/send_mail/{id}', 'App\Http\Controllers\NotificationsController@sendNotification')->name('send_mail');
	Route::resource('ships', ShipsController::class);
	Route::resource('crew', CrewController::class);
	Route::resource('ranks', RankController::class);
	Route::resource('notifications', NotificationsController::class);
	Route::post('editor/upload', 'App\Http\Controllers\EditorController@upload')->name('editor.image-upload');

});

