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
		Route::get('/','ServerController@index')->name('server.index');
		Route::get('/list','ServerController@list')->name('server.list');
		Route::get('/{id}/create','ServerController@create')->name('server.create');
		Route::get('/{id}','ServerController@show')->name('server.show');
		Route::post('/','ServerController@store')->name('server.store');
	});

	Route::prefix('webapp')->group(function () {
		Route::get('/','WebAppController@index')->name('webapp.index');
		Route::get('/{id}/list','WebAppController@list')->name('webapp.list');
		Route::get('/{id}/create','WebAppController@create')->name('webapp.create');
		Route::get('/{id}','WebAppController@show')->name('webapp.show');
		Route::post('/','WebAppController@store')->name('webapp.store');
	});
	
	Route::get('{page}', ['as' => 'page.index', 'uses' => 'PageController@index']);
});

