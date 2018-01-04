<?php
/**
 * Created by PhpStorm.
 * User: atb
 * Date: 04/01/2018
 * Time: 09:51
 */

namespace App\Repositories\Contracts;

interface QuestionRepositoryInterface
{
    public function getQuestionSurveyBySurveyId($survey_id);
}