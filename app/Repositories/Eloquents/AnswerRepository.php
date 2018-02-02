<?php
/**
 * Created by PhpStorm.
 * User: nguyen-dat
 * Date: 04/12/2017
 * Time: 19:33
 */
namespace App\Repositories\Eloquents;

use App\Models\Answer;
use App\Repositories\Contracts\AnswerRepositoryInterface;

class AnswerRepository extends \EloquentRepository implements AnswerRepositoryInterface
{

    /**
     * @return mixed
     */
    public function getModel()
    {
        return Answer::class;
    }

    /**
     * @param $survey_id
     * @return mixed
     */
    public function getNumberAnswersBySurveyId($survey_id)
    {
        $number_answers = $this->_model
	                           ->where('survey_id', $survey_id)
	                           ->count();

        return $number_answers;
    }

    /**
     * @param $survey_id
     * @return mixed
     */
    public function getAnswersBySurveyId($survey_id)
    {
        $answers = $this->_model
	                    ->select("*")
                        ->where('survey_id', $survey_id)
	                    ->get()
	                    ->toArray();

        return $answers;
    }

    /**
     * @param $survey_id
     * @return mixed
     */
    public function clearDataAnswersBySurveyId($survey_id)
    {
        return $this->_model
	                ->where('survey_id', $survey_id)
	                ->delete();
    }

    /**
     * @param $survey_id
     * @return mixed
     */
    public function save($survey_id)
	{
		$id = $this->_model
					->insertGetId(
						[
							'survey_id'  => $survey_id,
							'created_at' => date("Y-m-d h:i:s"),
						]
					);
		
		return $id;
	}
}