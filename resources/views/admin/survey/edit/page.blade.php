@extends('admin::layouts.app')

@section('htmlheader_title')
    @if (empty($survey['id']))
	    {{ trans('survey.survey_create_page_title') }}
    @else
        {{ trans('survey.survey_edit_page_title') . ' ' . $survey['id'] }}
    @endif
@endsection

@section('main-content-form')
    @include('admin::layouts.partials.alert_message')

    <link rel="stylesheet" href="{{ asset('css/styleedituser.css') }}">
	<div class="container-fluid spark-screen">
		<form method="POST" action="{{ route(\App\Models\Survey::NAME_URL_SAVE_SURVEY) }}" enctype="multipart/form-data" id="survey_form">
		    {{ csrf_field() }}
            @if (!empty($survey['id']))
                <input type="hidden" name="survey_id" value="{{ $survey['id'] }}">

                @if ($survey['status'] == \App\Survey::STATUS_SURVEY_PUBLISHED)
                    <div class="row">
                        <div class="col-md-8 col-md-offset-2">
                            <div class="box box-primary">
                                <div class="box-body" style="padding-left: 30px; padding-right: 30px;">
                                    <div class="navbar-form navbar-right jsCopyUrlForm">
                                        <div class="form-group" style="float: left">
                                            <label class="jsUrlDomainCopy">{{ route(\App\Survey::NAME_URL_ANSWER_SURVEY) }}/</label>
                                            <input type="text" class="form-control jsUrlEncrypt" style="cursor: copy;" value="{{ $survey['encryption_url'] }}" placeholder="Search">
                                        </div>
                                        <a style="float: left; margin-left: 5px;color: #0072ef;cursor: pointer;" class="btn btn-link" style="color: dodgerblue" onclick="copyClipbroad()">{{ trans('adminlte_lang::survey.button_coppy_url') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endif

            @if (!empty($survey['duplicate_id']))
                <input type="hidden" name="duplicate_id" value="{{ $survey['duplicate_id'] }}">
            @endif

            @include('admin::survey.edit.survey_question_template')
            @include('admin::survey.edit.survey_header')
            @include('admin::survey.edit.survey_content')
            @include('admin::survey.edit.survey_footer')
		</form>

        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="box-header"></div>
                    <div class="box-body" style="padding: 5px; text-align: center;">
                        @if(empty($survey['status']) || $survey['status'] == \App\Survey::STATUS_SURVEY_DRAF)
                            {!! FormSimple::button(trans('survey.label_choice_survey_draft_status'), ['data-status' => \App\Survey::STATUS_SURVEY_DRAF, 'class' => 'btn btn-info jsSaveSurvey', 'icon' => 'glyphicon glyphicon-floppy-disk']) !!}
                            {!! FormSimple::button(trans('survey.label_choice_survey_publish_status'), ['data-status' => \App\Survey::STATUS_SURVEY_PUBLISHED, 'class' => 'btn btn-warning jsSaveSurvey', 'icon' => 'glyphicon glyphicon-cloud-upload']) !!}
                        @endif

                        @if(isset($survey['status']) && $survey['status'] == \App\Survey::STATUS_SURVEY_PUBLISHED)
                            {!! FormSimple::button(trans('survey.label_choice_survey_close_status'), ['data-status' => \App\Survey::STATUS_SURVEY_CLOSED, 'class' => 'btn btn-danger jsCloseSurvey']) !!}
                        @endif
                    </div>
                    <div class="box-footer" style="border: none;"></div>
                </div>
            </div>
        </div>

	</div>

    <div style="position: fixed; right: 50px; bottom: 100px; z-index: 99;">
        <button onclick="preview('{{ empty($survey['preview_url']) ? '' : $survey['preview_url'] }}'); return false;"
                data-toggle="tooltip"
                title="{{ trans('survey.button_preview') }}"
                class="btn fly-button jsPreview">
            <i class="glyphicon glyphicon-search" style="font-size: xx-large;"></i>
        </button>
    </div>

    <div class="modal fade" id="modal-confirm-box" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="border: none; padding: 5px;">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -5px;">
                        <span aria-hidden="true">×</span></button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <p></p>
                </div>
                <div class="modal-footer" style="border: none; padding-top: 5px; padding-bottom: 15px; text-align: center;">
                    <button type="button" id="modal-confirm-box-btn-no" class="btn btn-default" data-dismiss="modal"></button>
                    <button type="button" id="modal-confirm-box-btn-yes" class="btn btn-primary"></button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    @parent
    @include('admin::survey.edit.script')
@endsection
