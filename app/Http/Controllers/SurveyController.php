<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Repositories\Contracts\AnswerQuestionRepositoryInterface;
use App\Survey;
use Illuminate\Http\Request;
use App\Repositories\Contracts\SurveyRepositoryInterface;
use App\Repositories\Contracts\QuestionRepositoryInterface;
use App\Repositories\Contracts\QuestionChoiceRepositoryInterface;
use App\Repositories\Contracts\AnswerRepositoryInterface;
use Illuminate\Support\Facades\Route;

class SurveyController extends Controller
{
    protected $surveyRepository;
    protected $questionRepository;
    protected $questionChoiceRepository;
    protected $answerRepository;
    protected $answerQuestionRepository;

    public function __construct(SurveyRepositoryInterface $surveyRepository, QuestionRepositoryInterface $questionRepository, QuestionChoiceRepositoryInterface $questionChoiceRepository, AnswerRepositoryInterface $answerRepository, AnswerQuestionRepositoryInterface $answerQuestionRepository)
    {
        $this->middleware('auth');
        $this->surveyRepository = $surveyRepository;
        $this->questionRepository = $questionRepository;
        $this->questionChoiceRepository = $questionChoiceRepository;
        $this->answerRepository = $answerRepository;
        $this->answerQuestionRepository = $answerQuestionRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $table_settings = array(
            'title' => trans('adminlte_lang::survey.survey_list_table_title'),
            'id'    => 'survey-table',
            'headers_columns' => array(
                trans('adminlte_lang::survey.survey_list_table_header_column_id')                    => 'id',
                trans('adminlte_lang::survey.survey_list_table_header_column_status')                => 'status',
                trans('adminlte_lang::survey.survey_list_table_header_column_survey_name')           => 'name',
                trans('adminlte_lang::survey.survey_list_table_header_column_survey_image')          => array(
                    'column'     => 'image_path',
                    'type'       => 'image'
                ),
                trans('adminlte_lang::survey.survey_list_table_header_column_survey_published_at')   => 'published_at',
                trans('adminlte_lang::survey.survey_list_table_header_column_survey_closed_at')      => 'closed_at',
                trans('adminlte_lang::survey.survey_list_table_header_column_survey_number_answers') => 'number_answers'
            ),
            'controls' => true
        );

        $surveys = $this->surveyRepository->getAllSurvey();
        $surveys = $this->getDataSurveyForShowing($surveys);

        return view('admin::datatable', array('settings' => $table_settings, 'datas' => $surveys));
    }

    public function showNumberAnswers($survey)
    {
        if ($this->answerRepository->getNumberAnswersBySurveyId($survey['id']) > 0) {
            return $this->answerRepository->getNumberAnswersBySurveyId($survey['id']);
        }

        return '-';
    }

    public function getDataSurveyForShowing($surveys)
    {
        foreach ($surveys as $key => $survey) {
            if ($survey['status'] == Survey::STATUS_SURVEY_DRAF) {
                $surveys[$key]['status'] = trans('adminlte_lang::survey.draf');
            } elseif ($survey['status'] == Survey::STATUS_SURVEY_PUBLISHED) {
                $surveys[$key]['status'] = trans('adminlte_lang::survey.published');
            } else {
                $surveys[$key]['status'] = trans('adminlte_lang::survey.closed');
            }

            $surveys[$key]['number_answers'] = $this->showNumberAnswers($survey);
        }

        return $surveys;
    }

    public function downloadListSurvey()
    {
        $table_settings = array(
            'title' => trans('adminlte_lang::survey.survey_list_table_title'),
            'id'    => 'download-table',
            'headers_columns' => array(
                trans('adminlte_lang::survey.survey_list_table_header_column_id')                    => 'id',
                trans('adminlte_lang::survey.survey_list_table_header_column_status')                => 'status',
                trans('adminlte_lang::survey.survey_list_table_header_column_survey_name')           => 'name',
                trans('adminlte_lang::survey.survey_list_table_header_column_survey_image')          => array(
                    'column'     => 'image_path',
                    'type'       => 'image'
                ),
                trans('adminlte_lang::survey.survey_list_table_header_column_survey_published_at')   => 'published_at',
                trans('adminlte_lang::survey.survey_list_table_header_column_survey_closed_at')      => 'closed_at',
                trans('adminlte_lang::survey.survey_list_table_header_column_survey_number_answers') => 'number_answers'
            ),
            'controls' => true
        );

        $surveys = $this->surveyRepository->getDownloadListSurvey();
        $surveys = $this->getDataSurveyForShowing($surveys);

        return view('admin::datatable', array('settings' => $table_settings, 'datas' => $surveys));
    }

    public function downloadPageSurveyBySurveyId($id)
    {
        $list_questions = $this->questionRepository->getListQuestionBySurveyId($id);
        $answers = $this->answerRepository->getAnswersBySurveyId($id);
        foreach ($answers as $key => $answer) {
            $answers[$key]['answers'] = $this->answerQuestionRepository->getAnswersByAnswerId($answer['id']);
        }
        
        $headers_columns = array();

        foreach ($list_questions as $question) {
            $headers_columns[$question['text']] = 0;
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function preview(Request $request, $id)
    {
        $survey              = $this->surveyRepository->getSurveyById($id);
        $survey['questions'] = $this->questionRepository->getQuestionSurveyBySurveyId($id);
        foreach ($survey['questions'] as $key => $question) {
            $question_choices = $this->questionChoiceRepository->getQuestionChoiceByQuestionId($question['id']);
            if (count($question_choices) > 0) {
                $survey['questions'][$key]['question_choices'] = $question_choices;
            }
        }

        $group_question_survey = array();

        foreach ( $survey['questions'] as $question ) {
            $group_question_survey[$question['category']][] = $question;
        }

        $survey['questions'] = $group_question_survey;

        return view('admin::preview', array('survey' => $survey, 'name_url' => $request->route()->getName()));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function publishSurveyById($id)
    {
        $result = $this->surveyRepository->publishSurveyById($id);

        if ($result) {
            return redirect()->route(Survey::NAME_URL_PREVIEW_PUBLISH, ['id' => $id])->with('alert_success', trans('adminlte_lang::survey.message_publish_survey_success'));
        }

        return redirect()->route(Survey::NAME_URL_PREVIEW_DRAF, ['id' => $id])->with('alert_error', trans('adminlte_lang::survey.message_publish_survey_not_success'));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function closeSurveyById($id)
    {
        $result = $this->surveyRepository->closeSurveyById($id);

        if ($result) {
            return redirect()->route(Survey::NAME_URL_PREVIEW_CLOSE, ['id' => $id])->with('alert_success', trans('adminlte_lang::survey.message_close_survey_success'));
        }

        return redirect()->route(Survey::NAME_URL_PREVIEW_PUBLISH, ['id' => $id])->with('alert_error', trans('adminlte_lang::survey.message_close_survey_not_success'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
