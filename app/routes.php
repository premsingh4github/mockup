<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/
Route::get('login',function(){
	return View::make('login');
});
Route::get('/','HomeController@index');
Route::get('users',function()
	{
		return View::make('users');
	});
Route::post('/login','HomeController@loginCheck');
Route::post('/addComment','HomeController@addComment');
Route::post('/addComment1','HomeController@addComment1');
Route::post('/showText/{id}','HomeController@showText');
Route::GET('/deleteText/{id}','HomeController@deleteText');
Route::GET('/listDraw/{id}','HomeController@listDraw');
Route::POST('/deleteDraw/{id}','HomeController@deleteDraw');
Route::POST('/showComment/{id}','HomeController@showComment');
Route::GET('/showComment/{id}','HomeController@showComment');
Route::get('/home','HomeController@home');
Route::get('/logout','HomeController@logout');
Route::get('/pdf','HomeController@pdf');
Route::POST('/addText','HomeController@addText');

Route::group(array('before' => 'check'), function()
{
  Route::resource('members','MemberController');
  Route::resource('projects','ProjectController');
  Route::resource('teams','TeamController');  
  Route::post('file-submit','DocumentController@store');
  Route::get('document/{id}','DocumentController@show');
  Route::get('document/destroy/{id}','DocumentController@destroy');
  
});

