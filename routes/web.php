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

Route::get('reset_password/{token}', ['as' => 'password.reset', function($token)
{
    // implement your reset password route here!
}]);

Route::get('/', function () {
    return view('index');
});

Route::get('/news', ['as'=>'news', 'uses'=>'\\App\\Api\\V1\\Controllers\\NewsController@create']);
Route::post('/news', ['as'=>'news_store', 'uses'=>'\\App\\Api\\V1\\Controllers\\NewsController@store']);

Route::get('/events', ['as'=>'events', 'uses'=>'\\App\\Api\\V1\\Controllers\\EventsController@create']);
Route::post('/events', ['as'=>'events_store', 'uses'=>'\\App\\Api\\V1\\Controllers\\EventsController@store']);

Route::post('/contactus', ['as'=>'contactus_store', 'uses'=>'\\App\\Api\\V1\\Controllers\\ContactController@store']);

Route::get('/board', ['as'=>'board', 'uses'=>'\\App\\Api\\V1\\Controllers\\BoardController@view']);
Route::post('/board', ['as'=>'board_fetch', 'uses'=>'\\App\\Api\\V1\\Controllers\\BoardController@fetch']);
