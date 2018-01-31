<?php
namespace App\Http\Services;
/**
 * Created by PhpStorm.
 * User: atb
 * Date: 11/01/2018
 * Time: 09:44
 */

use App\Http\Controllers\Controller;
use App\Http\Middleware\SecureDownloadSurvey;
use App\Http\Requests;
use App\Http\Services\EncryptionService;
use App\Question;
use App\Repositories\Eloquents\AnswerQuestionRepository;
use App\Repositories\Eloquents\AnswerRepository;
use App\Repositories\Eloquents\ConfirmContentsRepository;
use App\Repositories\Eloquents\QuestionChoiceRepository;
use App\Repositories\Eloquents\QuestionRepository;
use App\Repositories\Eloquents\SurveyRepository;
use App\Survey;
use Illuminate\Support\Facades\Request;
use Response;
use Config;
use File;

class SurveyService
{
	protected $surveyRepository;
	protected $questionRepository;
	protected $questionChoiceRepository;
	protected $confirmContentRepository;
	protected $answerRepository;
	protected $answerQuestionRepository;
	
	public function __construct()
	{
		$this->surveyRepository         = new SurveyRepository();
		$this->questionRepository       = new QuestionRepository();
		$this->questionChoiceRepository = new QuestionChoiceRepository();
		$this->confirmContentRepository = new ConfirmContentsRepository();
		$this->answerRepository         = new AnswerRepository();
		$this->answerQuestionRepository = new AnswerQuestionRepository();
		$this->confirmContentRepository = new ConfirmContentsRepository();
	}
	
	public function getImageName($image_path)
	{
		$explode_image_path = explode('/', $image_path);
		if (count($explode_image_path ) < 2) {
			return '';
		}
		
		return $explode_image_path[count($explode_image_path) - 2] . '/'. end($explode_image_path);
	}
	
	public function getDataAnswerForSurvey($survey, $answer = array())
	{
		$survey['image_path'] = route(Survey::NAME_URL_SHOW_IMAGE).'/'.$this->getImageName($survey['image_path']);
		$survey['questions']  = $this->questionRepository->getQuestionSurveyBySurveyId($survey['id']);
		foreach ($survey['questions'] as $key => $question) {
			$question_choices = $this->questionChoiceRepository->getQuestionChoiceByQuestionId($question['id']);
			if (count($question_choices) > 0) {
				$survey['questions'][$key]['question_choices'] = $question_choices;
			}
			
			$confirm_content = $this->confirmContentRepository->getConfirmContentByQuestionId($question['id']);
			if (count($confirm_content) > 0) {
				$survey['questions'][$key]['confirm_contents'] = $confirm_content;
			}
		}
		
		$group_question_survey = array();
		foreach ($survey['questions'] as $question) {
			if (count($answer)) {
				$key_answer = array_search($question['id'], array_column($answer, 'id'));
				if (Question::TYPE_MULTI_TEXT == $question['type'] || Question::TYPE_SINGLE_TEXT == $question['type']) {
					$question['answer'] = isset($answer[$key_answer]['answer']) ? $answer[$key_answer]['answer'] : '';
				} else {
					$question['answer'] = isset($answer[$key_answer]['answer']) ? $answer[$key_answer]['answer'] : array();
				}
			}
			$group_question_survey[$question['category']][] = $question;
		}
		
		$survey['questions'] = $group_question_survey;
		
		return $survey;
	}
	
	function convertTextWithXSSSafe($text,$encoding='UTF-8')
	{
		return htmlspecialchars($text,ENT_QUOTES | ENT_HTML401,$encoding);
	}
	
	public function redirectIfAuthenticated($request)
	{
		$prefix       =  trim($request->route()->getPrefix(),"/");
		$auth_service = new AuthService();
		if ($auth_service->isSecurePrivateRange($request->ip())) {
			if ($prefix == '' || $prefix == 'home') {
				return Survey::NAME_URL_DOWNLOAD_LIST;
			}
			
			if (!in_array($prefix,array('download'))) {
				return '404';
			}
		} else {
			if ($prefix == '' || $prefix == 'home') {
				return Survey::NAME_URL_SURVEY_LIST;
			}
			
			if (in_array($prefix,array('download'))) {
				return '404';
			}
		}
	}
}