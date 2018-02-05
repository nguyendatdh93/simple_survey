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

/**
 * Route for error page and setting datatable
 */
Route::get('/404', function (){
	return view('admin::errors.404');
})->name('404');
Route::get('/setup-lang', 'DatatableController@setupLanguage');
Route::get('/image/{image_path?}/{image_name?}', 'DatatableController@showImage')->name(\App\Survey::NAME_URL_SHOW_IMAGE);

/**
 * Route for authentication
 */
Route::get('/login', 'Auth\LoginController@showLoginForm')->name(\App\Survey::NAME_URL_LOGIN_PAGE);
Route::get('/', 'Auth\LoginController@showLoginForm');
Route::prefix('auth')->group(function () {
    Route::get('/google', array('as' => 'auth.google', 'uses' => 'Auth\LoginController@loginWithGoogle'));
});

/**
 * Route for admin site : survey list, download list, answer list
 */
Route::prefix('survey')->group(function () {
    Route::get('/close/{id?}', 'SurveyController@closeSurveyById')->name(\App\Survey::NAME_URL_CLOSE_SURVEY);
    Route::get('/list', 'SurveyController@showListSurvey')->name(\App\Survey::NAME_URL_SURVEY_LIST);
    Route::get('/edit/{id?}', 'SurveyController@edit')->name(\App\Survey::NAME_URL_EDIT_SURVEY);
    Route::get('/duplicate/{id?}', 'SurveyController@duplicate')->name(\App\Survey::NAME_URL_DUPLICATE_SURVEY);
    Route::get('/new', 'SurveyController@edit')->name(\App\Survey::NAME_URL_CREATE_SURVEY);
    Route::post('/save', 'SurveyController@save')->name(\App\Models\Survey::NAME_URL_SAVE_SURVEY);
    Route::get('/editing/preview', 'SurveyController@loadPagePreviewSurvey')->name(\App\Models\Survey::NAME_URL_EDITING_PREVIEW);
    Route::post('/editing/preview', 'SurveyController@getDataForPagePreviewSurvey')->name(\App\Models\Survey::NAME_URL_EDITING_PREVIEW);
	Route::get('/preview/{id?}', 'SurveyController@preview')->name(\App\Survey::NAME_URL_PREVIEW);
});

Route::prefix('download')->group(function () {
    Route::get('/list', 'SurveyController@showDownloadListSurvey')->name(\App\Survey::NAME_URL_DOWNLOAD_LIST);
    Route::get('/answer/{id?}', 'SurveyController@showDownloadPageSurveyBySurveyId')->name(\App\Survey::NAME_URL_DOWNLOAD_PAGE_SURVEY);
    Route::get('/csv/{id?}', 'SurveyController@downloadSurveyCSVFile')->name(\App\Survey::NAME_URL_DOWNLOAD_SURVEY);
    Route::get('/clear/{id?}', 'SurveyController@clearDataBySurveyId')->name(\App\Survey::NAME_URL_CLEAR_DATA_SURVEY);
});

/**
 * Route for user's page answer
 */
Route::prefix('/')->group(function () {
	Route::get('/thank', 'AnswerSurveyController@showThankPage')->name(\App\Survey::NAME_URL_THANK_PAGE);
	Route::get('/{encrypt?}', 'AnswerSurveyController@showQuestionSurvey')->name(\App\Survey::NAME_URL_ANSWER_SURVEY);
	Route::post('/confirm/{encrypt?}', 'AnswerSurveyController@showFormConfirmAnswerSurvey')->name(\App\Survey::NAME_URL_ANSWER_CONFIRM);
	Route::get('/answer/{encrypt?}', 'AnswerSurveyController@answerSurvey')->name(\App\Survey::NAME_URL_SUBMIT_CONFIRM);
});

