<?php

namespace App\Http\Controllers;

use App\Http\Services\EncryptionService;
use App\Http\Services\SurveyService;
use App\Repositories\Contracts\AnswerQuestionRepositoryInterface;
use App\Repositories\Contracts\AnswerRepositoryInterface;
use App\Repositories\Contracts\ConfirmContentRepositoryInterface;
use App\Repositories\Contracts\ConfirmContentsRepositoryInterface;
use App\Repositories\Contracts\QuestionChoiceRepositoryInterface;
use App\Repositories\Contracts\QuestionRepositoryInterface;
use App\Repositories\Contracts\SurveyRepositoryInterface;

class AnswerSurveyController extends Controller
{
	protected $surveyRepository;
	protected $questionRepository;
	protected $questionChoiceRepository;
	protected $confirmContentRepository;
	protected $answerRepository;
	protected $answerQuestionRepository;
	
	public function __construct(SurveyRepositoryInterface $surveyRepository,
	                            QuestionRepositoryInterface $questionRepository,
	                            QuestionChoiceRepositoryInterface $questionChoiceRepository,
	                            ConfirmContentsRepositoryInterface $confirmContentRepository,
	                            AnswerRepositoryInterface $answerRepository,
	                            AnswerQuestionRepositoryInterface $answerQuestionRepository)
	{
		$this->surveyRepository         = $surveyRepository;
		$this->questionRepository       = $questionRepository;
		$this->questionChoiceRepository = $questionChoiceRepository;
		$this->confirmContentRepository = $confirmContentRepository;
		$this->answerRepository         = $answerRepository;
		$this->answerQuestionRepository = $answerQuestionRepository;
		$this->confirmContentRepository = $confirmContentRepository;
	}
	
	public function index()
	{
		return view('admin::form_survey');
	}
	
	public function showQuestionSurvey($encrypt)
	{
		$encryption_service   = new EncryptionService();
		$id                   = $encryption_service->decrypt($encrypt);
		$survey               = $this->surveyRepository->getSurveyById($id);
		$survey_service       = new SurveyService();
		$survey['image_path'] = \route('show-image').'/'.$survey_service->getImageName($survey['image_path']);
		$survey['questions']  = $this->questionRepository->getQuestionSurveyBySurveyId($id);
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
			$group_question_survey[$question['category']][] = $question;
		}
		
		$survey['questions']      = $group_question_survey;
	}
}
