<?php
/**
 * Created by PhpStorm.
 * User: atb
 * Date: 04/01/2018
 * Time: 09:51
 */

namespace App\Repositories\Contracts;

interface ConfirmContentRepositoryInterface
{
    public function getConfirmContentByQuestionId($question_id);
}