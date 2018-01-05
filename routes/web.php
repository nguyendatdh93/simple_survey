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

Route::prefix('preview')->group(function () {
    Route::get('/publish/{id?}', 'SurveyController@preview')->name(\App\Survey::NAME_URL_PREVIEW_PUBLISH);
    Route::get('/close/{id?}', 'SurveyController@preview')->name(\App\Survey::NAME_URL_PREVIEW_CLOSE);
    Route::get('/draf/{id?}', 'SurveyController@preview')->name(\App\Survey::NAME_URL_PREVIEW_DRAF);
});

Route::prefix('survey')->group(function () {
    Route::get('/publish/{id?}', 'SurveyController@publishSurveyById')->name(\App\Survey::NAME_URL_PUBLISH_SURVEY);
    Route::get('/close/{id?}', 'SurveyController@closeSurveyById')->name(\App\Survey::NAME_URL_CLOSE_SURVEY);
    Route::get('/list', 'SurveyController@index');
});

Route::prefix('download')->group(function () {
    Route::get('/list', 'SurveyController@downloadListSurvey');
});

Route::group(['middleware' => 'auth'], function () {
});

//example
Route::get('/home', 'HomeController@index');
Route::get('/form', 'HomeController@form');
Route::get('/table', 'HomeController@table');
Route::get('/posts', 'PostController@index');

Route::get('/users', 'UserController@index');
