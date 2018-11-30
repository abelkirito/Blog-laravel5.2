<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/','Home\IndexController@index');
Route::get('/cate/{cate_id}','Home\IndexController@cate');
Route::get('/a/{art_id}','Home\IndexController@article');
Route::any('admin/login','Admin\LoginController@login');
Route::get('admin/code','Admin\LoginController@code');
Route::group(['middleware'=>['web','admin.login'],'prefix'=>'admin','namespace'=>'Admin'],function(){
    Route::get('index','IndexController@index');
    Route::get('info','IndexController@info');
    Route::any('pass','IndexController@pass');
    Route::any('quit','LoginController@quit');
    Route::resource('category','CategoryController');
    Route::post('cate/changeOrder','CategoryController@changeOrder');
    Route::resource('article','ArticleController');
    Route::any('upload','CommonController@upload');
    Route::resource('links','LinksController');
    Route::post('links/changeOrder','LinksController@changeOrder');
    Route::resource('navs','NavsController');
    Route::post('navs/changeOrder','NavsController@changeOrder');
    Route::resource('config','ConfigController');
    Route::post('config/changeOrder','ConfigController@changeOrder');
    Route::post('config/changeContent','ConfigController@changeContent');
    Route::get('config/putfile/into','ConfigController@putFile');
});
