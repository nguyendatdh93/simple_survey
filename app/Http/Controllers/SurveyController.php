<?php

namespace App\Http\Controllers;

use App\Http\Middleware\SecureDownloadSurvey;
use App\Http\Requests;
use App\Question;
use App\Repositories\Contracts\AnswerQuestionRepositoryInterface;
use App\Survey;
use Illuminate\Http\Request;
use App\Repositories\Contracts\SurveyRepositoryInterface;
use App\Repositories\Contracts\QuestionRepositoryInterface;
use App\Repositories\Contracts\QuestionChoiceRepositoryInterface;
use App\Repositories\Contracts\ConfirmContentsRepositoryInterface;
use App\Repositories\Contracts\AnswerRepositoryInterface;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use Response;
use Config;
use File;

class SurveyController extends Controller
{
    protected $surveyRepository;
    protected $questionRepository;
    protected $questionChoiceRepository;
    protected $confirmContentRepository;
    protected $answerRepository;
    protected $answerQuestionRepository;

    public function __construct(SurveyRepositoryInterface $surveyRepository,
                                QuestionRepositoryInterface $questionRepository,
                                QuestionChoiceRepositoryInterface $questionChoiceRepository,
                                ConfirmContentsRepositoryInterface $confirmContentRepository,
                                AnswerRepositoryInterface $answerRepository,
                                AnswerQuestionRepositoryInterface $answerQuestionRepository)
    {
        $this->middleware('auth');
        $this->middleware(SecureDownloadSurvey::class);
        $this->surveyRepository = $surveyRepository;
        $this->questionRepository = $questionRepository;
        $this->questionChoiceRepository = $questionChoiceRepository;
        $this->confirmContentRepository = $confirmContentRepository;
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
            'id' => 'survey-table',
            'headers_columns' => array(
                trans('adminlte_lang::survey.survey_list_table_header_column_id') => 'id',
                trans('adminlte_lang::survey.survey_list_table_header_column_status') => 'status',
                trans('adminlte_lang::survey.survey_list_table_header_column_survey_name') => 'name',
                trans('adminlte_lang::survey.survey_list_table_header_column_survey_image') => array(
                    'column' => 'image_path',
                    'type' => 'image'
                ),
                trans('adminlte_lang::survey.survey_list_table_header_column_survey_published_at') => 'published_at',
                trans('adminlte_lang::survey.survey_list_table_header_column_survey_closed_at') => 'closed_at',
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
            'id' => 'download-table',
            'headers_columns' => array(
                trans('adminlte_lang::survey.survey_list_table_header_column_id') => 'id',
                trans('adminlte_lang::survey.survey_list_table_header_column_status') => 'status',
                trans('adminlte_lang::survey.survey_list_table_header_column_survey_name') => 'name',
                trans('adminlte_lang::survey.survey_list_table_header_column_survey_image') => array(
                    'column' => 'image_path',
                    'type' => 'image'
                ),
                trans('adminlte_lang::survey.survey_list_table_header_column_survey_published_at') => 'published_at',
                trans('adminlte_lang::survey.survey_list_table_header_column_survey_closed_at') => 'closed_at',
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
        $answer_datas   = $this->getAnswerForSurveyBySurveyID($id, $list_questions);

        foreach ($list_questions as $question) {
            $headers_columns[$question['text']] = $question['text'];
        }
        $headers_columns[trans('adminlte_lang::survey.time_created')] = 'created_at';

        $buttons = array();
        if ($this->answerRepository->getNumberAnswersBySurveyId($id) > 0)
        {
            $buttons[] = array(
                'text'  => trans('adminlte_lang::survey.button_download_csv'),
                'href'  => \route(Survey::NAME_URL_DOWNLOAD_SURVEY).'/'.$id,
                'attributes' => array(
                    'class' => 'btn btn-primary',
                    'icon'  => 'fa fa-fw fa-download'
                )
            );
        }

        $buttons[] = array(
            'text'  => trans('adminlte_lang::survey.button_clear_data'),
            'href'  => \route(Survey::NAME_URL_DOWNLOAD_SURVEY).'/'.$id,
            'attributes' => array(
                'class' => 'btn bg-orange margin',
                'icon'  => 'fa fa-trash',
                'data-toggle' =>"modal",
                'data-target' => "#modal-confirm-clear-data"
            )
        );


        $table_settings = array(
            'title' => trans('adminlte_lang::survey.answer_download_table'),
            'id' => 'download-page-table',
            'headers_columns' => $headers_columns,
            'controls' => false,
            'buttons' => $buttons
        );

        return view('admin::datatable', array('settings' => $table_settings, 'datas' => $answer_datas));
    }

    public function downloadSurveyCSVFile($id)
    {
        $answer_datas = $this->getAnswerForSurveyBySurveyID($id);
        $headers = [
            'Cache-Control'           => 'must-revalidate, post-check=0, pre-check=0'
            ,   'Content-type'        => 'text/csv'
            ,   'Content-Disposition' => 'attachment; filename='.$this->surveyRepository->getNameSurvey($id).'.csv'
            ,   'Expires'             => '0'
            ,   'Pragma'              => 'public'
        ];

        # add headers for each column in the CSV download
        array_unshift($answer_datas, array_keys($answer_datas[0]));

        $callback = function() use ($answer_datas)
        {
            $FH = fopen('php://output', 'w');
            foreach ($answer_datas as $key => $row) {
                fputcsv($FH, $row);
            }
            fclose($FH);
        };

        return Response::stream($callback, 200, $headers);
    }

    public function getAnswerForSurveyBySurveyID($survey_id, $list_questions = array())
    {
        if (count($list_questions) == 0) {
            $list_questions = $this->questionRepository->getListQuestionBySurveyId($survey_id);
        }

        $list_answers   = $this->answerRepository->getAnswersBySurveyId($survey_id);
        foreach ($list_answers as $key_list_answer => $list_answer) {
            $list_answers[$key_list_answer]['answers'] = $this->answerQuestionRepository->getAnswersByAnswerId($list_answer['id']);
        }

        $answer_questions = array();
        foreach ($list_questions as $question) {
            $answer_questions[$question['id']] = $question['text'];
        }

        $answer_datas = array();
        foreach ($list_answers as $key_list_answer => $list_answer) {
            foreach ($list_answer['answers'] as $key_answer => $answer) {
                foreach ($answer_questions as $key_question => $question) {
                    if ($key_question == $answer['question_id']) {
                        $answer_datas[$key_list_answer][$question] = $answer['text'];
                    }
                }
            }

            $answer_datas[$key_list_answer]['created_at'] = $list_answer['created_at'];
        }

        return $answer_datas;
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
        $input   = Input::all();
        $file    = Input::file('survey_thumbnail');
        $user_id = Auth::id();

        // validate inputs


        // create survey
        $file_name       = $file->getClientOriginalName();
        $destinationPath = Config::get('config.upload_file_path');

        try {
            $path = $destinationPath. '/' . time();
            File::makeDirectory($path, $mode = 0777, true, true);
            $file->move($path, $file_name);
            $image_path = $path . '/' .$file_name;

            $survey = $this->surveyRepository->createEmptyObject();
            $survey->name        = $input['survey_name'];
            $survey->user_id     = $user_id;
            $survey->image_path  = $image_path;
            $survey->description = $input['survey_description'];
            $survey = $this->surveyRepository->save($survey);
        } catch (\Exception $e) {
            var_dump($e->getMessage());
            die('Exception');
        }

        // create questions
        $new_questions = [];
        foreach ($input as $input_name => $value) {
            $split_input_name = explode('_', $input_name);
            if ($split_input_name[0] != 'question' || !$value) {
                continue;
            }

            if (count($split_input_name) == 3) {
                $new_questions[$split_input_name[1]][$split_input_name[2]] = $value;
                continue;
            }

            if ($split_input_name[2] == 'confirmation') {
                if ($split_input_name[3] == 'text') {
                    $new_questions[$split_input_name[1]]['confirmation_text'] = $value;
                } else {
                    $new_questions[$split_input_name[1]]['agree_text'] = $value;
                }

                continue;
            }

            if ($split_input_name[2] == 'choice') {
                $new_questions[$split_input_name[1]]['choice'][] = $value;
            }
        }

        $i = 0;
        foreach ($new_questions as $new_question) {
            $i++;
            $question = $this->questionRepository->createEmptyObject();
            $question->survey_id = $survey->id;
            $question->text      = $new_question['text'];
            $question->type      = $new_question['type'];
            $question->require   = empty($new_question['required']) ? Question::REQUIRE_QUESTION_NO : Question::REQUIRE_QUESTION_YES;
            $question->category  = $new_question['category'];
            $question->no        = $i;
            $question = $this->questionRepository->save($question);

            if ($question->type == Question::TYPE_SINGLE_CHOICE || $question->type == Question::TYPE_MULTI_CHOICE) {
                foreach ($new_question['choice'] as $choice) {
                    $question_choice = $this->questionChoiceRepository->createEmptyObject();
                    $question_choice->question_id = $question->id;
                    $question_choice->text        = $choice;
                    $this->questionChoiceRepository->save($question_choice);
                }
            } elseif ($question->type == Question::TYPE_CONFIRMATION) {
                $confirm_content = $this->confirmContentRepository->createEmptyObject();
                $confirm_content->question_id = $question->id;
                $confirm_content->text        = $new_question['confirmation_text'];
                $this->confirmContentRepository->save($confirm_content);

                if ($question->require == Question::REQUIRE_QUESTION_YES) {
                    $question_choice = $this->questionChoiceRepository->createEmptyObject();
                    $question_choice->question_id = $question->id;
                    $question_choice->text        = $new_question['agree_text'];
                    $this->questionChoiceRepository->save($question_choice);
                }
            }
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function preview(Request $request, $id)
    {
        $survey = $this->surveyRepository->getSurveyById($id);
        $survey['questions'] = $this->questionRepository->getQuestionSurveyBySurveyId($id);
        foreach ($survey['questions'] as $key => $question) {
            $question_choices = $this->questionChoiceRepository->getQuestionChoiceByQuestionId($question['id']);
            if (count($question_choices) > 0) {
                $survey['questions'][$key]['question_choices'] = $question_choices;
            }
        }

        $group_question_survey = array();

        foreach ($survey['questions'] as $question) {
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
