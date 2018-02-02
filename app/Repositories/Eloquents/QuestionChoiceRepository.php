<?php
/**
 * Created by PhpStorm.
 * User: nguyen-dat
 * Date: 04/12/2017
 * Time: 19:33
 */
namespace App\Repositories\Eloquents;

use App\Models\QuestionChoice;
use App\Repositories\Contracts\QuestionChoiceRepositoryInterface;

class QuestionChoiceRepository extends \EloquentRepository implements QuestionChoiceRepositoryInterface
{

    /**
     * @return mixed
     */
    public function getModel()
    {
        return QuestionChoice::class;
    }

    /**
     * @param $question_id
     * @return mixed
     */
    public function getQuestionChoiceByQuestionId($question_id)
    {
        $result = $this->_model
	                   ->select('*')
                       ->where('question_id', $question_id)
	                   ->get()
	                   ->toArray();

        return $result;
    }

    /**
     * @return QuestionChoice
     */
    public function createEmptyObject() {
        return new QuestionChoice();
    }

    /**
     * @param $choice_id
     * @return mixed
     */
    public function getChoiceTextByChoiceId($choice_id)
    {
	    $result = $this->_model
		               ->select('text')
		               ->where('id', $choice_id)
		               ->get()
		               ->first()
		               ->toArray();
	
	    return $result;
    }

    /**
     * @param $choice_id
     * @return mixed
     */
    public function getChoiceOfQuestionByChoiceId($choice_id)
    {
	    $result = $this->_model
		               ->select('*')
		               ->where('id', $choice_id)
		               ->get()
	                   ->first()
		               ->toArray();
	
	    return $result;
    }
}