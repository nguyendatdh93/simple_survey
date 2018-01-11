<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $table = "questions";

    const TYPE_SINGLE_TEXT   = 1;
    const TYPE_MULTI_TEXT    = 2;
    const TYPE_SINGLE_CHOICE = 3;
    const TYPE_MULTI_CHOICE  = 4;
    const TYPE_CONFIRMATION  = 5;

    const CATEGORY_HEADER  = 1;
    const CATEGORY_CONTENT = 2;
    const CATEGORY_FOOTER  = 3;

    const REQUIRE_QUESTION_YES = 1;
    const REQUIRE_QUESTION_NO  = 0;
    
    const DELETE_FLG = 1;
}
