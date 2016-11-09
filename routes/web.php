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
	//admin
	Route::get('/admin/users', 'Auth\RegisterController@users')->name('user.users');
	Route::put('/admin/users', 'Auth\RegisterController@changeUserRole')->name('user.changeUserRole');


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
Route::get('judgment/create/{id}', 'JudgementController@create')->name('judgment.create');


//The Contest Routes
Route::group(['prefix' => 'contest'], function (){
	//create
	Route::get('/create', 'ContestController@create')->name('contest.create');
	Route::post('', 'ContestController@store')->name('contest.store');
	//admin
	Route::get('/admin', 'ContestController@contests')->name('contest.contests');
	//update
	Route::get('/{contest}/edit', 'ContestController@edit')->name('contest.edit');
	Route::put('/update/{contest}', 'ContestController@update')->name('contest.update');
	//delete
	Route::delete('/{contest}', 'ContestController@destroy')->name('contest.destroy');
	//display
	Route::get('', 'ContestController@index')->name('contest.index');
	Route::get('/gym/{contest}', 'ContestController@show')->name('contest.show');
	Route::get('/gym/problem/{problem}', 'ContestController@showProblem')->name('contest.show.problem');
	Route::get('/gym/judgments/{contest}', 'ContestController@showJudgments')->name('contest.show.judgments');	


	/*//limits
	Route::get('/limits/{contest}/{flag_update?}', 'contestController@limits')->name('contest.limits');
	Route::put('/limits/{contest}', 'contestController@assignLimits')->name('contest.assignLimits');
	//datasets
	Route::put('/datasets/{contest}', 'contestController@assignDatasets')->name('contest.assignDatasets');
	Route::get('/datasets/{contest}/delete', 'contestController@deleteDatasets')->name('contest.deleteDatasets');	
	Route::get('/datasets/{contest}/download', 'contestController@downloadDatasets')->name('contest.downloadDatasets');
	Route::get('/datasets/{contest}/{flag_update?}', 'contestController@datasets')->name('contest.datasets');


	//admin
	Route::get('/admin', 'contestController@contestSettercontests')->name('contest.problems');*/

});






//Other Routes
Route::get('/', function () {
    return view('welcome');
})->name('welcome');


//Testing Route
Route::get('test',function(){
	
	return view('testing.test');
});

