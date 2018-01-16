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
	public function getSurveyPublishedById($survey_id);
    public function publishSurveyById($survey_id);
    public function closeSurveyById($survey_id);
    public function getDownloadListSurvey();
    public function getNameSurvey($survey_id);
//    public function find($filter);
    public function createEmptyObject();
    public function deleteSurvey($survey_id);
	public function updateStatusDownloadedForSurvey($survey_id);
	public function checkStatusSurveyIsDownloaded($survey_id);
}