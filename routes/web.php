<?php

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
    return view('welcome');
});

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
	Route::put('profile/paymethods', ['as' => 'profile.paymethods', 'uses' => 'ProfileController@paymethods']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);
});


Route::group(['middleware' => 'auth'], function () {
	Route::get('/home', 'HomeController@index')->name('home');

	Route::prefix('user')->group(function () {
		Route::get('/','UserController@index')->name('user.index');
		Route::get('/create','UserController@create')->name('user.create');
		Route::get('/{id}/edit','UserController@edit')->name('user.edit');
		Route::put('/{user}','UserController@update')->name('user.update');
		Route::post('/','UserController@store')->name('user.store');
	});

	Route::prefix('plan')->group(function () {
		Route::get('/','PlanController@index')->name('plan.index');
		Route::get('/create','PlanController@create')->name('plan.create');
		Route::post('/','PlanController@store')->name('plan.store');
	});
	
	Route::prefix('subscription')->group(function () {
		Route::get('/','SubscriptionController@index')->name('subscription.index');
		Route::get('/create','SubscriptionController@create')->name('subscription.create');
		Route::get('/{id}','SubscriptionController@show')->name('subscription.show');
		Route::post('/','SubscriptionController@store')->name('subscription.store');
	});

	Route::prefix('server')->group(function () {
		Route::get('/{id}/database','ServerController@database')->name('database.index');
		Route::get('/{id}/database/{iddb}/show','ServerController@databaseShow')->name('database.show');	
		Route::get('/{id}/database/create','ServerController@databaseCreate')->name('database.create');
		Route::get('{id}/database/create-user','ServerController@databaseCreateUser')->name('database.create.user');
		Route::post('{id}/database/store','ServerController@databaseStore')->name('database.store');
		Route::post('{id}/database/store-user','ServerController@databaseStoreUser')->name('database.store.user');
		Route::get('{id}/database/{iddb}/attach','ServerController@databaseAttach')->name('database.attach');
		Route::get('{id}/database/{iddb}/destroy','ServerController@databaseDestroy')->name('database.destroy');
		Route::get('{id}/database/{iddb}/revoke/{user}','ServerController@databaseRevokeUser')->name('database.revoke.user');
		Route::get('{id}/database/{idus}/update-user','ServerController@databaseUpdateUser')->name('database.update.user');
		Route::get('{id}/database/{idus}/destroy-user','ServerController@databaseDestroyUser')->name('database.destroy.user');
		Route::get('/{id}/create','ServerController@create')->name('server.create');
		Route::get('/{id}/webapp','ServerController@webApp')->name('webapp.index');
		Route::post('{id}/webapp','ServerController@webAppStore')->name('webapp.store');
		Route::get('/{id}/webapp/create','ServerController@webAppCreate')->name('webapp.create');
		Route::get('/{id}/webapp/{idwa}/show','ServerController@webAppShow')->name('webapp.show');
		Route::get('/{id}/webapp/{idwa}/rebuild','ServerController@webAppRebuild')->name('webapp.rebuild');
		Route::get('/{id}/webapp/{idwa}/default','ServerController@webAppDefault')->name('webapp.default');
		Route::get('/{id}/webapp/{idwa}/destroy','ServerController@webAppDestroy')->name('webapp.destroy');
		Route::post('/{id}/webapp/{idwa}/script','ServerController@webAppScript')->name('webapp.script');
		Route::get('/{id}/webapp/{idwa}/script/{script}','ServerController@webAppScriptDestroy')->name('webapp.script.destroy');
		Route::get('/','ServerController@index')->name('server.index');
		Route::get('/list','ServerController@list')->name('server.list');
		Route::get('/{id}','ServerController@show')->name('server.show');
		Route::post('/','ServerController@store')->name('server.store');
	});
	
	Route::get('{page}', ['as' => 'page.index', 'uses' => 'PageController@index']);
});

