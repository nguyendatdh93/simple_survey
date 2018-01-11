<?php

namespace App\Http\Controllers;

use App\Http\Services\EncryptionService;
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
		$this->middleware('auth');
		$this->middleware(SecureDownloadSurvey::class);
		$this->surveyRepository         = $surveyRepository;
		$this->questionRepository       = $questionRepository;
		$this->questionChoiceRepository = $questionChoiceRepository;
		$this->confirmContentRepository = $confirmContentRepository;
		$this->answerRepository         = $answerRepository;
		$this->answerQuestionRepository = $answerQuestionRepository;
		$this->confirmContentRepository = $confirmContentRepository;
	}
	
	public function showQuestionSurvey($encrypt)
	{
		$encryption_service = new EncryptionService();
		$id                 = $encryption_service->decrypt($encrypt);
		
	}
}
