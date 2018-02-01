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
    /**
     * @return mixed
     */
    public function getAllSurvey();

    /**
     * @param $survey_id
     * @return mixed
     */
    public function getSurveyById($survey_id);

    /**
     * @param $survey_id
     * @return mixed
     */
    public function getSurveyPublishedById($survey_id);

    /**
     * @param $survey_id
     * @return mixed
     */
    public function closeSurveyById($survey_id);

    /**
     * @return mixed
     */
    public function getDownloadListSurvey();

    /**
     * @param $survey_id
     * @return mixed
     */
    public function getNameSurvey($survey_id);

    /**
     * @return mixed
     */
    public function createEmptyObject();

    /**
     * @param $survey_id
     * @return mixed
     */
    public function updateStatusDownloadedForSurvey($survey_id);

    /**
     * @param $survey_id
     * @return mixed
     */
    public function checkStatusSurveyIsDownloaded($survey_id);

    /**
     * @param $survey_id
     * @return mixed
     */
    public function getStatusSurvey($survey_id);
}