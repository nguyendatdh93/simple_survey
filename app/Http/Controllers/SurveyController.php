<?php

namespace App\Http\Controllers;

use App\BaseWidget\Validator;
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
use OAuth\Common\Storage\Session;
use Response;
use Config;
use File;
use App\Http\Validators\SurveyValidator;

class SurveyController extends Controller
{
    protected $surveyRepository;
    protected $questionRepository;
    protected $questionChoiceRepository;
    protected $confirmContentRepository;
    protected $answerRepository;
    protected $answerQuestionRepository;
    protected $surveyService;
    protected $encryptionService;
    protected $surveyValidator;

    /**
     * SurveyController constructor.
     * @param SurveyRepositoryInterface $surveyRepository
     * @param QuestionRepositoryInterface $questionRepository
     * @param QuestionChoiceRepositoryInterface $questionChoiceRepository
     * @param ConfirmContentsRepositoryInterface $confirmContentRepository
     * @param AnswerRepositoryInterface $answerRepository
     * @param AnswerQuestionRepositoryInterface $answerQuestionRepository
     * @param SurveyService $surveyService
     * @param EncryptionService $encryptionService
     * @param SurveyValidator $surveyValidator
     */
    public function __construct(
        SurveyRepositoryInterface $surveyRepository,
        QuestionRepositoryInterface $questionRepository,
        QuestionChoiceRepositoryInterface $questionChoiceRepository,
        ConfirmContentsRepositoryInterface $confirmContentRepository,
        AnswerRepositoryInterface $answerRepository,
        AnswerQuestionRepositoryInterface $answerQuestionRepository,
        SurveyService $surveyService,
        EncryptionService $encryptionService,
        SurveyValidator $surveyValidator
    ) {
        $this->middleware('auth');
        $this->middleware(SecureDownloadSurvey::class);
        $this->surveyRepository         = $surveyRepository;
        $this->questionRepository       = $questionRepository;
        $this->questionChoiceRepository = $questionChoiceRepository;
        $this->confirmContentRepository = $confirmContentRepository;
        $this->answerRepository         = $answerRepository;
        $this->answerQuestionRepository = $answerQuestionRepository;
        $this->surveyService            = $surveyService;
        $this->encryptionService        = $encryptionService;
        $this->surveyValidator          = $surveyValidator;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showListSurvey()
    {
        $table_settings = array(
            'title' => trans('adminlte_lang::survey.survey_list_table_title'),
            'id'    => 'survey-table',
            'headers_columns' => array(
                trans('adminlte_lang::survey.survey_list_table_header_column_id')           => array(
                	'column' => 'id',
	                'type'   => 'hidden'
                ),
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
            'controls' => true,
            'buttons'  => array(
                array(
                    'text'  => trans('adminlte_lang::survey.button_create_new_survey'),
                    'href'  => \route(Survey::NAME_URL_CREATE_SURVEY),
                    'attributes' => array(
                        'class' => 'btn btn-success',
                        'icon'  => 'glyphicon glyphicon-plus'
                    )
                )
            )
        );

        $surveys = $this->surveyRepository->getAllSurvey();
        $surveys = $this->getDataSurveyForShowing($surveys);
	    $surveys = array_reverse($surveys);

        return view('admin::datatable', array(
            'settings' => $table_settings,
            'data' => $surveys,
            'datatable_script' => 'admin::layouts.partials.script_datatable_survey_list'
        ));
    }

    /**
     * @param $survey
     * @return mixed|string
     */
    public function showNumberAnswers($survey)
    {
        if ($this->answerRepository->getNumberAnswersBySurveyId($survey['id']) > 0) {
            return $this->answerRepository->getNumberAnswersBySurveyId($survey['id']);
        }

        return '-';
    }

    /**
     * @param $surveys
     * @return mixed
     */
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
            if ($survey['image_path'] != null) {
	            $surveys[$key]['image_path'] = \route(Survey::NAME_URL_SHOW_IMAGE).'/'.$this->surveyService->getImageName($survey['image_path']);
            }
        }

        return $surveys;
    }

    /**
     * @param $surveys
     * @return mixed
     */
    public function getSurveyForShowingDownloadList($surveys)
    {
	    foreach ($surveys as $key => $survey) {
		    if ($this->answerRepository->getNumberAnswersBySurveyId($survey['id']) > 0) {
			    $surveys[$key]['number_answers'] = $this->answerRepository->getNumberAnswersBySurveyId($survey['id']);
		    } else {
			    unset($surveys[$key]);
			    continue;
		    }
	    }
	
	    return $surveys;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showDownloadListSurvey()
    {
        $table_settings = array(
            'title' => trans('adminlte_lang::survey.survey_list_table_download_title'),
            'id'    => 'download-table',
            'headers_columns' => array(
                trans('adminlte_lang::survey.survey_list_table_header_column_id')           => array(
	                'column' => 'id',
	                'type'   => 'hidden'
                ),
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
        $surveys = $this->getSurveyForShowingDownloadList($surveys);
        $surveys = $this->getDataSurveyForShowing($surveys);

        return view('admin::datatable', array(
            'settings' => $table_settings,
            'data' => $surveys,
            'datatable_script' => 'admin::layouts.partials.script_datatable_download_list'
        ));
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showDownloadPageSurveyBySurveyId(Request $request, $id)
    {
        $list_questions = $this->questionRepository->getListQuestionBySurveyId($id);
        $answer_data    = $this->getAnswerForSurveyBySurveyID($id, $list_questions);

        foreach ($list_questions as $question) {
            $headers_columns[$question['text']] = $question['text'];
        }
        
        $headers_columns[trans('adminlte_lang::survey.time_created')] = 'created_at';
	
	    if (!$request->session()->get('tokenDownload')) {
		    $request->session()->put('tokenDownload', time());
	    }

        $buttons = array();
        if ($this->answerRepository->getNumberAnswersBySurveyId($id) > 0)
        {
            $buttons[] = array(
                'text'  => trans('adminlte_lang::survey.button_download_csv'),
                'href'  => \route(Survey::NAME_URL_DOWNLOAD_SURVEY).'/'.$id,
                'attributes' => array(
                    'class' => 'btn btn-primary jsButtonDownload',
                    'icon'  => 'glyphicon glyphicon-cloud-download'
                )
            );
            
			$survey_is_downloaded = $this->surveyRepository->checkStatusSurveyIsDownloaded($id);
			$status_survey        = $this->surveyRepository->getStatusSurvey($id);
			if ($survey_is_downloaded['downloaded'] == Survey::STATUS_SURVEY_DOWNLOADED && $status_survey['status'] == Survey::STATUS_SURVEY_CLOSED) {
				$buttons[] = array(
					'text' => trans('adminlte_lang::survey.button_clear_data'),
					'attributes' => array(
						'class'       => 'btn bg-orange margin jsButtonClearData',
						'icon'        => 'glyphicon glyphicon-trash',
						'data-toggle' => "modal",
						'data-target' => "#modal-confirm-clear-data-survey"
					)
				);
			}
        }

        $table_settings = array(
            'title'           => trans('adminlte_lang::survey.answer_download_table'),
            'id'              => 'download-page-table',
            'headers_columns' => $headers_columns,
            'controls'        => false,
            'buttons'         => $buttons
        );

        return view('admin::datatable', array(
            'settings' => $table_settings,
            'data' => $answer_data,'survey_id' => $id,
            'survey_status' => $status_survey['status'],
            'datatable_script' => 'admin::layouts.partials.script_datatable_download_page'
        ));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function downloadSurveyCSVFile($id)
    {
	    $list_questions    = $this->questionRepository->getListQuestionBySurveyId($id);
	    $headers_columns   = array_column($list_questions, 'text');
	    $headers_columns[] = "created_at";
        $answer_data       = $this->getAnswerForSurveyBySurveyID($id);
		foreach ($headers_columns as $column) {
			foreach ($answer_data as $key_answer => $answer) {
				if (!in_array($column, array_keys($answer))) {
					$answer_data[$key_answer][$column] = '';
				}
			}
		}
		
		foreach ($answer_data as $key_answer => $answer) {
			$answer_data[$key_answer] = array_merge(array_flip(array_values($headers_columns)), $answer);
		}
	    
        $headers = [
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
	        'Content-type'        => 'text/csv',
	        'Content-Disposition' => 'attachment; filename='.time().'.csv',
	        'Expires'             => '0',
	        'Pragma'              => 'public',
	        'Content-Encoding'    => 'UTF-8',
	        'charset'             => 'UTF-8'
        ];
		
	    $headers_columns[array_search('created_at', $headers_columns)] = trans('adminlte_lang::survey.column_csv_created_at');
        array_unshift($answer_data, $headers_columns);
		
        $callback = function() use ($answer_data)
        {
            $FH = fopen('php://output', 'w');
            foreach ($answer_data as $key => $row) {
                fputcsv($FH, $row);
            }
            
            fclose($FH);
        };
	    
        $this->surveyRepository->updateStatusDownloadedForSurvey($id);
        
        return Response::stream($callback, 200, $headers);
    }

    /**
     * @param $survey_id
     * @param array $list_questions
     * @return array
     */
    public function getAnswerForSurveyBySurveyID($survey_id, $list_questions = array())
    {
        if (count($list_questions) == 0) {
            $list_questions = $this->questionRepository->getListQuestionBySurveyId($survey_id);
        }

        $list_answers = $this->answerRepository->getAnswersBySurveyId($survey_id);
        foreach ($list_answers as $key_list_answer => $list_answer) {
            $list_answers[$key_list_answer]['answers'] = $this->answerQuestionRepository->getAnswersByAnswerId($list_answer['id']);
        }

        $answer_questions = array();
        foreach ($list_questions as $question) {
            $answer_questions[$question['id']] = $question['text'];
        }

        $answer_data = array();
        foreach ($list_answers as $key_list_answer => $list_answer) {
            foreach ($list_answer['answers'] as $key_answer => $answer) {
            	if (in_array($answer['question_id'],array_keys($answer_questions))) {
		            $answer_data[$key_list_answer][$answer_questions[$answer['question_id']]] = $answer['text'];
	            }
            }

            $answer_data[$key_list_answer]['created_at'] = $list_answer['created_at'];
        }

        return $answer_data;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id = null) {
        $layout = 'admin.survey.edit';
        $question_types = Question::getQuestionTypes();

        if (!$id) {
            return view($layout, ['question_types' => $question_types]);
        }

        $survey = $this->surveyRepository->getSurveyById($id);
        if (!$survey || $survey['status'] == Survey::STATUS_SURVEY_CLOSED) {
            return view('admin::errors.404');
        }

        if ($survey['image_path']) {
            $survey['image_path'] = \route('show-image'). '/' . $this->surveyService->getImageName($survey['image_path']);
        }

        if ($survey['status'] == Survey::STATUS_SURVEY_PUBLISHED) {
            $survey['preview_url']    = \route(Survey::NAME_URL_PREVIEW) . '/' . $survey['id'];
            $survey['encryption_url'] = $this->encryptionService->encrypt($survey['id']);
        }

        $questions = $this->questionRepository->getQuestionsBySurveyId($survey['id']);

        return view($layout, [
            'survey'         => $survey,
            'questions'      => $questions,
            'question_types' => $question_types
        ]);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function duplicate($id) {
        if (!$id) {
            return view('admin::errors.404');
        }

        $layout = 'admin.survey.edit';
        $question_types = Question::getQuestionTypes();

        $survey = $this->surveyRepository->getSurveyById($id);
        if (!$survey) {
            return view('admin::errors.404');
        }

        $questions = $this->questionRepository->getQuestionsBySurveyId($survey['id']);

        $survey['duplicate_id'] = $survey['id'];
        unset($survey['id']);
        unset($survey['status']);
        if ($survey['image_path']) {
            $survey['image_path'] = \route('show-image'). '/' . $this->surveyService->getImageName($survey['image_path']);
        }

        return view($layout, [
            'survey'         => $survey,
            'questions'      => $questions,
            'question_types' => $question_types
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editingPreview(Request $request) {
        $survey    = $request->session()->get('preview_survey');
        $questions = $request->session()->get('preview_questions');

        if (empty($questions)) {
            return view('admin::preview', ['survey' => $survey]);
        }

        foreach ($questions as $key => $question) {
            $survey['questions'][$key]['id'] = 0 - $key;
            $survey['questions'][$key]['survey_id'] = $survey['id'];
            $survey['questions'][$key]['text'] = $question['text'];
            $survey['questions'][$key]['type'] = $question['type'];
            $survey['questions'][$key]['category'] = $question['category'];
            $survey['questions'][$key]['require'] = empty($question['required']) ? Question::REQUIRE_QUESTION_NO : Question::REQUIRE_QUESTION_YES;

            $question_choices = empty($question['choice']) ? [] : $question['choice'];
            if (count($question_choices) > 0) {
                $choices = [];
                foreach ($question_choices as $choice_key => $question_choice) {
                    $choices[] = [
                        'id' => 0 - $choice_key,
                        'text' => $question_choice
                    ];
                }

                $survey['questions'][$key]['question_choices'] = $choices;
            }

            if ($question['type'] == Question::TYPE_CONFIRMATION) {
                $survey['questions'][$key]['question_choices'] = [];
            }

            if (!empty($question['agree_text'])) {
                $survey['questions'][$key]['question_choices'] = [['text' => $question['agree_text']]];
            }

            $confirm_content = empty($question['confirmation_text']) ? '' : $question['confirmation_text'];
            if ($confirm_content) {
                $survey['questions'][$key]['confirm_contents'] = [['text' => $confirm_content]];
            }
        }

        $group_question_survey = [];
        foreach ($survey['questions'] as $question) {
            $group_question_survey[$question['category']][] = $question;
        }

        $survey['questions'] = $group_question_survey;

        return view('admin::preview', ['survey' => $survey]);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function postEditingPreview(Request $request) {
        $input = Input::all();
        $valid = true;

        if (!$this->surveyValidator->validateText($input['survey_name'])) {
            $valid = false;
        } elseif (!$this->surveyValidator->validateText($input['survey_description'], false, 5000)) {
            $valid = false;
        }

        // create new questions data from input text
        $new_questions = $this->getQuestionsDataFromInput($input);

        // validate questions input
        if (!$this->validateQuestionsInput($new_questions)) {
            $valid = false;
        }

        if ($valid) {
            $message = 'OK';

            $survey = [
                'id'          => -1,
                'name'        => $input['survey_name'],
                'image_path'  => '',
                'description' => $input['survey_description'],
                'status'      => Survey::STATUS_SURVEY_DRAF
            ];

            $request->session()->put('preview_survey', $survey);
            $request->session()->put('preview_questions', $new_questions);
        } else {
            $message = trans('survey.error_input_wrong_create_survey');
        }

        return Response::json([
                    'success' => $valid,
                    'message' => $message
                ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function save() {
        $input   = Input::all();
        $file    = Input::file('survey_thumbnail');

        // validate file
        if ($file && !$this->surveyValidator->validateFile($file)) {
            return view('admin::errors.404');
        }

        // validate survey header input
        if (!$this->surveyValidator->validateText($input['survey_name'])) {
            return view('admin::errors.404');
        }

        if (!$this->surveyValidator->validateText($input['survey_description'], false, 5000)) {
            return view('admin::errors.404');
        }

        // create new questions data from input text
        $new_questions = $this->getQuestionsDataFromInput($input);

        // validate questions input
        if (!$this->validateQuestionsInput($new_questions)) {
            return view('admin::errors.404');
        }

        // create or update survey
        $survey = $this->createOrUpdateSurvey($input, $file);
        // create questions of survey
        $this->createQuestions($new_questions, $survey);

        return redirect()->route(Survey::NAME_URL_SURVEY_LIST)->with('alert_success',trans('survey.alert_success_create_survey'));
    }

    /**
     * @param $new_questions
     * @param $survey
     */
    public function createQuestions($new_questions, $survey) {
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

                if ($question->require == Question::REQUIRE_QUESTION_YES && !empty($new_question['agree_text'])) {
                    $question_choice = $this->questionChoiceRepository->createEmptyObject();
                    $question_choice->question_id = $question->id;
                    $question_choice->text        = $new_question['agree_text'];
                    $this->questionChoiceRepository->save($question_choice);
                }
            }
        }
    }

    /**
     * @param $input
     * @param $file
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|mixed
     */
    public function createOrUpdateSurvey($input, $file) {
        $user_id = Auth::id();

        if (empty($input['survey_id'])) {
            $survey = $this->surveyRepository->createEmptyObject();
        } else {
            $filter = [
                'id'      => $input['survey_id'],
                'user_id' => $user_id
            ];
            $survey = $this->surveyRepository->find($filter);
            if (!$survey) {
                return view('admin::errors.404');
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
                return view('admin::errors.500');
            }
        } elseif (!empty($input['duplicate_id'])) {
            $duplicate_survey = $this->surveyRepository->getSurveyById($input['duplicate_id']);
            $survey->image_path = $duplicate_survey['image_path'];
        }
        $survey->description = $input['survey_description'];
        $survey->status = empty($input['survey_status']) ? Survey::STATUS_SURVEY_DRAF : $input['survey_status'] ;
        $survey = $this->surveyRepository->save($survey);

        return $survey;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function preview(Request $request, $id)
    {
	    $survey                   = $this->surveyRepository->getSurveyById($id);
        $survey                   = $this->surveyService->getDataAnswerForSurvey($survey);
        $survey['encryption_url'] = $this->encryptionService->encrypt($id);
        
        return view('admin::preview', array('survey' => $survey, 'name_url' => $request->route()->getName()));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function closeSurveyById($id)
    {
        $result = $this->surveyRepository->closeSurveyById($id);

        if ($result) {
            return redirect()->route(Survey::NAME_URL_SURVEY_LIST)->with('alert_success',trans('adminlte_lang::survey.message_close_survey_success'));
        }

        return redirect()->route(\App\Models\Survey::NAME_URL_EDIT_SURVEY, ['id' => $id])->with('alert_error', trans('adminlte_lang::survey.message_close_survey_not_success'));
    }

    /**
     * @param $id
     * @return bool
     */
    public function clearDataBySurveyId($id)
    {
        if ($id) {
            try {
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
     * @param $input
     * @return array
     */
    public function getQuestionsDataFromInput($input) {
        $new_questions = [];
        foreach ($input as $input_name => $value) {
            $split_input_name = explode('_', $input_name);
            if ($split_input_name[0] != 'question') {
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

        return $new_questions;
    }

    /**
     * @param $questions
     * @return bool
     */
    public function validateQuestionsInput($questions) {
        foreach ($questions as $question) {
            if (!$this->surveyValidator->validateText($question['text'])) {
                return false;
            }

            if (empty($question['category'])) {
                return false;
            }

            if (empty($question['type'])) {
                return false;
            }

            if ($question['type'] == Question::TYPE_SINGLE_TEXT || $question['type'] == Question::TYPE_MULTI_TEXT) {
                continue;
            }

            if ($question['type'] == Question::TYPE_CONFIRMATION) {
                if (!$this->surveyValidator->validateText($question['confirmation_text'], true, 5000)) {
                    return false;
                }

                if (empty($question['required'])) {
                    continue;
                }

                if (!empty($question['agree_text']) && strlen($question['agree_text']) > 255) {
                    return false;
                }

                continue;
            }

            if (empty($question['choice'])) {
                return false;
            }

            foreach ($question['choice'] as $choice) {
                if (!$this->surveyValidator->validateText($choice)) {
                    return false;
                }
            }
        }

        return true;
    }
}
