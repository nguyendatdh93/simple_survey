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

    public function getModel()
    {
        return AnswerQuestion::class;
    }

    public function getAnswersByAnswerId($answer_id)
    {
        $answers = $this->_model->select("*")
                            ->where('answer_id', $answer_id)->get()->toArray();

        return $answers;
    }

    public function clearDataByAnswerId($answer_id)
    {
        $this->_model->where('answer_id', $answer_id)->delete();
    }
}