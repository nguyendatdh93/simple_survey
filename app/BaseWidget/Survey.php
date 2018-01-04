<?php
/**
 * Created by PhpStorm.
 * User: nguyen-dat
 * Date: 19/11/2017
 * Time: 09:12
 */
namespace App\BaseWidget;

use \App\BaseWidget\Validator;
use Illuminate\Support\Facades\View;

class Survey
{
    /**
     * @param $questionText
     * @param array $paramAttributes
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public static function singleText($questionText, $paramAttributes = array())
    {
        return view('admin::layouts.survey_partials.single_text', array('question_text' => $questionText, 'data_attributes' => $paramAttributes));
    }

    /**
     * @param $questionText
     * @param array $paramAttributes
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public static function multiText($questionText, $paramAttributes = array())
    {
        return view('admin::layouts.survey_partials.multi_text', array('question_text' => $questionText, 'data_attributes' => $paramAttributes));
    }

    /**
     * @param $questionText
     * @param $choices
     * @param array $paramAttributes
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public static function singleChoice($questionText, $choices, $paramAttributes = array())
    {
        return view('admin::layouts.survey_partials.single_choice', array('question_text' => $questionText, 'choices' => $choices, 'data_attributes' => $paramAttributes));
    }

    /**
     * @param $questionText
     * @param $choices
     * @param array $paramAttributes
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public static function multiChoice($questionText, $choices, $paramAttributes = array())
    {
        return view('admin::layouts.survey_partials.multi_choice', array('question_text' => $questionText, 'choices' => $choices, 'data_attributes' => $paramAttributes));
    }

    /**
     * @param $surveyContent
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public static function formAnswerPattern($surveyContents)
    {
        return view('admin::layouts.survey_partials.form_answer_pattern', array('survey_contents' => $surveyContents));
    }
}