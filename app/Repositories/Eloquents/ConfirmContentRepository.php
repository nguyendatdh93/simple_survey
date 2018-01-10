<?php
/**
 * Created by PhpStorm.
 * User: nguyen-dat
 * Date: 04/12/2017
 * Time: 19:33
 */
namespace App\Repositories\Eloquents;

use App\ConfirmContent;
use App\Repositories\Contracts\ConfirmContentRepositoryInterface;

class ConfirmContentRepository extends \EloquentRepository implements ConfirmContentRepositoryInterface
{

    public function getModel()
    {
        return ConfirmContent::class;
    }

    public function getConfirmContentByQuestionId($question_id)
    {
        $result = $this->_model->select('*')
            ->where('question_id', $question_id)->get()->toArray();

        return $result;
    }
}