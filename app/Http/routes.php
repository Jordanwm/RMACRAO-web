<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

//Route::get('/', 'WelcomeController@index');
Route::get('/', 'HomeController@index');

Route::group(['prefix' => 'api'], function(){
	Route::get('/sessions', function(){
		return response()->json(App\Day::with('sessions', 'sessions.events', 'sessions.events.presenters', 'sessions.events.facilitators')->get());
	});

	Route::get('/speakers', function(){
		return response()->json(App\Speaker::all());
	});

	Route::get('/exhibitors', function(){
		return response()->json(App\Exhibitor::with('staff')->get());
	});
});

Route::resource('speakers', 'SpeakersController', ['except' => 'show']);
Route::get('speakers/{id}/delete', 'SpeakersController@delete');

Route::resource('sessions', 'SessionsController', ['only' => ['index', 'update', 'store', 'destroy']]);

Route::post('sessions/{id}/sessions', 'SessionsController@createSession');
Route::post('sessions/{dayId}/sessions/{sessionId}/events', 'SessionsController@createEvent');

Route::put('sessions/{dayId}/sessions/{sessionId}', 'SessionsController@updateSession');
Route::put('sessions/{dayId}/sessions/{sessionId}/events/{eventId}', 'SessionsController@updateEvent');

Route::delete('sessions/{dayId}/sessions/{sessionId}', 'SessionsController@destroySession');
Route::delete('sessions/{dayId}/sessions/{sessionId}/events/{eventId}', 'SessionsController@destroyEvent');

Route::resource('years', 'YearsController');

Route::resource('exhibitors', 'ExhibitorsController');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
