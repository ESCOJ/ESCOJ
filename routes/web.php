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

Route::get('institutions/{id}','Auth\RegisterController@getInstitutions');
Route::get('contestant/institutionss/{id}','UserController@getInstitutions');



Route::get('/home', 'HomeController@index');


Route::group(['prefix' => 'contestant'], function (){
	Route::get('profile', 'UserController@profile');
	Route::get('edit','UserController@edit');
	Route::put('update','UserController@update');

});

//Testing Route

Route::get('test',function(){
	return view('testing.test');
});