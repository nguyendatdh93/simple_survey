<?php
namespace App\Http\Validators;
use App\Question;
use App\Repositories\Eloquents\QuestionChoiceRepository;
use App\Repositories\Eloquents\QuestionRepository;
use App\Survey;
use Illuminate\Support\Facades\Validator;
use Config;

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
		$questionRepository       = new QuestionRepository();
		$questionChoiceRepository = new QuestionChoiceRepository();
		foreach ($answerSurvey as $question_id => $answer) {
			$require = $questionRepository->checkQuestionIsRequire($question_id);
			if ($require['require'] == Question::REQUIRE_QUESTION_YES) {
				if (!$this->validateRequired($answer)) {
					return false;
				}
			}
			
			try {
				$type = $questionRepository->getTypeOfQuestion($question_id);
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
				if ($choice['question_id'] != $question_id) {
					return false;
				}
			} elseif ($type['type'] == Question::TYPE_MULTI_CHOICE) {
				foreach ($answer as $m_answer) {
					$choice = $questionChoiceRepository->getChoiceOfQuestionByChoiceId($m_answer);
					if ($choice['question_id'] != $question_id) {
						return false;
					}
				}
			}
		}
		
		return true;
	}
	
	public function validateSingleText($text)
	{
		$validator = Validator::make(array($text), array('max:255'));
		if ($validator->fails()) {
			return false;
		}
		
		return true;
	}
	
	public function validateMultiText($text)
	{
		$validator = Validator::make(array($text), array('max:5000'));
		if ($validator->fails()) {
			return false;
		}
		
		return true;
	}

	public function validateRequired($text)
	{
		$validator = Validator::make(array($text), array('required'));
		if ($validator->fails()) {
			return false;
		}
		
		return true;
	}

    public function validateText($text, $require = true, $limit = 255) {
        $filter = 'max:' . $limit;
        if ($require) {
            $filter = 'required|' . $filter;
        }

        $validator = Validator::make([$text], [$filter]);
        if ($validator->fails()) {
            return false;
        }

        return true;
    }

    public function validateFile($file) {
        if (!in_array(strtolower($file->clientExtension()), Config::get('config.file_types_allow'))) {
            return false;
        }

        if ($file->getClientSize() > Config::get('config.max_file_upload_size')) {
            return false;
        }

        return true;
    }
}