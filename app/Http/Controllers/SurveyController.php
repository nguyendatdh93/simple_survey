<?php

namespace App\Http\Controllers;

use App\Http\Middleware\SecureDownloadSurvey;
use App\Http\Requests;
use App\Http\Services\EncryptionService;
use App\Http\Services\SurveyService;
use App\Question;
use App\Repositories\Contracts\AnswerQuestionRepositoryInterface;
use App\Repositories\Contracts\ConfirmContentRepositoryInterface;
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
        $this->surveyRepository         = $surveyRepository;
        $this->questionRepository       = $questionRepository;
        $this->questionChoiceRepository = $questionChoiceRepository;
        $this->confirmContentRepository = $confirmContentRepository;
        $this->answerRepository         = $answerRepository;
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
            'id'    => 'survey-table',
            'headers_columns' => array(
                trans('adminlte_lang::survey.survey_list_table_header_column_id')           => 'id',
                trans('adminlte_lang::survey.survey_list_table_header_column_status')       => 'status',
                trans('adminlte_lang::survey.survey_list_table_header_column_survey_name')  => 'name',
                trans('adminlte_lang::survey.survey_list_table_header_column_survey_image') => array(
                    'column' => 'image_path',
                    'type' => 'image'
                ),
                trans('adminlte_lang::survey.survey_list_table_header_column_survey_published_at')   => 'published_at',
                trans('adminlte_lang::survey.survey_list_table_header_column_survey_closed_at')      => 'closed_at',
                trans('adminlte_lang::survey.survey_list_table_header_column_survey_number_answers') => 'number_answers'
            ),
            'controls' => true,
            'buttons'  => array(
                array(
                    'text'  => trans('adminlte_lang::survey.button_create_new_survey'),
                    'href'  => \route(Survey::NAME_URL_CREATE_SURVEY),
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
	        $survey_service                  = new SurveyService();
            $surveys[$key]['image_path']     = \route('show-image').'/'.$survey_service->getImageName($survey['image_path']);
        }

        return $surveys;
    }

    public function downloadListSurvey()
    {
        $table_settings = array(
            'title' => trans('adminlte_lang::survey.survey_list_table_title'),
            'id' => 'download-table',
            'headers_columns' => array(
                trans('adminlte_lang::survey.survey_list_table_header_column_id')           => 'id',
                trans('adminlte_lang::survey.survey_list_table_header_column_status')       => 'status',
                trans('adminlte_lang::survey.survey_list_table_header_column_survey_name')  => 'name',
                trans('adminlte_lang::survey.survey_list_table_header_column_survey_image') => array(
                    'column' => 'image_path',
                    'type'   => 'image'
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
            'title'           => trans('adminlte_lang::survey.answer_download_table'),
            'id'              => 'download-page-table',
            'headers_columns' => $headers_columns,
            'controls'        => false,
            'buttons'         => $buttons
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
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id = null)
    {
        $layout = 'admin.survey.edit';
        $question_types = Question::getQuestionTypes();

        if (!$id) {
            return view($layout, ['question_types' => $question_types]);
        }

        $survey = $this->surveyRepository->getSurveyById($id);
        if (!$survey) {
            die('404');
        }

        $questions = $this->questionRepository->getQuestionsBySurveyId($survey['id']);

        return view($layout, [
            'survey'         => $survey,
            'questions'      => $questions,
            'question_types' => $question_types
        ]);
    }

    public function duplicate($id) {
        if (!$id) {
            die('404 - no survey id for duplicate');
        }

        $layout = 'admin.survey.edit';
        $question_types = Question::getQuestionTypes();

        $survey = $this->surveyRepository->getSurveyById($id);
        if (!$survey) {
            die('404 - no survey for duplicate');
        }

        $questions = $this->questionRepository->getQuestionsBySurveyId($survey['id']);
        unset($survey['id']);

        return view($layout, [
            'survey'         => $survey,
            'questions'      => $questions,
            'question_types' => $question_types
        ]);
    }

    public function save() {
        $input   = Input::all();
        $file    = Input::file('survey_thumbnail');
        $user_id = Auth::id();

        // validate inputs


        // create or update survey
        if (empty($input['survey_id'])) {
            $survey = $this->surveyRepository->createEmptyObject();
        } else {
            $filter = [
                'id'      => $input['survey_id'],
                'user_id' => $user_id
            ];
            $survey = $this->surveyRepository->find($filter);
            if (!$survey) {
                die('404 - no survey');
            }

            // remove all survey questions
            $filter = ['survey_id' => $survey->id];
            $survey_questions = $this->questionRepository->finds($filter);
            foreach ($survey_questions as $question) {
                $this->questionRepository->remove($question);

                $confirmation = $this->confirmContentRepository->find(['question_id' => $question->id]);
                if ($confirmation) {
                    $this->confirmContentRepository->remove($confirmation);
                }

                $question_choices = $this->questionChoiceRepository->finds(['question_id' => $question->id]);
                if ($question_choices) {
                    foreach ($question_choices as $question_choice) {
                        $this->questionChoiceRepository->remove($question_choice);
                    }
                }
            }
        }

        $survey->name    = $input['survey_name'];
        $survey->user_id = $user_id;
        if ($file) {
            // upload file
            $file_name        = $file->getClientOriginalName();
            $destination_path = Config::get('config.upload_file_path');
            try {
                $path = $destination_path. '/' . time();
                File::makeDirectory($path, $mode = 0777, true, true);
                $file->move($path, $file_name);
                $image_path = $path . '/' .$file_name;
                $survey->image_path = $image_path;
            } catch (\Exception $e) {
                var_dump($e->getMessage());
                die('Exception');
            }
        }
        $survey->description = $input['survey_description'];
        $survey = $this->surveyRepository->save($survey);

        // create new questions
        $new_questions = [];
        foreach ($input as $input_name => $value) {
            $split_input_name = explode('_', $input_name);
            if ($split_input_name[0] != 'question' || !$value) {
                continue;
            }

            if ($split_input_name[2] == 'id') {
                $new_questions[$split_input_name[1]]['id'] = $value;
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

            if ($question->type == Question::TYPE_SINGLE_CHOICE
                || $question->type == Question::TYPE_MULTI_CHOICE
            ) {
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

        return redirect()->route(Survey::NAME_URL_SURVEY_LIST)->with('alert_success',trans('adminlte_lang::survey.alert_success_create_survey'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function preview(Request $request, $id)
    {
    	$survey_service           = new SurveyService();
        $survey                   = $survey_service->getDataSurvey($id);
        $encryption_service       = new EncryptionService();
        $survey['encryption_url'] = $encryption_service->encrypt($id);
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

}
