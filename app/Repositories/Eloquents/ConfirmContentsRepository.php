<?php
/**
 * Created by PhpStorm.
 * User: nguyen-dat
 * Date: 04/12/2017
 * Time: 19:33
 */
namespace App\Repositories\Eloquents;

use App\Models\ConfirmContent;
use App\Repositories\Contracts\ConfirmContentsRepositoryInterface;

class ConfirmContentsRepository extends \EloquentRepository implements ConfirmContentsRepositoryInterface
{

    /**
     * @return mixed
     */
    public function getModel()
    {
        return ConfirmContent::class;
    }

    /**
     * @return ConfirmContent
     */
    public function createEmptyObject() {
        return new ConfirmContent();
    }

    /**
     * @param $question_id
     * @return mixed
     */
    public function getConfirmContentByQuestionId($question_id)
    {
        $result = $this->_model->select('*')
            ->where('question_id', $question_id)->get()->toArray();

        return $result;
    }
}