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
	protected $encryption_service;
	protected $survey_service;

    /**
     * AnswerSurveyController constructor.
     * @param SurveyRepositoryInterface $surveyRepository
     * @param QuestionRepositoryInterface $questionRepository
     * @param QuestionChoiceRepositoryInterface $questionChoiceRepository
     * @param ConfirmContentsRepositoryInterface $confirmContentRepository
     * @param AnswerRepositoryInterface $answerRepository
     * @param AnswerQuestionRepositoryInterface $answerQuestionRepository
     */
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
		$this->encryption_service       = new EncryptionService();
		$this->survey_service           = new SurveyService();
	}
	
	public function showQuestionSurvey(Request $request, $encrypt)
	{
		try {
			$id             = $this->getIdSurveyFormEncryptCode($encrypt);
			$survey_service = new SurveyService();
			$answer         = array();
			if ($request->session()->get('answer'. $id) != null) {
				$answer = $request->session()->get('answer' . $id);
			}
			
			$survey = $this->surveyRepository->getSurveyPublishedById($id);
			if ($survey == false) {
				return redirect('404');
			}
			
			$survey                = $survey_service->getDataAnswerForSurvey($survey, isset($answer['questions']) ? $answer['questions'] : array());
			$survey['encrypt_url'] = $encrypt;
			
			return view('user.survey.answer.fill', array('survey' => $survey));
		} catch (\Exception $e) {
			return redirect('404');
		}
	}
	
	public function showFormConfirmAnswerSurvey(Request $request, $encrypt)
	{
		try {
			$input           = Input::get();
			$surveyValidator = new SurveyValidator();
			if (!$surveyValidator->validateAnswerSurvey($input)) {
				return redirect('404');
			}
			
			foreach ($input as $key => $text) {
				if (is_string($text)) {
					$input[$key] = $this->survey_service->convertTextWithXSSSafe($text);
				}
			}
			
			$id                  = $this->getIdSurveyFormEncryptCode($encrypt);
			$survey              = $this->surveyRepository->getSurveyPublishedById($id);
			$survey['questions'] = $this->questionRepository->getQuestionSurveyWithoutConfirmTypeBySurveyId($id);
			
			foreach ($survey['questions'] as $key => $question) {
				if (in_array($question['id'], array_keys($input))) {
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
			}
			
			$survey['encrypt_url'] = $encrypt;
			$request->session()->put('answer' . $id, $survey);
			
			return view('user.survey.answer.confirm', array('survey' => $survey));
		} catch (\Exception $e) {
			return redirect('404');
		}
		
	}
	
	public function answerSurvey(Request $request, $encrypt)
	{
		try {
			$id        = $this->getIdSurveyFormEncryptCode($encrypt);
			$survey    = $request->session()->get('answer' . $id);
			$id_answer = $this->answerRepository->save($survey['id']);
			foreach ($survey['questions'] as $question) {
				if (!isset($question['answer'])) {
					continue;
				}
				
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
			
			$request->session()->forget('answer' . $id);
			
			return redirect()->route(Survey::NAME_URL_THANK_PAGE);
		} catch (\Exception $e) {
			return redirect('404');
		}
		
	}
	
	public function getIdSurveyFormEncryptCode($encrypt)
	{
		try {
			$id = $this->encryption_service->decrypt($encrypt);
			
			return $id;
		} catch (\Exception $e) {
			return redirect('404');
		}
	}
	
	public function showThankPage()
	{
		return view('user.survey.answer.thank');
	}
}
