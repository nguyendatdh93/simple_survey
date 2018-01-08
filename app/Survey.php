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

    const NAME_URL_PUBLISH_SURVEY = 'publish-survey';
    const NAME_URL_CLOSE_SURVEY   = 'close-survey';

    const NAME_URL_DOWNLOAD_SURVEY   = 'download-survey';
}
