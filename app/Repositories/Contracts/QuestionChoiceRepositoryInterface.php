<?php
/**
 * Created by PhpStorm.
 * User: atb
 * Date: 04/01/2018
 * Time: 09:51
 */

namespace App\Repositories\Contracts;

use App\QuestionChoice;

interface QuestionChoiceRepositoryInterface
{
    /**
     * @param $question_id
     * @return mixed
     */
    public function getQuestionChoiceByQuestionId($question_id);

    /**
     * @return mixed
     */
    public function createEmptyObject();

    /**
     * @param $choice_id
     * @return mixed
     */
    public function getChoiceTextByChoiceId($choice_id);
}