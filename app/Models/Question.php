<?php

namespace App\Models;

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

    public static function getQuestionTypes() {
        $question_types = [
            self::TYPE_SINGLE_TEXT   => trans('survey.question_type_single_text'),
            self::TYPE_MULTI_TEXT    => trans('survey.question_type_multi_text'),
            self::TYPE_SINGLE_CHOICE => trans('survey.question_type_single_choice'),
            self::TYPE_MULTI_CHOICE  => trans('survey.question_type_multi_choice'),
            self::TYPE_CONFIRMATION  => trans('survey.question_type_confirmation'),
        ];

        return $question_types;
    }

    public static function getQuestionCategories() {
        $question_categories = [
            self::CATEGORY_HEADER  => 'header',
            self::CATEGORY_CONTENT => 'content',
            self::CATEGORY_FOOTER  => 'footer',
        ];

        return $question_categories;
    }
}
