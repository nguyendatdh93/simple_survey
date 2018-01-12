<?php

namespace App\Http\Controllers;

use App\Http\Services\EncryptionService;
use App\Http\Services\SurveyService;
use App\Http\Validators\SurveyValidator;
use App\Question;
use App\Repositories\Contracts\AnswerQuestionRepositoryInterface;
use App\Repositories\Contracts\AnswerRepositoryInterface;
use App\Repositories\Contracts\ConfirmContentRepositoryInterface;
use App\Repositories\Contracts\ConfirmContentsRepositoryInterface;
use App\Repositories\Contracts\QuestionChoiceRepositoryInterface;
use App\Repositories\Contracts\QuestionRepositoryInterface;
use App\Repositories\Contracts\SurveyRepositoryInterface;
use App\Survey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use OAuth\Common\Storage\Session;

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
		$encryption_service    = new EncryptionService();
		$id                    = $encryption_service->decrypt($encrypt);
		$survey_service        = new SurveyService();
		$survey                = $survey_service->getDataSurvey($id);
		$survey['encrypt_url'] = $encrypt;
		
		return view('admin::answer', array('survey' => $survey));
	}
	
	public function showFormConfirmAnswerSurvey(Request $request, $encrypt)
	{
		$input               = Input::get();
		$surveyValidator     = new SurveyValidator();
		if (!$surveyValidator->validateAnswerSurvey($input)) {
			return redirect('404');
		}
		
		$encryption_service  = new EncryptionService();
		$id                  = $encryption_service->decrypt($encrypt);
		$survey              = $this->surveyRepository->getSurveyById($id);
		$survey['questions'] = $this->questionRepository->getQuestionSurveyWithoutConfirmTypeBySurveyId($id);
		
		foreach ($survey['questions'] as $key => $question) {
			if ($question['type'] == Question::TYPE_SINGLE_CHOICE) {
				$answer = array(
					$input[$question['id']] => $this->questionChoiceRepository->getChoiceTextByChoiceId($input[$question['id']]),
				);
				
				$survey['questions'][$key]['answer'] = $answer;
			} elseif ($question['type'] == Question::TYPE_MULTI_CHOICE) {
				$answer = array();
				foreach ($input[$question['id']] as $choice_id) {
					$answer[$choice_id] = $this->questionChoiceRepository->getChoiceTextByChoiceId($choice_id);
				}
				
				$survey['questions'][$key]['answer'] = $answer;
			} else {
				$survey['questions'][$key]['answer'] = $input[$question['id']];
			}
		}
		
		$survey['encrypt_url'] = $encrypt;
		$request->session()->put('answer', $survey);
		
		return view('admin::answer_confirm', array('survey' => $survey));
	}
	
	public function answerSurvey(Request $request)
	{
		$survey = $request->session()->get('answer');
		try {
			$id_answer = $this->answerRepository->save($survey['id']);
			foreach ($survey['questions'] as $question) {
				if (is_array($question['answer'])) {
					$answer_text = "";
					foreach($question['answer'] as $text) {
						$answer_text = $answer_text . ',' . $text['text'];
					}
					
					$answer_text = trim($answer_text, ',');
				} else {
					$answer_text = $question['answer'];
				}
				
				$data = array(
					'answer_id'   => $id_answer,
					'question_id' => $question['id'],
					'text'        => $answer_text,
				);
				
				$this->answerQuestionRepository->save($data);
			}
		}catch (\Exception $e) {
			return view('admin::answer_confirm', array('survey' => $request->session()->get('answer')));
		}
		
		return view('admin::answer_confirm', array('survey' => $request->session()->get('answer')));
	}
}
