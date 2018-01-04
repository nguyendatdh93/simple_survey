<?php

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

Route::get('/', 'HomeController@index');

Route::prefix('auth')->group(function () {
    Route::get('/google', array('as' => 'auth.google', 'uses' => 'Auth\LoginController@loginWithGoogle'));
});

Route::get('/preview', 'SurveyController@preview');
Route::get('/publish/{id}', 'SurveyController@publishSurveyById');


Route::group(['middleware' => 'auth'], function () {
});

//example
Route::get('/home', 'HomeController@index');
Route::get('/form', 'HomeController@form');
Route::get('/table', 'HomeController@table');
Route::get('/posts', 'PostController@index');

Route::get('/users', 'UserController@index');
