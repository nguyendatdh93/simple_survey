<?php
/**
 * Created by PhpStorm.
 * User: nguyen-dat
 * Date: 04/12/2017
 * Time: 19:33
 */
namespace App\Repositories\Eloquents;

use App\AnswerQuestion;
use App\Repositories\Contracts\AnswerQuestionRepositoryInterface;

class AnswerQuestionRepository extends \EloquentRepository implements AnswerQuestionRepositoryInterface
{

    /**
     * @return mixed
     */
    public function getModel()
    {
        return AnswerQuestion::class;
    }

    /**
     * @param $answer_id
     * @return mixed
     */
    public function getAnswersByAnswerId($answer_id)
    {
        $answers = $this->_model
	                    ->select("*")
	                    ->where('answer_id', $answer_id)
	                    ->get()
	                    ->toArray();

        return $answers;
    }

    /**
     * @param $answer_id
     * @return mixed
     */
    public function clearDataByAnswerId($answer_id)
    {
        return $this->_model
	                ->where('answer_id', $answer_id)
                    ->delete();
    }

    /**
     * @param $data
     * @return mixed
     */
    public function save($data)
    {
	    return $this->_model
				    ->insert(
				    [
				        'answer_id'   => $data['answer_id'],
					    'question_id' => $data['question_id'],
					    'text'        => $data['text'],
					    'created_at'  => date("Y-m-d h:i:s"),
				    ]
			    );
    }
}