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
	//create
	Route::get('/create', 'ProblemController@create')->name('problem.create');
	Route::post('', 'ProblemController@store')->name('problem.store');
	//update
	Route::get('/{problem}/edit', 'ProblemController@edit')->name('problem.edit');
	Route::put('/update/{problem}', 'ProblemController@update')->name('problem.update');
	//delete
	Route::delete('/{problem}', 'ProblemController@destroy')->name('problem.destroy');	
	//limits
	Route::get('/limits/{problem}/{flag_update?}', 'ProblemController@limits')->name('problem.limits');
	Route::put('/limits/{problem}', 'ProblemController@assignLimits')->name('problem.assignLimits');
	//datasets
	Route::put('/datasets/{problem}', 'ProblemController@assignDatasets')->name('problem.assignDatasets');
	Route::get('/datasets/{problem}/delete', 'ProblemController@deleteDatasets')->name('problem.deleteDatasets');	
	Route::get('/datasets/{problem}/download', 'ProblemController@downloadDatasets')->name('problem.downloadDatasets');
	Route::get('/datasets/{problem}/{flag_update?}', 'ProblemController@datasets')->name('problem.datasets');

	//display
	Route::get('', 'ProblemController@index')->name('problem.index');
	Route::get('/gym/{problem}', 'ProblemController@show')->name('problem.show');	
	//admin
	Route::get('/admin', 'ProblemController@problemSetterProblems')->name('problem.problems');

});

//The Judgements Routes
Route::resource('judgment','JudgementController');

//Other Routes
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/home', 'HomeController@index')->name('home');


//Testing Route
Route::get('test',function(){
	
	return view('testing.test');
});