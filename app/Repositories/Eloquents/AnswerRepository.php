<?php
/**
 * Created by PhpStorm.
 * User: nguyen-dat
 * Date: 04/12/2017
 * Time: 19:33
 */
namespace App\Repositories\Eloquents;

use App\Answer;
use App\Repositories\Contracts\AnswerRepositoryInterface;

class AnswerRepository extends \EloquentRepository implements AnswerRepositoryInterface
{

    public function getModel()
    {
        return Answer::class;
    }

    public function getNumberAnswersBySurveyId($survey_id)
    {

    }
}