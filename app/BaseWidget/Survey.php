<?php
/**
 * Created by PhpStorm.
 * User: nguyen-dat
 * Date: 19/11/2017
 * Time: 09:12
 */

namespace App\BaseWidget;

class Survey
{
	/**
	 * @param $questionText
	 * @param array $paramAttributes
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public static function singleText($question, $paramAttributes = array())
	{
		$indentify                = ' question_' . $question['id'] . '_' . $question['survey_id'] . '_text';
		$paramAttributes['class'] = $paramAttributes['class'] . $indentify;
		$paramAttributes['name']  = $question['id'];
		
		return view('admin::survey.partials.single_text', array('question' => $question, 'data_attributes' => $paramAttributes));
	}
	
	/**
	 * @param $questionText
	 * @param array $paramAttributes
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public static function multiText($question, $paramAttributes = array())
	{
		$indentify                = ' question_' . $question['id'] . '_' . $question['survey_id'] . '_text';
		$paramAttributes['class'] = $paramAttributes['class'] . $indentify;
		$paramAttributes['name']  = $question['id'];
		
		return view('admin::survey.partials.multi_text', array('question' => $question, 'data_attributes' => $paramAttributes));
	}
	
	/**
	 * @param $questionText
	 * @param $choices
	 * @param array $paramAttributes
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public static function singleChoice($question, $choices, $paramAttributes = array())
	{
		$paramAttributes['name'] = $question['id'];
		
		return view('admin::survey.partials.single_choice', array('question' => $question, 'choices' => $choices, 'data_attributes' => $paramAttributes));
	}
	
	/**
	 * @param $questionText
	 * @param $choices
	 * @param array $paramAttributes
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public static function multiChoice($question, $choices, $paramAttributes = array())
	{
		$paramAttributes['name'] = $question['id']."[]";
		
		return view('admin::survey.partials.multi_choice', array('question' => $question, 'choices' => $choices, 'data_attributes' => $paramAttributes));
	}
	
	public static function termConfirm($question, $confirms, $choices, $paramAttributes = array())
	{
		return view('admin::survey.partials.confirm_condition', array('question' => $question, 'confirms' => $confirms, 'choices' => $choices, 'data_attributes' => $paramAttributes));
	}
	
	/**
	 * @param $surveyContent
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public static function formAnswerPattern($surveyContents)
	{
		return view('admin::survey.partials.form_answer_pattern', array('survey_contents' => $surveyContents));
	}
}