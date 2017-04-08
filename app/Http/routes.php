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
$api = app('Dingo\Api\Routing\Router');

//api接口路由
$api->version('v1', function ($api) {
    $api->group(['namespace' => 'App\Api\V1\Controllers'], function ($api) {
        // Endpoints registered here will have the "foo" middleware applied.
        $api->get('/', 'TestApiController@index');
        $api->resource('getData', 'ApiController');
    });
});

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
    Route::get('testmolde', 'IndexController@pass');

    Route::resource('category', 'CategoryController');
    Route::resource('article', 'ArticleController');
    Route::resource('link', 'LinkController');
    Route::post('cate/changeOrder', 'CategoryController@changeOrder');
    Route::post('link/changeOrder', 'LinkController@changeOrder');
    Route::any('upload', 'PublicController@upload');
});


Route::get('admin/code', 'Admin\LoginController@code');
Route::get('api/getData', 'Api\GetDataController@getData');
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
