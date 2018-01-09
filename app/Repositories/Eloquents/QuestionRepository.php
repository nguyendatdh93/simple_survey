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
                    ->where('survey_id',$survey_id)->get()->toArray();

        return $result;
    }

    public function getListQuestionBySurveyId($survey_id)
    {
        $result = $this->_model->select('id','text')
            ->where('survey_id',$survey_id)->get()->toArray();

        return $result;
    }
}