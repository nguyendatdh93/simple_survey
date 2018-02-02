<?php
/**
 * Created by PhpStorm.
 * User: nguyen-dat
 * Date: 04/12/2017
 * Time: 19:33
 */
namespace App\Repositories\Eloquents;

use App\Repositories\Contracts\SurveyRepositoryInterface;
use App\Models\Survey;
use Illuminate\Support\Facades\Auth;
use DB;

class SurveyRepository extends \EloquentRepository implements SurveyRepositoryInterface
{

    /**
     * @return mixed
     */
    public function getModel()
    {
        return Survey::class;
    }

    /**
     * @return mixed
     */
    public function getAllSurvey()
    {
        $result = $this->_model->select('*')
            ->where('user_id', Auth::id())
            ->where('del_flg', 0)
            ->get()->toArray();

        return $result;
    }

    /**
     * @return mixed
     */
    public function getDownloadListSurvey()
    {
        $result = $this->_model->select('*')
            ->where('user_id', Auth::id())
            ->where('status', '!=', Survey::STATUS_SURVEY_DRAF)
            ->where('del_flg', 0)
	        ->orderBy('id','desc')
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
            ->where('user_id', Auth::id())
            ->where('id',$survey_id)
            ->where('del_flg','!=', Survey::DELETE_FLG)
            ->first();

        return $result ? $result->toArray() : [];
    }

    /**
     * @param $survey_id
     * @return array
     */
    public function getSurveyPublishedById($survey_id)
	{
		$result = $this->_model->select('*')
			->where('id',$survey_id)
			->where('del_flg','!=', Survey::DELETE_FLG)
			->where('status', Survey::STATUS_SURVEY_PUBLISHED)
			->first();
		
		return $result ? $result->toArray() : [];
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

    /**
     * @param $survey_id
     * @return mixed
     */
    public function getNameSurvey($survey_id)
    {
        $result = $this->_model->select('name')
            ->where('id', $survey_id)
            ->get()->toArray();

        return $result[0]['name'];
    }

    /**
     * @return Survey
     */
    public function createEmptyObject() {
        return new Survey();
    }

    /**
     * @param $survey_id
     */
    public function updateStatusDownloadedForSurvey($survey_id)
    {
    	if ($survey_id) {
		    $this->_model->where('id', $survey_id)->update(['downloaded' => Survey::STATUS_SURVEY_DOWNLOADED]);
	    }
    }

    /**
     * @param $survey_id
     * @return array
     */
    public function checkStatusSurveyIsDownloaded($survey_id)
    {
	    $result = $this->_model->select('downloaded')
		    ->where('id',$survey_id)
		    ->first();
	    
	    return $result ? $result->toArray() : [];
    }

    /**
     * @param $survey_id
     * @return array
     */
    public function getStatusSurvey($survey_id)
    {
	    $result = $this->_model->select('status')
		    ->where('id',$survey_id)
		    ->first();
	
	    return $result ? $result->toArray() : [];
    }
}