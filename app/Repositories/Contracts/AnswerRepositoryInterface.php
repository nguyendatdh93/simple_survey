<?php
/**
 * Created by PhpStorm.
 * User: atb
 * Date: 04/01/2018
 * Time: 09:51
 */

namespace App\Repositories\Contracts;

interface AnswerRepositoryInterface
{
    public function getNumberAnswersBySurveyId($survey_id);
    public function getAnswersBySurveyId($survey_id);
}