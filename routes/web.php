<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

//The authenticaction Routes
Auth::routes();
Route::get('register/verify/{confirmationCode}', [
    'as' => 'confirmation_path',
    'uses' => 'Auth\RegisterController@confirm'
]);
Route::get('register/escojtos', function(){
	return view('terms.escojtos');
});
Route::get('/auth/redirect/{provider}',  'Auth\SocialAuthController@socialRedirect');
Route::get('/auth/callback/{provider}',  'Auth\SocialAuthController@socialCallback');


Route::get('/home', 'HomeController@index');


Route::group(['prefix' => 'contestant'], function (){
	Route::get('profile', 'Auth\RegisterController@profile');
	Route::get('edit','Auth\RegisterController@edit');
	Route::put('update','Auth\RegisterController@update');
	Route::get('institutions/{id}','Auth\RegisterController@getInstitutions');
	Route::get('contestant/institutions/{id}','Auth\RegisterController@getInstitutions');
});


Route::resource('problem','ProblemController');
Route::resource('judgment','JudgementController');

//Testing Route

Route::get('test',function(){
	
	return view('testing.test');
});