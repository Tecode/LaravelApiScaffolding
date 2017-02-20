<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


Route::group(['middleware' => ['web']], function () {
    Route::get('/', function () {
        return view('welcome');
    });
    Route::any('admin/login', 'Admin\LoginController@login');


});

Route::group(['middleware' => ['web', 'admin.login'], 'namespace' => 'Admin', 'prefix' => 'admin'], function () {
    Route::get('/', function () {
        return view('welcome');
    });
    Route::any('crypt', 'LoginController@crypt');
    Route::get('index', 'IndexController@index');
    Route::get('info', 'IndexController@info');
    Route::get('loginout', 'IndexController@loginOut');
    Route::any('pass', 'IndexController@pass');

    Route::resource('category', 'CategoryController');
    Route::resource('article', 'ArticleController');
    Route::resource('link', 'LinkController');
    Route::post('cate/changeOrder', 'CategoryController@changeOrder');
    Route::post('link/changeOrder', 'LinkController@changeOrder');
    Route::any('upload', 'PublicController@upload');
});


Route::get('admin/code', 'Admin\LoginController@code');

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    //
});
