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
    return redirect()->guest('/login');
});

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);
});


Route::group(['middleware' => 'auth'], function () {
	Route::get('/home', 'HomeController@index')->name('home');

	Route::prefix('user')->group(function () {
		Route::get('/','UserController@index')->name('user.index');
		Route::get('/create','UserController@create')->name('user.create');
		Route::get('/{id}/edit','UserController@edit')->name('user.edit');
		Route::put('/{user}','UserController@update')->name('user.update');
		Route::post('/{user}/connect','UserController@connectStore')->name('user.connect.store');
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
		Route::post('/','SubscriptionController@store')->name('subscription.store');
		Route::get('/connect','SubscriptionController@connect')->name('subscription.connect');
		Route::get('/connect/{id}/create','SubscriptionController@connectCreate')->name('subscription.connect.create');
		Route::get('/{id}','SubscriptionController@show')->name('subscription.show');
	});

	Route::prefix('server')->group(function () {
		Route::get('/{id}','ServerController@show')->name('server.show');
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
		Route::get('/{id}/log/{pag}','ServerController@log')->name('log.index');

		Route::get('/{id}/service','ServerController@service')->name('service.index');
		Route::post('/{id}/service/update','ServerController@serviceUpdate')->name('service.update');

		Route::get('/{id}/security','ServerController@security')->name('security.index');
		Route::get('/{id}/security/{ip}/destroy','ServerController@securityDestroy')->name('security.destroy');

		Route::get('/{id}/cron','ServerController@cron')->name('cron.index');
		Route::get('/{id}/cron/create','ServerController@cronCreate')->name('cron.create');
		Route::post('/{id}/cron/store','ServerController@cronStore')->name('cron.store');
		Route::get('/{id}/cron/{idcr}/destroy','ServerController@cronDestroy')->name('cron.destroy');
		
		Route::get('/{id}/ssh','ServerController@ssh')->name('ssh.index');
		Route::get('/{id}/ssh/create','ServerController@sshCreate')->name('ssh.create');
		Route::post('/{id}/ssh/store','ServerController@sshStore')->name('ssh.store');
		Route::get('/{id}/ssh/{idssh}/destroy','ServerController@sshDestroy')->name('ssh.destroy');

		Route::get('/{id}/user','ServerController@user')->name('suser.index');
		Route::get('{id}/user/create','ServerController@userCreate')->name('suser.create');
		Route::post('/{id}/user/store','ServerController@userStore')->name('suser.store');
		Route::get('/{id}/user/{user}','ServerController@userShow')->name('suser.show');
		Route::get('/{id}/user/{idus}/update','ServerController@userUpdate')->name('suser.update');
		Route::get('/{id}/user/{idus}/destroy','ServerController@userDestroy')->name('suser.destroy');

		Route::get('/{id}/webapp','ServerController@webApp')->name('webapp.index');
		Route::post('{id}/webapp','ServerController@webAppStore')->name('webapp.store');
		Route::get('/{id}/webapp/create','ServerController@webAppCreate')->name('webapp.create');
		Route::get('/{id}/webapp/{idwa}/show','ServerController@webAppShow')->name('webapp.show');
		Route::get('/{id}/webapp/{idwa}/ssl','ServerController@webAppSsl')->name('webapp.ssl');
		Route::get('/{id}/webapp/{idwa}/edit','ServerController@webAppEdit')->name('webapp.edit');
		Route::post('{id}/webapp/{idwa}/update','ServerController@webAppUpdate')->name('webapp.update');
		Route::get('/{id}/webapp/{idwa}/rebuild','ServerController@webAppRebuild')->name('webapp.rebuild');
		Route::get('/{id}/webapp/{idwa}/default','ServerController@webAppDefault')->name('webapp.default');
		Route::get('/{id}/webapp/{idwa}/destroy','ServerController@webAppDestroy')->name('webapp.destroy');
		Route::get('/{id}/webapp/{idwa}/script','ServerController@webAppScript')->name('webapp.script');
		Route::post('/{id}/webapp/{idwa}/php','ServerController@webAppPHP')->name('webapp.php');
		Route::post('/{id}/webapp/{idwa}/script','ServerController@webAppScriptStore')->name('webapp.script.store');
		Route::get('/{id}/webapp/{idwa}/domain','ServerController@webAppDomain')->name('webapp.domain.index');
		Route::post('/{id}/webapp/{idwa}/domain/store','ServerController@webAppDomainStore')->name('webapp.domain.store');
		Route::get('/{id}/webapp/{idwa}/domain/{domain}','ServerController@webAppDomainDestroy')->name('webapp.domain.destroy');
		Route::get('/{id}/webapp/{idwa}/script/{script}','ServerController@webAppScriptDestroy')->name('webapp.script.destroy');
		
		Route::post('/{id}/webapp/{idwa}/ssl','ServerController@webAppSslStore')->name('webapp.ssl.store');
		Route::post('/{id}/webapp/{idwa}/ssl/{idssl}/update','ServerController@webAppSslUpdate')->name('webapp.ssl.update');
		Route::get('/{id}/webapp/{idwa}/ssl/{idssl}/destroy','ServerController@webAppSslDestroy')->name('webapp.ssl.destroy');
		
	});
	
	Route::get('{page}', ['as' => 'page.index', 'uses' => 'PageController@index']);
});

