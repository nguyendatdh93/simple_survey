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
    /**
     * @param $survey_id
     * @return mixed
     */
    public function getQuestionSurveyBySurveyId($survey_id);

    /**
     * @param $survey_id
     * @return mixed
     */
    public function getListQuestionBySurveyId($survey_id);

    /**
     * @param $survey_id
     * @return mixed
     */
    public function getQuestionsDataBySurveyId($survey_id);

    /**
     * @param $survey_id
     * @return mixed
     */
    public function getQuestionsBySurveyId($survey_id);

    /**
     * @param $survey_id
     * @return mixed
     */
    public function getQuestionSurveyWithoutConfirmTypeBySurveyId($survey_id);

    /**
     * @param $survey_id
     * @return mixed
     */
    public function getQuestionIdsWithTypeBySurveyId($survey_id);

    /**
     * @return mixed
     */
    public function createEmptyObject();
}