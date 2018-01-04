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
use Illuminate\Support\Facades\Auth;
use Mockery\Exception;

class SurveyRepository extends \EloquentRepository implements SurveyRepositoryInterface
{

    public function getModel()
    {
        return Survey::class;
    }

    public function getAllSurvey()
    {
        $result = $this->_model->select('*')
            ->where('user_id', Auth::id())
            ->where('del_flg', 0)
            ->get()->toArray();

        return $result;
    }

    /**
     * @param $survey_id
     * @return mixed
     */
    public function getSurveyById($survey_id)
    {
        $result = $this->_model->select('*')
                    ->where('id',$survey_id)->get()->toArray();

        return $result[0];
    }

    /**
     * @param $survey_id
     * @return int
     */
    public function publishSurveyById($survey_id)
    {
        if ($survey_id) {
            try {
                $result = $this->_model->where('id', $survey_id)->update(['published_at' => date("Y-m-d h:i:s"), 'status' => Survey::STATUS_SURVEY_PUBLISHED]);

                return $result;
            }catch (\Exception $e) {
                return 0;
            }

        }

        return 0;
    }

    /**
     * @param $survey_id
     * @return int
     */
    public function closeSurveyById($survey_id)
    {
        if ($survey_id) {
            try {
                $result = $this->_model->where('id', $survey_id)->update(['closed_at' => date("Y-m-d h:i:s"), 'status' => Survey::STATUS_SURVEY_CLOSED]);

                return $result;
            }catch (\Exception $e) {
                return 0;
            }

        }

        return 0;
    }
}