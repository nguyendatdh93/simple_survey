@extends('admin::layouts.app')

@section('htmlheader_title')
    @if (empty($survey['id']))
	    {{ trans('survey.survey_create_page_title') }}
    @else
        {{ trans('survey.survey_edit_page_title') . ' ' . $survey['id'] }}
    @endif
@endsection

@section('main-content-form')
    <link rel="stylesheet" href="{{ asset('css/styleedituser.css') }}">
	<div class="container-fluid spark-screen">
		<form method="post" action="/survey/save" enctype="multipart/form-data" id="survey_form">
		    {{ csrf_field() }}
            @if (!empty($survey['id']))
                <input type="hidden" name="survey_id" value="{{ $survey['id'] }}">
            @endif

            @include('admin::survey.edit_survey_question_template')

            @include('admin::survey.edit_survey_header')
            @include('admin::survey.edit_survey_content')
            @include('admin::survey.edit_survey_footer')

			<div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-default">
                        <div class="box-header"></div>

                        <div class="box-body" style="font-weight: bold; font-size: large;">
                            <div class="row">
                                <div class="col-md-10 col-md-offset-1">
                                    <div class="form-group">
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="survey_status" value="{{ \App\Survey::STATUS_SURVEY_DRAF }}" checked="checked" style="line-height: 30px;">
                                                {{ trans('survey.radio_label_choice_survey_draft_status') }}
                                            </label>
                                        </div>
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="survey_status" value="{{ \App\Survey::STATUS_SURVEY_PUBLISHED }}">
                                                {{ trans('survey.radio_label_choice_survey_publish_status') }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="box-footer" style="padding: 5px; text-align: center;">
                            {!! FormSimple::button(trans('survey.button_submit'), ['type' => 'submit', 'class' => 'btn btn-primary', 'icon' => 'fa fa-cloud-upload']) !!}
                            <button onclick="preview(); return false;" class="btn btn-default jsPreview"><i class="fa fa-eye"></i> {{ trans('survey.button_preview') }}</button>
                        </div>
                    </div>
                </div>
			</div>
		</form>
	</div>

    <div class="modal fade" id="modal-confirm-box" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <p></p>
                </div>
                <div class="modal-footer">
                    <button type="button" id="modal-confirm-box-btn-no" class="btn btn-default pull-left" data-dismiss="modal">No</button>
                    <button type="button" id="modal-confirm-box-btn-yes" class="btn btn-primary">Yes</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

@endsection

@section('scripts')
    @include('admin::layouts.partials.scripts')
    @include('admin::survey.edit_script')
@endsection
