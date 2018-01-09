<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Survey;
use Illuminate\Http\Request;
use App\Repositories\Contracts\SurveyRepositoryInterface;
use App\Repositories\Contracts\QuestionRepositoryInterface;
use App\Repositories\Contracts\QuestionChoiceRepositoryInterface;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Input;

class SurveyController extends Controller
{
    protected $surveyRepository;
    protected $questionRepository;
    protected $questionChoiceRepository;

    public function __construct(SurveyRepositoryInterface $surveyRepository, QuestionRepositoryInterface $questionRepository, QuestionChoiceRepositoryInterface $questionChoiceRepository)
    {
        $this->middleware('auth');
        $this->surveyRepository = $surveyRepository;
        $this->questionRepository = $questionRepository;
        $this->questionChoiceRepository = $questionChoiceRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $table_settings = array(
            'title' => 'Surveys list managerment',
            'id'    => 'survey-table',
            'headers_columns' => array(
                'Id'             => 'id',
                'Status'         => 'status',
                'Survey Name'    => 'name',
                'Image'          => array(
                    'column'     => 'image_path',
                    'type'       => 'image'
                ),
                'Published at'   => 'published_at',
                'Closed at'      => 'closed_at',
                "Number Answers" => 'number_answers'
            ),
            'controls' => true
        );

        $surveys = $this->surveyRepository->getAllSurvey();

        foreach ($surveys as $key => $survey) {
            if ($survey['status'] == Survey::STATUS_SURVEY_DRAF) {
                $surveys[$key]['status'] = trans('adminlte_lang::survey.draf');
            } elseif ($survey['status'] == Survey::STATUS_SURVEY_PUBLISHED) {
                $surveys[$key]['status'] = trans('adminlte_lang::survey.published');
            } else {
                $surveys[$key]['status'] = trans('adminlte_lang::survey.closed');
            }

            $surveys[$key]['number_answers'] = 0;
        }

        return view('admin::datatable', array('settings' => $table_settings, 'datas' => $surveys));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {


        $layout = 'admin.survey.edit';
        return view($layout);
    }

    public function save() {
        $input = Input::all();
        var_dump($input);
        die('abc');
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
