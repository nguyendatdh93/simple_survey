<?php
/**
 * Created by PhpStorm.
 * User: nguyen-dat
 * Date: 04/12/2017
 * Time: 19:33
 */
namespace App\Repositories\Eloquents;

use App\QuestionChoice;
use App\Repositories\Contracts\QuestionChoiceRepositoryInterface;

class QuestionChoiceRepository extends \EloquentRepository implements QuestionChoiceRepositoryInterface
{

    public function getModel()
    {
        return QuestionChoice::class;
    }

    public function getQuestionChoiceByQuestionId($question_id)
    {
        $result = $this->_model->select('*')
                    ->where('question_id', $question_id)->get()->toArray();

        return $result;
    }
}