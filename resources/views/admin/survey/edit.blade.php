@extends('admin::layouts.base')

@section('htmlheader_title')
	{{ trans('survey.survey_create_page_title') }}
@endsection

<link rel="stylesheet" href="{{ asset('css/styleedituser.css') }}">
@section('main-content-form')
	<div class="container-fluid spark-screen">
		<form method="post" action="/survey/save" enctype="multipart/form-data" id="survey_form">
		    {{ csrf_field() }}

            @if (!empty($survey['id']))
                <input type="hidden" name="survey_id" value="{{ $survey['id'] }}">
            @endif

			{{-- Survey Header Box --}}
			<div class="row">
				<div class="col-md-8 col-md-offset-2">
					<div class="box">
						<div class="box-header with-border">
							<h3 class="box-title">{{ trans('survey.survey_header_box_title') }}</h3>

							<div class="box-tools pull-right">
								<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
									<i class="fa fa-minus"></i></button>
							</div>
						</div>
						<div class="box-body" style="padding-left: 30px; padding-right: 30px;">
							<div class="form-group row">
								<div class="col-md-3">
									{!! FormSimple::label(trans('survey.survey_name_title'), ['for' => 'survey_name']) !!}
									<span class="jsValidate">※必須</span>
								</div>
								<div class="col-md-9">
									{!! FormSimple::input([
										'type' => 'text',
										'name' => 'survey_name',
										'id' => 'survey_name',
										'class' => 'form-control required jsInputLimit255',
										'value' => empty($survey['name']) ? '' : $survey['name'],
										'help-block' => trans('survey.survey_name_help_block')
									]) !!}
									<p class="jsError" style="color: red; display: none;"></p>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-md-3">
									{!! FormSimple::label(trans('survey.survey_thumbnail_title'), ['for'=> 'survey_thumbnail']) !!}
								</div>
								<div class="col-md-9">
                                    <div class="jsSurveyThumbnailPreviewBox" style="width: 100%; margin-bottom: 5px; @if(empty($survey['image_path'])) display: none; @endif">
                                        <img class="jsSurveyThumbnailPreview" src="{{ empty($survey['image_path']) ? 'no-image' : $survey['image_path'] }}" style="max-height: 200px; max-width: 200px;">
                                    </div>
									{!! FormSimple::input(['type' => 'file', 'name' => 'survey_thumbnail', 'id' => 'survey_thumbnail', 'class' => 'form-control', 'help-block' => trans('survey.survey_thumbnail_help_block')]) !!}
									<p class="jsError" style="color: red; display: none;"></p>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-md-3">
									{!! FormSimple::label(trans('survey.survey_description_title'), ['for'=> 'survey_description']) !!}
								</div>
								<div class="col-md-9">
									{!! FormSimple::textarea([
										'name' => 'survey_description',
										'id'=>'survey_description',
										'class'=> 'form-control jsInputLimit5000',
										'value' => empty($survey['description']) ? '' : $survey['description'],
										'help-block' => trans('survey.survey_description_help_block')
									]) !!}
									<p class="jsError" style="color: red; display: none;"></p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="row jsQuestionTemplate" style="display: none;">
				<div class="col-md-10 col-md-offset-1">
					<div class="panel panel-default" style="margin-bottom: 0;">
						<div class="box-header"></div>

						<div class="box-body" style="padding-left: 40px; padding-right: 20px;">
							<div class="form-group row">
								<div class="col-md-9">
									<input type="hidden" class="jsQuestionCategory">
									<input type="text" class="form-control jsQuestionText required jsInputLimit255" placeholder="{{ trans('survey.survey_question_default_text') }}">
									<p class="help-block">{{ trans('survey.survey_question_help_block_text') }}</p>
									<p class="jsError" style="color: red; display: none;"></p>
								</div>
								<div class="col-md-3">
									<select class="form-control jsChoiceQuestionType jsQuestionType">
										@foreach($question_types as $val => $question_type)
											<option value="{{ $val }}">{{ $question_type }}</option>
										@endforeach
									</select>
								</div>
							</div>

							<div class="form-group jsQuestion jsQuestionSimpleText row">
								<div class="col-md-10">
									<input type="text" class="form-control" placeholder="{{ trans('survey.single_text_placeholder') }}" disabled="disabled">
								</div>
							</div>

							<div class="form-group jsQuestion jsQuestionLongAnswer row" style="display: none;">
								<div class="col-md-10">
									<textarea id="long_answer" class="form-control" rows="4" disabled="disabled" placeholder="{{ trans('survey.multi_text_placeholder') }}">{{ trans('survey.multi_text_placeholder') }}</textarea>
								</div>
							</div>

							<div class="form-group jsQuestion jsQuestionConfirmation row" style="display: none;">
								<div class="col-md-12">
									<textarea id="confirmation" class="form-control jsQuestionConfirmationText required jsInputLimit5000" rows="10"></textarea>
									<p class="help-block">{{ trans('survey.confirmation_help_block') }}</p>
									<p class="jsError" style="color: red; display: none;"></p>
								</div>
								<div class="col-md-12 jsQuestionConfirmationAgreeBox" style="margin-bottom: 5px;">
									<div class="col-md-1">
										<i class="fa fa-square-o" style="font-size: x-large; line-height: 36px;"></i>
									</div>
									<div class="col-md-10">
										<input type="text" class="form-control jsQuestionConfirmationAgreeText jsInputLimit255" placeholder="{{ trans('survey.agree_text_placeholder') }}">
										<p class="jsError" style="color: red; display: none;"></p>
									</div>
								</div>
							</div>

							<div class="form-group jsQuestion jsQuestionChoices row" style="display: none;">
								<div class="col-md-10">
									<div class="row jsChoiceTemplate" style="display: none;">
										<div class="col-md-1 jsQuestionChoice jsQuestionMultiSelect" style="display: none;">
											<i class="fa fa-square-o" style="font-size: x-large; line-height: 36px;"></i>
										</div>
										<div class="col-md-1 jsQuestionChoice jsQuestionSingleChoice" style="display: none;">
											<i class="fa fa-circle-o" style="font-size: x-large; line-height: 36px;"></i>
										</div>
										<div class="col-md-10">
											<input type="text" class="form-control jsQuestionChoiceText required jsInputLimit255">
											<p class="jsError" style="color: red; display: none;"></p>
										</div>
										<div class="col-md-1">
											<i class="fa fa-minus-circle jsRemoveChoice" data-widget="remove" data-toggle="tooltip" title="{{ trans('survey.tooltip_remove_question_choice') }}" style="font-size: large; line-height: 36px; color:red;"></i>
										</div>
									</div>

									<div class="row jsQuestionChoiceBox" data-choice-number="1"  style="margin-bottom: 5px;">
										<div class="col-md-1 jsQuestionChoice jsQuestionMultiSelect" style="display: none;">
											<i class="fa fa-square-o" style="font-size: x-large; line-height: 36px;"></i>
										</div>
										<div class="col-md-1 jsQuestionChoice jsQuestionSingleChoice" style="display: none;">
											<i class="fa fa-circle-o" style="font-size: x-large; line-height: 36px;"></i>
										</div>
										<div class="col-md-10">
											<input type="text" class="form-control jsQuestionChoiceText required jsInputLimit255" placeholder="{{ trans('survey.choice_default_text') }} 1">
											<p class="jsError" style="color: red; display: none;"></p>
										</div>
										<div class="col-md-1">
											<i class="fa fa-minus-circle jsRemoveChoice" data-widget="remove" data-toggle="tooltip" title="{{ trans('survey.tooltip_remove_question_choice') }}" style="font-size: large; line-height: 36px; color:red;"></i>
										</div>
									</div>

									<div class="row jsQuestionChoiceBox" data-choice-number="2" style="margin-bottom: 5px;">
										<div class="col-md-1 jsQuestionChoice jsQuestionMultiSelect" style="display: none;">
											<i class="fa fa-square-o" style="font-size: x-large; line-height: 36px;"></i>
										</div>
										<div class="col-md-1 jsQuestionChoice jsQuestionSingleChoice" style="display: none;">
											<i class="fa fa-circle-o" style="font-size: x-large; line-height: 36px;"></i>
										</div>
										<div class="col-md-10">
											<input type="text" class="form-control jsQuestionChoiceText required jsInputLimit255" placeholder="{{ trans('survey.choice_default_text') }} 2">
											<p class="jsError" style="color: red; display: none;"></p>
										</div>
										<div class="col-md-1">
											<i class="fa fa-minus-circle jsRemoveChoice" data-widget="remove" data-toggle="tooltip" title="{{ trans('survey.tooltip_remove_question_choice') }}" style="font-size: large; line-height: 36px; color:red;"></i>
										</div>
									</div>

									<div class="row">
										<div class="col-md-10 col-md-offset-1">
											<i class="fa fa-plus-square jsAddChoice" data-widget="add" data-toggle="tooltip" title="{{ trans('survey.tooltip_add_question_choice') }}" style="font-size: x-large; line-height: 36px; color:green;"></i>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="box-footer" style="padding: 5px;">
							<div class="box-tools pull-right">
								<button type="button" class="btn btn-box-tool jsDuplicateQuestion" style="padding: 0px; margin: 0 5px; display: none;">
									<i class="fa fa-clone" style="font-size: x-large;"></i></button>
								<button type="button" data-widget="remove" data-toggle="tooltip" title="{{ trans('survey.tooltip_remove_question') }}" class="btn btn-box-tool jsRemoveQuestion" style="padding: 0px; margin: 0 5px;">
									<i class="fa fa-trash-o" style="font-size: x-large;"></i></button>
								<div class="jsQuestionRequiredBox" style="display: inline;">
									<span class="btn btn-box-tool" style="padding: 0px; margin: 0 20px; font-size: x-large;">|</span>
									<span style="margin: 0 5px; vertical-align: middle; font-size: large;">{{ trans('survey.require_toggle') }}</span>
									<label class="switch" style="margin: 0; vertical-align: middle;">
										<input type="checkbox" class="jsQuestionRequired" value="1">
										<span class="slider round"></span>
									</label>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			{{-- Survey Content Box --}}
			<div class="row">
				<div class="col-md-8 col-md-offset-2">
					<div class="box">
						<div class="box-header with-border">
							<h3 class="box-title">{{ trans('survey.survey_content_box_title') }}</h3>
							<div class="box-tools pull-right">
								<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
									<i class="fa fa-minus"></i></button>
							</div>
						</div>
						<div class="box-body">
							<div>
								<div class="row">
									<div class="col-md-10 col-md-offset-1" style="margin-top: 10px; margin-bottom: 10px;">
										<div class="pull-right">
											<button type="button" class="btn btn-success btn-sm jsAddQuestion" data-question-category="{{ \App\Question::CATEGORY_CONTENT }}">
												<i class="fa fa-plus"></i> {{ trans('survey.survey_add_question_button') }}
											</button>
										</div>
									</div>
								</div>
							</div>

							@if(!empty($questions['content']))
								@php($question_number = 0)
								@foreach($questions['content'] as $question_id => $question)
									@php($question_number++)
									<div class="jsQuestionBox" data-number="{{ $question_number }}" id="jsQuestionBox_{{ $question_number }}">
										<div class="row">
											<div class="col-md-10 col-md-offset-1">
												<div class="panel panel-default" style="margin-bottom: 0;">
													<div class="box-header"></div>

													<div class="box-body" style="padding-left: 40px; padding-right: 20px; ">
														<div class="form-group row">
															<div class="col-md-9">
																<input type="hidden"
																	   name="question_{{ $question_number }}_id"
																	   value="{{ $question_id }}">
																<input type="hidden"
																	   name="question_{{ $question_number }}_category"
																	   class="jsQuestionCategory"
																	   value="{{ \App\Question::CATEGORY_CONTENT }}">
																<input type="text"
																	   name="question_{{ $question_number }}_text"
																	   class="form-control jsQuestionText required jsInputLimit255"
																	   value="{{ $question['text'] }}"
																	   placeholder="{{ trans('survey.survey_question_default_text') }}">
																<p class="help-block">{{ trans('survey.survey_question_help_block_text') }}</p>
																<p class="jsError" style="color: red; display: none;"></p>
															</div>
															<div class="col-md-3">
																<select name="question_{{ $question_number }}_type" class="form-control jsChoiceQuestionType jsQuestionType">
																	@foreach($question_types as $val => $question_type)
																		@if($val != \App\Question::TYPE_CONFIRMATION)
																			<option value="{{ $val }}" @if($question['type'] == $val) selected="selected" @endif>{{ $question_type }}</option>
																		@endif
																	@endforeach
																</select>
															</div>
														</div>

														<div class="form-group jsQuestion jsQuestionSimpleText row" @if($question['type'] != \App\Question::TYPE_SINGLE_TEXT) style="display: none;" @endif >
															<div class="col-md-10">
																<input type="text" class="form-control" placeholder="{{ trans('survey.single_text_placeholder') }}" disabled="disabled">
															</div>
														</div>

														<div class="form-group jsQuestion jsQuestionLongAnswer row" @if($question['type'] != \App\Question::TYPE_MULTI_TEXT) style="display: none;" @endif >
															<div class="col-md-10">
																<textarea id="long_answer" class="form-control" rows="4" disabled="disabled" placeholder="{{ trans('survey.multi_text_placeholder') }}">{{ trans('survey.multi_text_placeholder') }}</textarea>
															</div>
														</div>

														<div class="form-group jsQuestion jsQuestionConfirmation row" @if($question['type'] != \App\Question::TYPE_CONFIRMATION) style="display: none;" @endif >
															<div class="col-md-12">
																<textarea id="question_{{ $question_number }}_confirmation_text"
																		  name="question_{{ $question_number }}_confirmation_text"
																		  class="form-control jsQuestionConfirmationText required jsInputLimit5000"
																		  rows="10">{{ empty($question['confirm_text']) ? '' : $question['confirm_text'] }}</textarea>
																<p class="help-block">{{ trans('survey.confirmation_help_block') }}</p>
																<p class="jsError" style="color: red; display: none;"></p>
															</div>
															<div class="col-md-12 jsQuestionConfirmationAgreeBox" style="margin-bottom: 5px;">
																<div class="col-md-1">
																	<i class="fa fa-square-o" style="font-size: x-large; line-height: 36px;"></i>
																</div>
																<div class="col-md-10">
																	<input type="text"
																		   name="question_{{ $question_number }}_confirmation_agree_text"
																		   class="form-control jsQuestionConfirmationAgreeText jsInputLimit255"
																		   value="{{ empty($question['agree_text']) ? '' : $question['agree_text'] }}"
																		   placeholder="{{ trans('survey.agree_text_placeholder') }}">
																	<p class="jsError" style="color: red; display: none;"></p>
																</div>
															</div>
														</div>

														<div class="form-group jsQuestion jsQuestionChoices row" @if($question['type'] != \App\Question::TYPE_SINGLE_CHOICE && $question['type'] != \App\Question::TYPE_MULTI_CHOICE) style="display: none;" @endif >
															<div class="col-md-10">
																<div class="row jsChoiceTemplate" style="display: none;">
																	<div class="col-md-1 jsQuestionChoice jsQuestionMultiSelect" @if($question['type'] != \App\Question::TYPE_MULTI_CHOICE) style="display: none;" @endif >
																		<i class="fa fa-square-o" style="font-size: x-large; line-height: 36px;"></i>
																	</div>
																	<div class="col-md-1 jsQuestionChoice jsQuestionSingleChoice" @if($question['type'] != \App\Question::TYPE_SINGLE_CHOICE) style="display: none;" @endif >
																		<i class="fa fa-circle-o" style="font-size: x-large; line-height: 36px;"></i>
																	</div>
																	<div class="col-md-10">
																		<input type="text" class="form-control jsQuestionChoiceText required jsInputLimit255">
																		<p class="jsError" style="color: red; display: none;"></p>
																	</div>
																	<div class="col-md-1">
																		<i class="fa fa-minus-circle jsRemoveChoice" data-widget="remove" data-toggle="tooltip" title="{{ trans('survey.tooltip_remove_question_choice') }}" style="font-size: large; line-height: 36px; color:red;"></i>
																	</div>
																</div>

																@if($question['type'] == \App\Question::TYPE_SINGLE_CHOICE || $question['type'] == \App\Question::TYPE_MULTI_CHOICE)
																	@php($choice_no = 0)
																	@foreach($question['choice'] as $choice)
																		@php($choice_no++)
																		<div class="row jsQuestionChoiceBox" data-choice-number="{{ $choice_no }}"  style="margin-bottom: 5px;">
																			<div class="col-md-1 jsQuestionChoice jsQuestionMultiSelect" @if($question['type'] != \App\Question::TYPE_MULTI_CHOICE) style="display: none;" @endif >
																				<i class="fa fa-square-o" style="font-size: x-large; line-height: 36px;"></i>
																			</div>
																			<div class="col-md-1 jsQuestionChoice jsQuestionSingleChoice" @if($question['type'] != \App\Question::TYPE_SINGLE_CHOICE) style="display: none;" @endif >
																				<i class="fa fa-circle-o" style="font-size: x-large; line-height: 36px;"></i>
																			</div>
																			<div class="col-md-10">
																				<input type="text"
																					   name="question_{{ $question_number }}_choice_{{ $choice_no }}_text"
																					   class="form-control jsQuestionChoiceText required jsInputLimit255"
																					   value="{{ $choice }}"
																					   placeholder="{{ trans('survey.choice_default_text') }} {{ $choice_no }}">
																				<p class="jsError" style="color: red; display: none;"></p>
																			</div>
																			<div class="col-md-1">
																				<i class="fa fa-minus-circle jsRemoveChoice" data-widget="remove" data-toggle="tooltip" title="{{ trans('survey.tooltip_remove_question_choice') }}" style="font-size: large; line-height: 36px; color:red;"></i>
																			</div>
																		</div>
																	@endforeach
																@endif

																<div class="row">
																	<div class="col-md-10 col-md-offset-1">
																		<i class="fa fa-plus-square jsAddChoice" data-widget="add" data-toggle="tooltip" title="{{ trans('survey.tooltip_add_question_choice') }}" style="font-size: x-large; line-height: 36px; color:green;"></i>
																	</div>
																</div>
															</div>
														</div>
													</div>

													<div class="box-footer" style="padding: 5px;">
														<div class="box-tools pull-right">
															<button type="button" class="btn btn-box-tool jsDuplicateQuestion" style="padding: 0px; margin: 0 5px; display: none;">
																<i class="fa fa-clone" style="font-size: x-large;"></i></button>
															<button type="button" data-widget="remove" data-toggle="tooltip" title="{{ trans('survey.tooltip_remove_question') }}" class="btn btn-box-tool jsRemoveQuestion" style="padding: 0px; margin: 0 5px;">
																<i class="fa fa-trash-o" style="font-size: x-large;"></i></button>
															<div class="jsQuestionRequiredBox" style="display: inline;">
																<span class="btn btn-box-tool" style="padding: 0px; margin: 0 20px; font-size: x-large;">|</span>
																<span style="margin: 0 5px; vertical-align: middle; font-size: large;">{{ trans('survey.require_toggle') }}</span>
																<label class="switch" style="margin: 0; vertical-align: middle;">
																	<input type="checkbox"
																		   name="question_{{ $question_number }}_required"
																		   class="jsQuestionRequired"
																		   value="1" {{ $question['require'] == \App\Question::REQUIRE_QUESTION_YES ? 'checked="checked"' : '' }}>
																	<span class="slider round"></span>
																</label>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-md-10 col-md-offset-1" style="margin-top: 10px; margin-bottom: 10px;">
												<div class="pull-right">
													<button type="button" class="btn btn-success btn-sm jsAddQuestion" data-question-category="{{ \App\Question::CATEGORY_CONTENT }}">
														<i class="fa fa-plus"></i> {{ trans('survey.survey_add_question_button') }}
													</button>
												</div>
											</div>
										</div>
									</div>
								@endforeach
							@endif
						</div>
					</div>
				</div>
			</div>

			{{-- Survey Footer Box --}}
			<div class="row">
				<div class="col-md-8 col-md-offset-2">
					<div class="box">
						<div class="box-header with-border">
							<h3 class="box-title">{{ trans('survey.survey_footer_box_title') }}</h3>
							<div class="box-tools pull-right">
								<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
									<i class="fa fa-minus"></i></button>
							</div>
						</div>
						<div class="box-body">
							<div>
								<div class="row">
									<div class="col-md-10 col-md-offset-1" style="margin-top: 10px; margin-bottom: 10px;">
										<div class="pull-right">
											<button type="button" class="btn btn-success btn-sm jsAddQuestion" data-question-category="{{ \App\Question::CATEGORY_FOOTER }}">
												<i class="fa fa-plus"></i> {{ trans('survey.survey_add_question_button') }}
											</button>
										</div>
									</div>
								</div>
							</div>

							@if(!empty($questions['footer']))
								@php($question_number = count($questions['content']))
								@foreach($questions['footer'] as $question_id => $question)
									@php($question_number++)
									<div class="jsQuestionBox" data-number="{{ $question_number }}" id="jsQuestionBox_{{ $question_number }}">
										<div class="row">
											<div class="col-md-10 col-md-offset-1">
												<div class="panel panel-default" style="margin-bottom: 0;">
													<div class="box-header"></div>

													<div class="box-body" style="padding-left: 40px; padding-right: 20px; ">
														<div class="form-group row">
															<div class="col-md-9">
																<input type="hidden"
																	   name="question_{{ $question_number }}_id"
																	   value="{{ $question_id }}">
																<input type="hidden"
																	   name="question_{{ $question_number }}_category"
																	   class="jsQuestionCategory"
																	   value="{{ \App\Question::CATEGORY_FOOTER }}">
																<input type="text"
																	   name="question_{{ $question_number }}_text"
																	   class="form-control jsQuestionText required jsInputLimit255"
																	   value="{{ $question['text'] }}"
																	   placeholder="{{ trans('survey.survey_question_default_text') }}">
																<p class="help-block">{{ trans('survey.survey_question_help_block_text') }}</p>
																<p class="jsError" style="color: red; display: none;"></p>
															</div>
															<div class="col-md-3">
																<select name="question_{{ $question_number }}_type" class="form-control jsChoiceQuestionType jsQuestionType">
																	@foreach($question_types as $val => $question_type)
																		@if($val == \App\Question::TYPE_CONFIRMATION)
																			<option value="{{ $val }}" @if($question['type'] == $val) selected="selected" @endif>{{ $question_type }}</option>
																		@endif
																	@endforeach
																</select>
															</div>
														</div>

														<div class="form-group jsQuestion jsQuestionSimpleText row" @if($question['type'] != \App\Question::TYPE_SINGLE_TEXT) style="display: none;" @endif >
															<div class="col-md-10">
																<input type="text" class="form-control" placeholder="{{ trans('survey.single_text_placeholder') }}" disabled="disabled">
															</div>
														</div>

														<div class="form-group jsQuestion jsQuestionLongAnswer row" @if($question['type'] != \App\Question::TYPE_MULTI_TEXT) style="display: none;" @endif >
															<div class="col-md-10">
																<textarea id="long_answer" class="form-control" rows="4" disabled="disabled" placeholder="{{ trans('survey.multi_text_placeholder') }}">{{ trans('survey.multi_text_placeholder') }}</textarea>
															</div>
														</div>

														<div class="form-group jsQuestion jsQuestionConfirmation row" @if($question['type'] != \App\Question::TYPE_CONFIRMATION) style="display: none;" @endif >
															<div class="col-md-12">
																<textarea id="question_{{ $question_number }}_confirmation_text"
																		  name="question_{{ $question_number }}_confirmation_text"
																		  class="form-control jsQuestionConfirmationText required jsInputLimit5000"
																		  rows="10">{{ empty($question['confirm_text']) ? '' : $question['confirm_text'] }}</textarea>
																<p class="help-block">{{ trans('survey.confirmation_help_block') }}</p>
																<p class="jsError" style="color: red; display: none;"></p>
															</div>
															<div class="col-md-12 jsQuestionConfirmationAgreeBox" style="margin-bottom: 5px;">
																<div class="col-md-1">
																	<i class="fa fa-square-o" style="font-size: x-large; line-height: 36px;"></i>
																</div>
																<div class="col-md-10">
																	<input type="text"
																		   name="question_{{ $question_number }}_confirmation_agree_text"
																		   class="form-control jsQuestionConfirmationAgreeText jsInputLimit255"
																		   value="{{ empty($question['agree_text']) ? '' : $question['agree_text'] }}"
																		   placeholder="{{ trans('survey.agree_text_placeholder') }}">
																	<p class="jsError" style="color: red; display: none;"></p>
																</div>
															</div>
														</div>

														<div class="form-group jsQuestion jsQuestionChoices row" @if($question['type'] != \App\Question::TYPE_SINGLE_CHOICE && $question['type'] != \App\Question::TYPE_MULTI_CHOICE) style="display: none;" @endif >
															<div class="col-md-10">
																<div class="row jsChoiceTemplate" style="display: none;">
																	<div class="col-md-1 jsQuestionChoice jsQuestionMultiSelect" @if($question['type'] != \App\Question::TYPE_MULTI_CHOICE) style="display: none;" @endif >
																		<i class="fa fa-square-o" style="font-size: x-large; line-height: 36px;"></i>
																	</div>
																	<div class="col-md-1 jsQuestionChoice jsQuestionSingleChoice" @if($question['type'] != \App\Question::TYPE_SINGLE_CHOICE) style="display: none;" @endif >
																		<i class="fa fa-circle-o" style="font-size: x-large; line-height: 36px;"></i>
																	</div>
																	<div class="col-md-10">
																		<input type="text" class="form-control jsQuestionChoiceText required jsInputLimit255">
																		<p class="jsError" style="color: red; display: none;"></p>
																	</div>
																	<div class="col-md-1">
																		<i class="fa fa-minus-circle jsRemoveChoice" style="font-size: large; line-height: 36px; color:red;"></i>
																	</div>
																</div>

																@if($question['type'] == \App\Question::TYPE_SINGLE_CHOICE || $question['type'] == \App\Question::TYPE_MULTI_CHOICE)
																	@php($choice_no = 0)
																	@foreach($question['choice'] as $choice)
																		@php($choice_no++)
																		<div class="row jsQuestionChoiceBox" data-choice-number="{{ $choice_no }}"  style="margin-bottom: 5px;">
																			<div class="col-md-1 jsQuestionChoice jsQuestionMultiSelect" @if($question['type'] != \App\Question::TYPE_MULTI_CHOICE) style="display: none;" @endif >
																				<i class="fa fa-square-o" style="font-size: x-large; line-height: 36px;"></i>
																			</div>
																			<div class="col-md-1 jsQuestionChoice jsQuestionSingleChoice" @if($question['type'] != \App\Question::TYPE_SINGLE_CHOICE) style="display: none;" @endif >
																				<i class="fa fa-circle-o" style="font-size: x-large; line-height: 36px;"></i>
																			</div>
																			<div class="col-md-10">
																				<input type="text"
																					   name="question_{{ $question_number }}_choice_{{ $choice_no }}_text"
																					   class="form-control jsQuestionChoiceText required jsInputLimit255"
																					   value="{{ $choice }}"
																					   placeholder="{{ trans('survey.choice_default_text') }} {{ $choice_no }}">
																				<p class="jsError" style="color: red; display: none;"></p>
																			</div>
																			<div class="col-md-1">
																				<i class="fa fa-minus-circle jsRemoveChoice" data-widget="remove" data-toggle="tooltip" title="{{ trans('survey.tooltip_remove_question_choice') }}" style="font-size: large; line-height: 36px; color:red;"></i>
																			</div>
																		</div>
																	@endforeach
																@endif

																<div class="row">
																	<div class="col-md-10 col-md-offset-1">
																		<i class="fa fa-plus-square jsAddChoice" data-widget="add" data-toggle="tooltip" title="{{ trans('survey.tooltip_add_question_choice') }}" style="font-size: x-large; line-height: 36px; color:green;"></i>
																	</div>
																</div>
															</div>
														</div>
													</div>

													<div class="box-footer" style="padding: 5px;">
														<div class="box-tools pull-right">
															<button type="button" class="btn btn-box-tool jsDuplicateQuestion" style="padding: 0px; margin: 0 5px; display: none;">
																<i class="fa fa-clone" style="font-size: x-large;"></i></button>
															<button type="button" data-widget="remove" data-toggle="tooltip" title="{{ trans('survey.tooltip_remove_question') }}" class="btn btn-box-tool jsRemoveQuestion" style="padding: 0px; margin: 0 5px;">
																<i class="fa fa-trash-o" style="font-size: x-large;"></i></button>
															<div class="jsQuestionRequiredBox" style="display: none;">
																<span class="btn btn-box-tool" style="padding: 0px; margin: 0 20px; font-size: x-large;">|</span>
																<span style="margin: 0 5px; vertical-align: middle; font-size: large;">{{ trans('survey.require_toggle') }}</span>
																<label class="switch" style="margin: 0; vertical-align: middle;">
																	<input type="checkbox"
																		   name="question_{{ $question_number }}_required"
																		   class="jsQuestionRequired"
																		   value="1"
																		   checked="checked">
																	<span class="slider round"></span>
																</label>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-md-10 col-md-offset-1" style="margin-top: 10px; margin-bottom: 10px;">
												<div class="pull-right">
													<button type="button" class="btn btn-success btn-sm jsAddQuestion" data-question-category="{{ \App\Question::CATEGORY_FOOTER }}">
														<i class="fa fa-plus"></i> {{ trans('survey.survey_add_question_button') }}
													</button>
												</div>
											</div>
										</div>
									</div>
								@endforeach
							@endif
						</div>
					</div>
				</div>
			</div>

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
@endsection

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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script>
	$( document ).ready(function() {
		CKEDITOR.on("instanceCreated", function(event) {
			event.editor.on("blur", function () {
				event.editor.updateElement();

				var textarea_name = event.editor.name;
				validateOnChange($('textarea[name=' + textarea_name + ']'));
			});
		});

		CKEDITOR.replace('survey_description');

		var number_of_questions = {{ empty($questions['content']) ? 0 : count($questions['content']) }} + {{ empty($questions['footer']) ? 0 : count($questions['footer']) }};
		if (number_of_questions > 0) {
			for (var i = 1; i <= number_of_questions; i++) {
				var editor_id = 'question_' + i + '_confirmation_text';
				CKEDITOR.replace(editor_id);
			}
		}

        sessionStorage.preview_image = $('.jsSurveyThumbnailPreview').attr('src');

        var preview_tab;
	});

	$(document).on('click', '.jsRemoveChoice',function(){
		$(this).parent().parent().remove();
		$('.tooltip').tooltip('destroy');
	});

	$(document).on('click', '.jsRemoveQuestion', function () {
		$(this).parent().parent().parent().parent().parent().parent().remove();
		$('.tooltip').tooltip('destroy');
	});

	$(document).on('change', '.jsChoiceQuestionType', function () {
		var question_type = $(this).find(":selected").val(),
			question_box = $(this).parent().parent().parent();

		question_box.children('.jsQuestion').hide();

		if (question_type == 1) {
			question_box.children(".jsQuestionSimpleText").show();
		} else if (question_type == 2) {
			question_box.children(".jsQuestionLongAnswer").show();
		} else if (question_type == 3 || question_type == 4) {
			var question_choices = question_box.children(".jsQuestionChoices");
			question_choices.show();

			if (question_type == 3) {
				question_choices.find('.jsQuestionChoice').hide();
				question_choices.find('.jsQuestionSingleChoice').show();
			} else if (question_type == 4) {
				question_choices.find('.jsQuestionChoice').hide();
				question_choices.find('.jsQuestionMultiSelect').show();
			}
		} else if (question_type == 5) {
			question_box.children(".jsQuestionConfirmation").show();
		}
	});

	$(document).on('click', '.jsAddChoice', function () {
		var new_choice_inner_html = $(this).parent().parent().parent().children('.jsChoiceTemplate').html(),
			question = $(this).parent().parent().parent().parent(),
			max_choice_number = 0,
			choice_boxes = question.find('.jsQuestionChoiceBox'),
			number_of_choices = choice_boxes.length,
			new_choice, new_choice_text;

		if (number_of_choices == 0) {
			max_choice_number = 1;
		} else {
			choice_boxes.each(function () {
				var choice_number = $(this).data('choice-number');
				if (max_choice_number < choice_number) {
					max_choice_number = choice_number;
				}
			});

			max_choice_number += 1;
		}

		var new_choice_html = '<div class="row jsQuestionChoiceBox" data-choice-number="' + max_choice_number + '" style="margin-bottom: 5px;">' + new_choice_inner_html + '</div>';
		$(new_choice_html).insertBefore($(this).parent().parent());

		question.find('.jsQuestionChoiceBox').each(function () {
			if ($(this).data('choice-number') == max_choice_number) {
				new_choice = $(this);
				new_choice_text = $(this).find('.jsQuestionChoiceText');
				return false;
			}
		});

		var question_number = $(this).parent().parent().parent().parent().parent().parent().parent().parent().parent().data('number');
		new_choice.attr('data-choice-number', max_choice_number);
		new_choice_text.attr('name', 'question_' + question_number + '_choice_' + max_choice_number + "_text")
				.attr('placeholder', '{{ trans('survey.choice_default_text') }}' + ' ' + max_choice_number);
	});

	$(document).on('click', '.jsAddQuestion', function () {
		var new_question_inner_html = $('.jsQuestionTemplate').html(),
			new_question_html = '<div class="row">' + new_question_inner_html + '</div>',
			new_add_question_button_inner_html = $(this).parent().parent().parent().html(),
			new_add_question_button_html = '<div class="row">' + new_add_question_button_inner_html + '</div>',
            question_boxes = $('.jsQuestionBox'),
            number_of_questions = question_boxes.length,
            max_number = 0,
            new_question_box_id = '',
            new_question_box_html = '',
			question_category_value = $(this).data('question-category');

        if (number_of_questions == 0) {
            max_number = 1;
            new_question_box_id = 'jsQuestionBox_' + max_number;
        } else {
            question_boxes.each(function () {
                var question_number = $(this).data('number');

                if (max_number < question_number) {
                    max_number = question_number;
                }
            });

            max_number += 1;
            new_question_box_id = 'jsQuestionBox_' + max_number;
        }

        new_question_box_html += '<div class="jsQuestionBox" data-number="' + max_number + '" id="' + new_question_box_id + '">' + new_question_html + new_add_question_button_html + '</div>';
		$(new_question_box_html).insertAfter($(this).parent().parent().parent().parent());

        var new_question = $('#' + new_question_box_id);

		var question_category = new_question.find('.jsQuestionCategory')[0];
		$(question_category).attr('name', 'question_' + max_number + '_category')
				.attr('value', question_category_value);

        var question_text = new_question.find('.jsQuestionText')[0];
        $(question_text).attr('name', 'question_' + max_number + '_text');

		var question_confirmation_text = new_question.find('.jsQuestionConfirmationText')[0];
		var question_confirmation_text_id = 'question_' + max_number + '_confirmation_text';
		$(question_confirmation_text).attr('name', question_confirmation_text_id);
		$(question_confirmation_text).attr('id', question_confirmation_text_id);
		CKEDITOR.replace(question_confirmation_text_id);


		var question_confirmation_agree_text = new_question.find('.jsQuestionConfirmationAgreeText')[0];
		$(question_confirmation_agree_text).attr('name', 'question_' + max_number + '_confirmation_agree_text');

        var question_type = new_question.find('.jsQuestionType')[0];
        $(question_type).attr('name', 'question_' + max_number + '_type');

        var question_require = new_question.find('.jsQuestionRequired')[0];
        $(question_require).attr('name', 'question_' + max_number + '_required');

        new_question.find('.jsQuestionChoiceBox').each(function () {
			var question_choice_number = $(this).data('choice-number');
			$(this).find('.jsQuestionChoiceText').attr('name', 'question_' + max_number + '_choice_' + question_choice_number + '_text');
        });

		if (question_category_value == {{ \App\Question::CATEGORY_CONTENT }}) {
			$(question_type).find('option').each(function () {
				if ($(this).val() == {{ \App\Question::TYPE_CONFIRMATION }}) {
					$(this).remove();
				}
			});
		} else if (question_category_value == {{ \App\Question::CATEGORY_FOOTER }}) {
			$(question_type).find('option').each(function () {
				if ($(this).val() != {{ \App\Question::TYPE_CONFIRMATION }}) {
					$(this).remove();
				}
			});

			new_question.find('.jsQuestion').hide();
			new_question.find('.jsQuestionConfirmation').show();
			new_question.find('.jsQuestionRequiredBox').hide();
			new_question.find('.jsQuestionRequired').attr('checked', 'checked');
		}
	});

	$(document).on('click', '.jsQuestionRequired', function () {
		var agree_box = $(this).parent().parent().parent().parent().parent().find('.jsQuestionConfirmationAgreeBox');

		if ($(this).is(':checked')) {
			agree_box.show();
		} else {
			agree_box.hide();
		}
	});

	$(document).on('click', '.jsDuplicateQuestion', function () {
		var new_question_box_inner_html = $(this).parent().parent().parent().parent().parent().parent().html(),
			new_html = '<div>' + new_question_box_inner_html + '</div>';

		$(new_html).insertAfter($(this).parent().parent().parent().parent().parent().parent());
	});

	$(document).on('change', 'input', function(event) {
		validateOnChange(this);
	});

    $(document).on('change', 'input[name=survey_thumbnail]', function(event) {
        var input_file = $(this)[0].files[0];

        if (!input_file) {
            $('.jsSurveyThumbnailPreview').attr('src', 'no-image');
            $('.jsSurveyThumbnailPreviewBox').hide();
            sessionStorage.preview_image = 'no-image';
            return false;
        }

        if (validateFile(this)) {
            previewImage(this);
        }
    });

	$(document).on('submit', '#survey_form', function(event) {
		if (validateOnSubmit()) {
			var survey_status = $('input[name=survey_status]:checked').val();
			var survey_status_text = '';

			if (survey_status == '{{ \App\Survey::STATUS_SURVEY_DRAF }}') {
				console.log(survey_status);
				survey_status_text = '{{ trans('survey.radio_label_choice_survey_draft_status') }}';
			} else if (survey_status == {{ \App\Survey::STATUS_SURVEY_PUBLISHED }}) {
				console.log(survey_status);
				survey_status_text = '{{ trans('survey.radio_label_choice_survey_publish_status') }}';
			}



			var confirm_message = 'You choice save survey to ' + survey_status_text + '.<br/>Are you sure?';

			showConfirmBox('Confirmation', confirm_message, 'yes', 'no', "$('#survey_form').submit();");
        } else {
			showConfirmBox('Alert', 'Error on input');
        }

        return false;
	});

    function preview() {
        if (!validateOnSubmit()) {
			showConfirmBox('Alert', 'Error on input');
            return false;
        }

        var form_serialize_array = $('#survey_form').serializeArray(),
            form_data_length = form_serialize_array.length,
            data = {};

        for (var i = 0; i < form_data_length; i++) {
            var item = form_serialize_array[i];
            data[item.name] = item.value;
        }

        $.ajax({
            type: "POST",
            url : '/survey/editing/preview',
            data: data,
            success: function (data) {
                if (data.success) {
                    // open preview
                    openPreviewTab();
                } else {
                    alert(data.message);
                }
            }
        });
    }

    function openPreviewTab() {
        preview_tab = window.open('/survey/editing/preview', '_blank');
    }

    function closePreviewTab() {
        preview_tab.close();
    }

	function validateOnSubmit() {
        var survey_name = $('input[name=survey_name]')[0];
        if (!validateText(survey_name)) {
            $(survey_name).focus();
            return false;
        }

        var survey_thumbnail = $('input[name=survey_thumbnail]')[0];
        if (!validateFile(survey_thumbnail)) {
            $(survey_thumbnail).focus();
            return false;
        }

        var survey_description = $('textarea[name=survey_description]')[0];
        if (!validateText(survey_description)) {
            $('html, body').animate({
                scrollTop: $(survey_description).parent().offset().top
            }, 500);
            return false;
        }

        var question_valid = true;
        $('.jsQuestionBox').each(function () {
            var question_text = $(this).find('.jsQuestionText')[0];
            if (!validateText(question_text)) {
                $(question_text).focus();
                question_valid = false;
                return false;
            }

            var question_type = $($(this).find('.jsQuestionType')[0]).val();
            if (question_type == 3 || question_type == 4) {
                var question_choice_valid = true;
                $(this).find('.jsQuestionChoiceBox').each(function () {
                    var question_choice_text = $(this).find('.jsQuestionChoiceText')[0];
                    if (!validateText(question_choice_text)) {
                        $(question_choice_text).focus();
                        question_choice_valid = false;
                        question_valid = false;
                        return false;
                    }
                });

                return question_choice_valid;
            } else if (question_type == 5) {
                var question_confirmation_text = $(this).find('.jsQuestionConfirmationText')[0];
                if (!validateText(question_confirmation_text)) {
                    question_valid = false;
                    $('html, body').animate({
                        scrollTop: $(question_confirmation_text).parent().offset().top
                    }, 500);
                    return false;
                }

                var question_require = $($(this).find('.jsQuestionRequired')[0]).is(':checked');
                if (question_require) {
                    var question_agree_text = $(this).find('.jsQuestionConfirmationAgreeText')[0];
                    if (!validateText(question_agree_text)) {
                        $(question_agree_text).focus();
                        question_valid = false;
                        return false;
                    }
                }
            }
        });

        return question_valid;
	}
	
	function validateOnChange(target) {
        if ($(target).attr('type') == 'file') {
            return validateFile(target);
        }

        return validateText(target);
	}

	function validateText(target) {
        var content = $(target).val(),
            error = $(target).parent().children('.jsError');

        error.hide();

        if ($(target).hasClass('required')) {
            if (!content) {
                error.html('Not allow empty.');
                error.show();
                return false;
            }
        }

        if ($(target).hasClass('jsInputLimit255')) {
            if (content.length > 255) {
                error.html('Limit 255 characters.');
                error.show();
                return false;
            }
        }

        if ($(target).hasClass('jsInputLimit5000')) {
            if (content.length > 5000) {
                error.html('Limit 5000 characters.');
                error.show();
                return false;
            }
        }

        return true;
    }

	function validateFile(target) {
            var input_file = $(target)[0].files[0],
			error = $(target).parent().children('.jsError');

		error.hide();

		if (input_file) {
			if (input_file.size > 1024*1024*5) {
				error.html('Limit 5MB');
				error.show();
				return false;
			}

			if (input_file.type.split('/')[0] != 'image') {
				error.html('Only allow image file');
				error.show();
				return false;
			}
		}

		return true;
	}

    function previewImage(target) {
        var reader = new FileReader(),
            image = $(target)[0].files[0];

        reader.onload = function(e) {
            var image_data = e.target.result;
            $('.jsSurveyThumbnailPreview').attr('src', image_data);
            sessionStorage.preview_image = image_data;
        };

        reader.readAsDataURL(image);
        $('.jsSurveyThumbnailPreviewBox').show();
    }

    function showConfirmBox(title, content, btn_yes_text, btn_no_text, btn_yes_action) {
    	title = title || '';
    	content = content || '';
		btn_yes_text = btn_yes_text || '';
		btn_no_text = btn_no_text || '';
		btn_yes_action = btn_yes_action || '';

    	var modal = $('#modal-confirm-box');
		modal.find('.modal-title').html(title);
		modal.find('.modal-body').find('p').html(content);

		modal.find('.modal-footer').show();
		if (!btn_yes_text) {
			modal.find('#modal-confirm-box-btn-yes').hide();
		} else {
			if (!btn_yes_action) {
				modal.find('#modal-confirm-box-btn-yes').attr('onclick', '');
			} else {
				modal.find('#modal-confirm-box-btn-yes').attr('onclick', btn_yes_action);
			}

			modal.find('#modal-confirm-box-btn-yes').html(btn_yes_text);
			modal.find('#modal-confirm-box-btn-yes').show();
		}
		if (!btn_no_text) {
			modal.find('#modal-confirm-box-btn-no').hide();
		} else {
			modal.find('#modal-confirm-box-btn-no').html(btn_no_text);
			modal.find('#modal-confirm-box-btn-no').show();
		}
		if (!btn_yes_text && !btn_no_text) {
			modal.find('.modal-footer').hide();
		}

		modal.modal('show');
	}
</script>
