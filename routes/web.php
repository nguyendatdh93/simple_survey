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
Route::get('/login', 'Auth\LoginController@showLoginForm')->name(\App\Survey::NAME_URL_LOGIN_PAGE);

Route::prefix('auth')->group(function () {
    Route::get('/google', array('as' => 'auth.google', 'uses' => 'Auth\LoginController@loginWithGoogle'));
});

Route::prefix('survey')->group(function () {
    Route::get('/close/{id?}', 'SurveyController@closeSurveyById')->name(\App\Survey::NAME_URL_CLOSE_SURVEY);
    Route::get('/list', 'SurveyController@showListSurvey')->name(\App\Survey::NAME_URL_SURVEY_LIST);
    Route::get('/edit/{id?}', 'SurveyController@edit')->name(\App\Survey::NAME_URL_EDIT_SURVEY);
    Route::get('/duplicate/{id?}', 'SurveyController@duplicate')->name(\App\Survey::NAME_URL_DUPLICATE_SURVEY);
    Route::get('/new', 'SurveyController@edit')->name(\App\Survey::NAME_URL_CREATE_SURVEY);
    Route::post('/save', 'SurveyController@save');
    Route::get('/editing/preview', 'SurveyController@editingPreview');
    Route::post('/editing/preview', 'SurveyController@postEditingPreview');
	Route::get('/preview/{id?}', 'SurveyController@preview')->name(\App\Survey::NAME_URL_PREVIEW);
});

Route::prefix('download')->group(function () {
    Route::get('/list', 'SurveyController@showDownloadListSurvey')->name(\App\Survey::NAME_URL_DOWNLOAD_LIST);
    Route::get('/answer/{id?}', 'SurveyController@showDownloadPageSurveyBySurveyId')->name(\App\Survey::NAME_URL_DOWNLOAD_PAGE_SURVEY);
    Route::get('/csv/{id?}', 'SurveyController@downloadSurveyCSVFile')->name(\App\Survey::NAME_URL_DOWNLOAD_SURVEY);
    Route::get('/clear/{id?}', 'SurveyController@clearDataBySurveyId')->name(\App\Survey::NAME_URL_CLEAR_DATA_SURVEY);
});

Route::group(['middleware' => 'auth'], function () {
});

Route::get('/users', 'UserController@index');


Route::get('/404', function (){
    return view('admin::errors.404');
})->name('404');

Route::get('/setup-lang', 'HomeController@setupLanguage');
Route::get('/image/{image_path?}/{image_name?}', 'HomeController@showImage')->name(\App\Survey::NAME_URL_SHOW_IMAGE);

Route::get('/', 'Auth\LoginController@showLoginForm');

Route::prefix('/')->group(function () {
	Route::get('/thank', 'AnswerSurveyController@showThankPage')->name(\App\Survey::NAME_URL_THANK_PAGE);
	Route::get('/{encrypt?}', 'AnswerSurveyController@showQuestionSurvey')->name(\App\Survey::NAME_URL_ANSWER_SURVEY);
	Route::get('/{encrypt?}/confirm', 'AnswerSurveyController@showFormConfirmAnswerSurvey')->name(\App\Survey::NAME_URL_ANSWER_CONFIRM);
	Route::get('/{encrypt?}/answer', 'AnswerSurveyController@answerSurvey')->name(\App\Survey::NAME_URL_SUBMIT_CONFIRM);
});


Route::get('/form-survey', 'AnswerSurveyController@index');
