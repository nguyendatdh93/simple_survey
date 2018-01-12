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

Route::get('/', 'SurveyController@index');

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
    Route::get('/list', 'SurveyController@index')->name(\App\Survey::NAME_URL_SURVEY_LIST);
    Route::get('/new', 'SurveyController@edit');
    Route::get('/edit/{id?}', 'SurveyController@edit');
    Route::get('/duplicate/{id?}', 'SurveyController@duplicate');
    Route::post('/save', 'SurveyController@save');
});

Route::prefix('download')->group(function () {
    Route::get('/list', 'SurveyController@downloadListSurvey')->name(\App\Survey::NAME_URL_DOWNLOAD_LIST);
    Route::get('/answer/{id?}', 'SurveyController@downloadPageSurveyBySurveyId')->name(\App\Survey::NAME_URL_DOWNLOAD_PAGE_SURVEY);
    Route::get('/csv/{id?}', 'SurveyController@downloadSurveyCSVFile')->name(\App\Survey::NAME_URL_DOWNLOAD_SURVEY);
});

Route::group(['middleware' => 'auth'], function () {
});

//example
Route::get('/home', 'SurveyController@index');
Route::get('/form', 'HomeController@form');
Route::get('/table', 'HomeController@table');
Route::get('/posts', 'PostController@index');

Route::get('/users', 'UserController@index');


Route::get('/404', function (){
    return view('admin::errors.404');
});
