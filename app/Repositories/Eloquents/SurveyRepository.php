<?php
/**
 * Created by PhpStorm.
 * User: nguyen-dat
 * Date: 04/12/2017
 * Time: 19:33
 */
namespace App\Repositories\Eloquents;

use App\Repositories\Contracts\SurveyRepositoryInterface;
use App\Survey;

class SurveyRepository extends \EloquentRepository implements SurveyRepositoryInterface
{

    public function getModel()
    {
        return Survey::class;
    }

    public function getSurveyById($survey_id)
    {
        $result = $this->_model->select('*')
                    ->where('id',$survey_id)->get()->toArray();

        return $result[0];
    }
}