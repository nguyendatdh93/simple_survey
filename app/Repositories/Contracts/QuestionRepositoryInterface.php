<?php
/**
 * Created by PhpStorm.
 * User: atb
 * Date: 04/01/2018
 * Time: 09:51
 */

namespace App\Repositories\Contracts;

use App\Question;

interface QuestionRepositoryInterface
{
    public function getQuestionSurveyBySurveyId($survey_id);
    public function getListQuestionBySurveyId($survey_id);
    public function createEmptyObject();
    public function save(Question $question);
}