<?php
/**
 * Created by PhpStorm.
 * User: nguyen-dat
 * Date: 04/12/2017
 * Time: 19:33
 */
namespace App\Repositories\Eloquents;

use App\Question;
use App\Repositories\Contracts\QuestionRepositoryInterface;

class QuestionRepository extends \EloquentRepository implements QuestionRepositoryInterface
{

    public function getModel()
    {
        return Question::class;
    }

    public function getQuestionSurveyBySurveyId($survey_id)
    {
        $result = $this->_model->select('*')
                    ->where('survey_id',$survey_id)
	                ->where('del_flg', '!=', Question::DELETE_FLG)
	                ->get()->toArray();

        return $result;
    }
	
	public function getQuestionSurveyWithoutConfirmTypeBySurveyId($survey_id)
	{
		$result = $this->_model->select('*')
			->where('survey_id',$survey_id)
			->where('del_flg', '!=', Question::DELETE_FLG)
			->where('type' , '!=' , Question::TYPE_CONFIRMATION)
			->get()->toArray();
		
		return $result;
	}

    public function getListQuestionBySurveyId($survey_id)
    {
        $result = $this->_model->select('id','text')
            ->where('survey_id',$survey_id)
            ->where('type', '!=' , Question::TYPE_CONFIRMATION)
            ->get()->toArray();

        return $result;
    }

    public function createEmptyObject() {
        return new Question();
    }

    public function save(Question $question) {
        $question->save();

        return $question;
    }
    
    public function getTypeOfQuestion($question_id)
    {
	    $result = $this->_model->select('type')
		    ->where('id',$question_id)
		    ->where('del_flg', '!=', Question::DELETE_FLG)
		    ->get()
		    ->first();
	
	    return $result;
    }
}