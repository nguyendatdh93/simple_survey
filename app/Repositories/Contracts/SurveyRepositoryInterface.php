<?php
/**
 * Created by PhpStorm.
 * User: atb
 * Date: 04/01/2018
 * Time: 09:51
 */

namespace App\Repositories\Contracts;

use App\Survey;

interface SurveyRepositoryInterface
{
    public function getAllSurvey();
    public function getSurveyById($survey_id);
    public function publishSurveyById($survey_id);
    public function closeSurveyById($survey_id);
    public function getDownloadListSurvey();
    public function getNameSurvey($survey_id);
    public function createEmptyObject();
    public function save(Survey $survey);
}