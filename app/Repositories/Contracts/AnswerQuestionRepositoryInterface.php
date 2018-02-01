<?php
/**
 * Created by PhpStorm.
 * User: atb
 * Date: 04/01/2018
 * Time: 09:51
 */

namespace App\Repositories\Contracts;

interface AnswerQuestionRepositoryInterface
{
    /**
     * @param $answer_id
     * @return mixed
     */
    public function getAnswersByAnswerId($answer_id);

    /**
     * @param $answer_id
     * @return mixed
     */
    public function clearDataByAnswerId($answer_id);

    /**
     * @param $data
     * @return mixed
     */
    public function save($data);
}