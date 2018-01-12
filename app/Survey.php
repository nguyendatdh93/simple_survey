<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    protected $table = "surveys";

    const STATUS_SURVEY_DRAF      = 0;
    const STATUS_SURVEY_PUBLISHED = 1;
    const STATUS_SURVEY_CLOSED    = 2;

    const NAME_URL_PREVIEW_PUBLISH = 'publish';
    const NAME_URL_PREVIEW_CLOSE   = 'close';
    const NAME_URL_PREVIEW_DRAF    = 'draf';

    const NAME_URL_SURVEY_LIST    = 'survey-list';
    const NAME_URL_PUBLISH_SURVEY = 'publish-survey';
    const NAME_URL_CLOSE_SURVEY   = 'close-survey';
    const NAME_URL_CREATE_SURVEY  = 'create-new-survey';
    const NAME_URL_ANSWER_SURVEY  = 'answer-survey';
	const NAME_URL_ANSWER_CONFIRM = 'answer-survey-confirm';
	const NAME_URL_SUBMIT_CONFIRM = 'answer-survey-submit';

    const NAME_URL_DOWNLOAD_LIST          = 'download-list';
    const NAME_URL_DOWNLOAD_SURVEY        = 'download-survey';
    const NAME_URL_DOWNLOAD_PAGE_SURVEY   = 'download-page-survey';
    const NAME_URL_CLEAR_DATA_SURVEY      = 'clear-data-survey';

    const DELETE_FLG = 1;
}
