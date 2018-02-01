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
    /**
     * @param $survey_id
     * @return mixed
     */
    public function getNumberAnswersBySurveyId($survey_id);

    /**
     * @param $survey_id
     * @return mixed
     */
    public function getAnswersBySurveyId($survey_id);

    /**
     * @param $survey_id
     * @return mixed
     */
    public function clearDataAnswersBySurveyId($survey_id);

    /**
     * @param $survey_id
     * @return mixed
     */
    public function save($survey_id);
}