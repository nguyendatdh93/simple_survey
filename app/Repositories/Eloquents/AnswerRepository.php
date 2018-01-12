<?php
/**
 * Created by PhpStorm.
 * User: nguyen-dat
 * Date: 04/12/2017
 * Time: 19:33
 */
namespace App\Repositories\Eloquents;

use App\Answer;
use App\Repositories\Contracts\AnswerRepositoryInterface;

class AnswerRepository extends \EloquentRepository implements AnswerRepositoryInterface
{

    public function getModel()
    {
        return Answer::class;
    }

    public function getNumberAnswersBySurveyId($survey_id)
    {
        $number_answers = $this->_model->where('survey_id', $survey_id)->count();

        return $number_answers;
    }

    public function getAnswersBySurveyId($survey_id)
    {
        $answers = $this->_model->select("*")
            ->where('survey_id', $survey_id)->get()->toArray();

        return $answers;
    }

    public function clearDataAnswersBySurveyId($survey_id)
    {
        $this->_model->where('survey_id', $survey_id)->delete();
    }
	
	public function save($survey_id)
	{
		$id = $this->_model->insertGetId(
			[
				'survey_id'  => $survey_id,
				'created_at' => date("Y-m-d h:i:s"),
			]
		);
		
		return $id;
	}
}