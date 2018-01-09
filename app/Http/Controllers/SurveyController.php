<?php

namespace App\Http\Controllers;

use App\Http\Middleware\SecureDownloadSurvey;
use App\Http\Requests;
use App\Question;
use App\Repositories\Contracts\AnswerQuestionRepositoryInterface;
use App\Repositories\Contracts\ConfirmContentRepositoryInterface;
use App\Survey;
use Illuminate\Http\Request;
use App\Repositories\Contracts\SurveyRepositoryInterface;
use App\Repositories\Contracts\QuestionRepositoryInterface;
use App\Repositories\Contracts\QuestionChoiceRepositoryInterface;
use App\Repositories\Contracts\AnswerRepositoryInterface;
use Illuminate\Support\Facades\Route;
use Response;

class SurveyController extends Controller
{
    protected $surveyRepository;
    protected $questionRepository;
    protected $questionChoiceRepository;
    protected $answerRepository;
    protected $answerQuestionRepository;
    protected $confirmContentRepository;

    public function __construct(SurveyRepositoryInterface $surveyRepository, QuestionRepositoryInterface $questionRepository, QuestionChoiceRepositoryInterface $questionChoiceRepository, AnswerRepositoryInterface $answerRepository, AnswerQuestionRepositoryInterface $answerQuestionRepository, ConfirmContentRepositoryInterface $confirmContentRepository)
    {
        $this->middleware('auth');
        $this->middleware(SecureDownloadSurvey::class);
        $this->surveyRepository = $surveyRepository;
        $this->questionRepository = $questionRepository;
        $this->questionChoiceRepository = $questionChoiceRepository;
        $this->answerRepository = $answerRepository;
        $this->answerQuestionRepository = $answerQuestionRepository;
        $this->confirmContentRepository = $confirmContentRepository;
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
            'controls' => true,
            'buttons'  => array(
                array(
                    'text'  => trans('adminlte_lang::survey.button_create_new_survey'),
                    'href'  => '#',
                    'attributes' => array(
                        'class' => 'btn btn-success',
                        'icon'  => 'fa fa-plus-circle'
                    )
                )
            )
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

            $buttons[] = array(
                'text'  => trans('adminlte_lang::survey.button_clear_data'),
                'attributes' => array(
                    'class'       => 'btn bg-orange margin',
                    'icon'        => 'fa fa-trash',
                    'data-toggle' => "modal",
                    'data-target' => "#modal-confirm-clear-data-survey"
                )
            );
        }

        $table_settings = array(
            'title' => trans('adminlte_lang::survey.answer_download_table'),
            'id' => 'download-page-table',
            'headers_columns' => $headers_columns,
            'controls' => false,
            'buttons' => $buttons
        );

        return view('admin::datatable', array('settings' => $table_settings, 'datas' => $answer_datas,'survey_id' => $id));
    }

    public function downloadSurveyCSVFile($id)
    {
        $answer_datas = $this->getAnswerForSurveyBySurveyID($id);
        $survey_name  = $this->surveyRepository->getNameSurvey($id);
        if (strlen($survey_name) > 50)
        {
            $survey_name = substr($survey_name,0,50);
        }

        $headers = [
            'Cache-Control'           => 'must-revalidate, post-check=0, pre-check=0'
            ,   'Content-type'        => 'text/csv'
            ,   'Content-Disposition' => 'attachment; filename='.$survey_name.'.csv'
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

            $confirm_content = $this->confirmContentRepository->getConfirmContentByQuestionId($question['id']);
            if (count($confirm_content) > 0) {
                $survey['questions'][$key]['confirm_contents'] = $confirm_content;
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
     * @param $id
     * @return bool
     */
    public function clearDataBySurveyId($id)
    {
        if ($id) {
            try {
                $this->surveyRepository->deleteSurvey($id);
                $answers = $this->answerRepository->getAnswersBySurveyId($id);
                foreach ($answers as $answer) {
                    $this->answerQuestionRepository->clearDataByAnswerId($answer['id']);
                }

                $this->answerRepository->clearDataAnswersBySurveyId($id);

                return redirect()->route(Survey::NAME_URL_DOWNLOAD_LIST)->with('alert_success', trans('adminlte_lang::survey.message_clear_data_success'));
            }catch (\Exception $e) {
                return redirect()->route(Survey::NAME_URL_DOWNLOAD_PAGE_SURVEY,['id' => $id])->with('alert_error', trans('adminlte_lang::survey.message_clear_data_not_success'));
            }
        }

        return redirect()->route(Survey::NAME_URL_DOWNLOAD_PAGE_SURVEY,['id' => $id])->with('alert_error', trans('adminlte_lang::survey.message_clear_data_not_success'));
    }
}
