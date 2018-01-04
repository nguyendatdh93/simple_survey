<?php
/**
 * Created by PhpStorm.
 * User: atb
 * Date: 04/01/2018
 * Time: 09:51
 */

namespace App\Repositories\Contracts;

interface SurveyRepositoryInterface
{
    public function getSurveyById($survey_id);
    public function publishSurveyById($survey_id);
    public function closeSurveyById($survey_id);
}