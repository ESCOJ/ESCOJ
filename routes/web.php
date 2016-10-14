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

//The Authenticaction Routes
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




//The Users Routes
Route::group(['prefix' => 'contestant'], function (){
	Route::get('profile', 'Auth\RegisterController@profile');
	Route::get('edit','Auth\RegisterController@edit');
	Route::put('update','Auth\RegisterController@update');
	Route::get('institutions/{id}','Auth\RegisterController@getInstitutions');
	Route::get('contestant/institutions/{id}','Auth\RegisterController@getInstitutions');
});

//The Problem Routes
Route::group(['prefix' => 'problem'], function (){
	Route::get('/create', 'ProblemController@create')->name('problem.create');
	Route::post('', 'ProblemController@store')->name('problem.store');
	//update
	Route::get('/{problem}/edit', 'ProblemController@edit')->name('problem.edit');
	Route::put('/update/{problem}', 'ProblemController@update')->name('problem.update');
	//limits
	Route::get('/limits/{problem}', 'ProblemController@limits')->name('problem.limits');
	Route::put('/limits/{problem}', 'ProblemController@assignLimits')->name('problem.assignLimits');
	//datasets
	Route::get('/datasets/{problem}', 'ProblemController@datasets')->name('problem.datasets');
	Route::put('/datasets/{problem}', 'ProblemController@assignDatasets')->name('problem.assignDatasets');	
});

//The Judgements Routes
Route::resource('judgment','JudgementController');


//Other Routes
Route::get('/', function () {
    return view('welcome');
});
Route::get('/home', 'HomeController@index');


//Testing Route
Route::get('test',function(){
	
	return view('testing.test');
});