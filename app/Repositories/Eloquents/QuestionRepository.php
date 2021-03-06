<?php
/**
 * Created by PhpStorm.
 * User: nguyen-dat
 * Date: 04/12/2017
 * Time: 19:33
 */
namespace App\Repositories\Eloquents;

use App\Models\ConfirmContent;
use App\Models\Question;
use App\Models\QuestionChoice;
use App\Repositories\Contracts\QuestionRepositoryInterface;
use Illuminate\Support\Facades\DB;

class QuestionRepository extends \EloquentRepository implements QuestionRepositoryInterface
{

    /**
     * @return mixed
     */
    public function getModel()
    {
        return Question::class;
    }

    /**
     * @param $survey_id
     * @return mixed
     */
    public function getQuestionSurveyBySurveyId($survey_id)
    {
        $result = $this->_model
	                   ->select('*')
	                   ->where('survey_id',$survey_id)
	                   ->where('del_flg', '!=', Question::DELETE_FLG)
	                   ->orderBy('no', 'ASC')
	                   ->get()
	                   ->toArray();
        
        return $result;
    }

    /**
     * @param $survey_id
     * @return mixed
     */
    public function getQuestionSurveyWithoutConfirmTypeBySurveyId($survey_id)
	{
		$result = $this->_model
			           ->select('*')
			           ->where('survey_id',$survey_id)
			           ->where('del_flg', '!=', Question::DELETE_FLG)
			           ->where('type' , '!=' , Question::TYPE_CONFIRMATION)
			           ->get()
			           ->toArray();
		
		return $result;
	}

    /**
     * @param $survey_id
     * @return mixed
     */
    public function getListQuestionBySurveyId($survey_id)
    {
        $result = $this->_model
	                   ->select('id','text')
                       ->where('survey_id',$survey_id)
                       ->where('type', '!=' , Question::TYPE_CONFIRMATION)
                       ->get()
	                   ->toArray();

        return $result;
    }

    /**
     * @param $survey_id
     * @return mixed
     */
    public function getQuestionsDataBySurveyId($survey_id) {
        $question_table_name        = with(new Question)->getTable();
        $question_choice_table_name = with(new QuestionChoice)->getTable();
        $confirm_content_table_name = with(new ConfirmContent)->getTable();

        $questions = DB::table("$question_table_name")
            ->leftjoin($question_choice_table_name, "$question_choice_table_name.question_id", '=', "$question_table_name.id")
            ->leftjoin($confirm_content_table_name, "$confirm_content_table_name.question_id", '=', "$question_table_name.id")
            ->select(
                "$question_table_name.id",
                "$question_table_name.text",
                "$question_table_name.type",
                "$question_table_name.require",
                "$question_table_name.category",
                "$question_table_name.no",
                "$question_choice_table_name.text as choice_text",
                "$confirm_content_table_name.text as confirm_text")
            ->where("$question_table_name.survey_id", '=', $survey_id)
            ->where("$question_table_name.del_flg", '=', 0)
            ->orderBy("$question_table_name.no", 'ASC')
            ->get();

        return $questions;
    }

    /**
     * @param $survey_id
     * @return array
     */
    public function getQuestionsBySurveyId($survey_id) {
        $questions_data = $this->getQuestionsDataBySurveyId($survey_id);
        if (!$questions_data) {
            return [];
        }

        $questions            = [];
        $questions_categories = Question::getQuestionCategories();
        foreach ($questions_data as $question) {
            $category = $questions_categories[$question->category];
            if (empty($questions[$category][$question->id])) {
                $questions[$category][$question->id]['text']     = $question->text;
                $questions[$category][$question->id]['type']     = $question->type;
                $questions[$category][$question->id]['require']  = $question->require;
                $questions[$category][$question->id]['category'] = $question->category;
            }

            if ($question->type == Question::TYPE_SINGLE_CHOICE
                || $question->type == Question::TYPE_MULTI_CHOICE
            ) {
                $questions[$category][$question->id]['choice'][] = $question->choice_text;
            }

            if ($question->type == Question::TYPE_CONFIRMATION) {
                $questions[$category][$question->id]['confirm_text'] = $question->confirm_text;

                if ($question->require == Question::REQUIRE_QUESTION_YES) {
                    $questions[$category][$question->id]['agree_text'] = $question->choice_text;
                }
            }
        }

        return $questions;
    }

    /**
     * @param $survey_id
     * @return mixed
     */
    public function getQuestionIdsWithTypeBySurveyId($survey_id) {
        $result = $this->_model
	                   ->select('id', 'type')
	                   ->where('survey_id', $survey_id)
                       ->where('del_flg', 0)
                       ->get()
                       ->toArray();

        return $result;
    }

    /**
     * @return Question
     */
    public function createEmptyObject() {
        return new Question();
    }

    /**
     * @param $question_id
     * @return mixed
     */
    public function getTypeOfQuestion($question_id)
    {
	    $result = $this->_model
		               ->select('type')
		               ->where('id',$question_id)
		               ->where('del_flg', '!=', Question::DELETE_FLG)
		               ->get()
		               ->first();
	
	    return $result;
    }

    /**
     * @param $question_id
     * @return mixed
     */
    public function checkQuestionIsRequire($question_id)
	{
		$result = $this->_model
			           ->select('require')
			           ->where('id',$question_id)
			           ->get()
			           ->first();
		
		return $result;
	}
}