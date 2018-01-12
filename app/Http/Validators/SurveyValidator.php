<?php
namespace App\Http\Validators;
use App\Question;
use App\Repositories\Eloquents\QuestionChoiceRepository;
use App\Repositories\Eloquents\QuestionRepository;
use App\Survey;
use Illuminate\Support\Facades\Validator;

/**
 * Created by PhpStorm.
 * User: atb
 * Date: 11/01/2018
 * Time: 17:10
 */

class SurveyValidator
{
	public function validateAnswerSurvey($answerSurvey)
	{
		if (isset($answerSurvey['csrf_token'])) {
			unset($answerSurvey['csrf_token']);
		}
		
		$questionRepository       = new QuestionRepository();
		$questionChoiceRepository = new QuestionChoiceRepository();
		foreach ($answerSurvey as $key => $answer) {
			try {
				$type = $questionRepository->getTypeOfQuestion($key);
			}catch (\Exception $e) {
				continue;
			}
			if ($type['type'] == Question::TYPE_SINGLE_TEXT) {
				if (!$this->validateSingleText($answer)) {
					return false;
				}
			} elseif ($type['type'] == Question::TYPE_MULTI_TEXT) {
				if (!$this->validateMultiText($answer)) {
					return false;
				}
			} elseif ($type['type'] == Question::TYPE_SINGLE_CHOICE) {
				$choice = $questionChoiceRepository->getChoiceOfQuestionByChoiceId($answer);
				if ($choice['question_id'] != $key) {
					return false;
				}
			} elseif ($type['type'] == Question::TYPE_MULTI_CHOICE) {
				foreach ($answer as $m_answer) {
					$choice = $questionChoiceRepository->getChoiceOfQuestionByChoiceId($m_answer);
					if ($choice['question_id'] != $key) {
						return false;
					}
				}
			}
		}
		
		return true;
	}
	
	public function validateSingleText($text)
	{
		$validator = Validator::make(array($text), array('required|max:255'));
		if ($validator->fails()) {
			return false;
		}
		
		return true;
	}
	
	public function validateMultiText($text)
	{
		$validator = Validator::make(array($text), array('required|max:5000'));
		if ($validator->fails()) {
			return false;
		}
		
		return true;
	}
	
}