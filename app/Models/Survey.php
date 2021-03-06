<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    protected $table = "surveys";

    const STATUS_SURVEY_DRAFT      = 0;
    const STATUS_SURVEY_PUBLISHED  = 1;
    const STATUS_SURVEY_CLOSED     = 2;
	const STATUS_SURVEY_DOWNLOADED = 1;

    const NAME_URL_PREVIEW          = 'preview';
    const NAME_URL_EDITING_PREVIEW  = 'editing-preview';
    const NAME_URL_SURVEY_LIST      = 'survey-list';
    const NAME_URL_PUBLISH_SURVEY   = 'publish-survey';
    const NAME_URL_CLOSE_SURVEY     = 'close-survey';
    const NAME_URL_CREATE_SURVEY    = 'create-new-survey';
	const NAME_URL_EDIT_SURVEY      = 'edit-survey';
	const NAME_URL_SAVE_SURVEY      = 'save-survey';
    const NAME_URL_ANSWER_SURVEY    = 'answer-survey';
	const NAME_URL_ANSWER_CONFIRM   = 'answer-survey-confirm';
	const NAME_URL_SUBMIT_CONFIRM   = 'answer-survey-submit';
	const NAME_URL_DUPLICATE_SURVEY = 'duplicate-survey';
	const NAME_URL_SHOW_IMAGE       = 'show-image';
	const NAME_URL_THANK_PAGE       = 'thank-page';
	const NAME_URL_LOGIN_PAGE       = 'login-page';

    const NAME_URL_DOWNLOAD_LIST        = 'download-list';
    const NAME_URL_DOWNLOAD_SURVEY      = 'download-survey';
    const NAME_URL_DOWNLOAD_PAGE_SURVEY = 'download-page-survey';
    const NAME_URL_CLEAR_DATA_SURVEY    = 'clear-data-survey';

    const DELETE_FLG     = 1;
	const CLEAR_DATA_FLG = 1;

    const THUMBNAIL_DIMENSION_WIDTH  = 960;
    const THUMBNAIL_DIMENSION_HEIGHT = 300;
}
