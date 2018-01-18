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
