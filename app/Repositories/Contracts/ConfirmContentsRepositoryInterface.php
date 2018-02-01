<?php
/**
 * Created by PhpStorm.
 * User: atb
 * Date: 04/01/2018
 * Time: 09:51
 */

namespace App\Repositories\Contracts;

use App\ConfirmContent;

interface ConfirmContentsRepositoryInterface
{
    /**
     * @return mixed
     */
    public function createEmptyObject();

    /**
     * @param $question_id
     * @return mixed
     */
    public function getConfirmContentByQuestionId($question_id);
}