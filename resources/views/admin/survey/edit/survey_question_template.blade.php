{{-- Survey Question Template --}}
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
						<textarea id="confirmation" class="form-control jsQuestionConfirmationText required" rows="10"></textarea>
						<p class="help-block">{{ trans('survey.confirmation_help_block') }}</p>
						<p class="jsError" style="color: red; display: none;"></p>
					</div>
					<div class="col-md-12 jsQuestionConfirmationAgreeBox" style="margin-bottom: 5px;">
						<div class="col-md-1">
							<i class="glyphicon glyphicon-unchecked" style="font-size: x-large; line-height: 36px;"></i>
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
								<i class="glyphicon glyphicon-unchecked" style="font-size: x-large; line-height: 36px;"></i>
							</div>
							<div class="col-md-1 jsQuestionChoice jsQuestionSingleChoice" style="display: none;">
								<i class="fa fa-circle-o" style="font-size: x-large; line-height: 36px;"></i>
							</div>
							<div class="col-md-10">
								<input type="text" class="form-control jsQuestionChoiceText required jsInputLimit255">
								<p class="jsError" style="color: red; display: none;"></p>
							</div>
							<div class="col-md-1">
								<i class="glyphicon glyphicon-minus-sign jsRemoveChoice" data-widget="remove" data-toggle="tooltip" title="{{ trans('survey.tooltip_remove_question_choice') }}" style="font-size: large; line-height: 36px; color:red;"></i>
							</div>
						</div>

						<div class="row jsQuestionChoiceBox" data-choice-number="1"  style="margin-bottom: 5px;">
							<div class="col-md-1 jsQuestionChoice jsQuestionMultiSelect" style="display: none;">
								<i class="glyphicon glyphicon-unchecked" style="font-size: x-large; line-height: 36px;"></i>
							</div>
							<div class="col-md-1 jsQuestionChoice jsQuestionSingleChoice" style="display: none;">
								<i class="fa fa-circle-o" style="font-size: x-large; line-height: 36px;"></i>
							</div>
							<div class="col-md-10">
								<input type="text" class="form-control jsQuestionChoiceText required jsInputLimit255" placeholder="{{ trans('survey.choice_default_text') }} 1">
								<p class="jsError" style="color: red; display: none;"></p>
							</div>
							<div class="col-md-1">
								<i class="glyphicon glyphicon-minus-sign jsRemoveChoice" data-widget="remove" data-toggle="tooltip" title="{{ trans('survey.tooltip_remove_question_choice') }}" style="font-size: large; line-height: 36px; color:red;"></i>
							</div>
						</div>

						<div class="row jsQuestionChoiceBox" data-choice-number="2" style="margin-bottom: 5px;">
							<div class="col-md-1 jsQuestionChoice jsQuestionMultiSelect" style="display: none;">
								<i class="glyphicon glyphicon-unchecked" style="font-size: x-large; line-height: 36px;"></i>
							</div>
							<div class="col-md-1 jsQuestionChoice jsQuestionSingleChoice" style="display: none;">
								<i class="fa fa-circle-o" style="font-size: x-large; line-height: 36px;"></i>
							</div>
							<div class="col-md-10">
								<input type="text" class="form-control jsQuestionChoiceText required jsInputLimit255" placeholder="{{ trans('survey.choice_default_text') }} 2">
								<p class="jsError" style="color: red; display: none;"></p>
							</div>
							<div class="col-md-1">
								<i class="glyphicon glyphicon-minus-sign jsRemoveChoice" data-widget="remove" data-toggle="tooltip" title="{{ trans('survey.tooltip_remove_question_choice') }}" style="font-size: large; line-height: 36px; color:red;"></i>
							</div>
						</div>

						<div class="row">
							<div class="col-md-10 col-md-offset-1">
								<i class="glyphicon glyphicon-plus jsAddChoice" data-widget="add" data-toggle="tooltip" title="{{ trans('survey.tooltip_add_question_choice') }}" style="font-size: x-large; line-height: 36px; color:green;"></i>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="box-footer" style="padding: 5px;">
				<div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool jsDuplicateQuestion" style="padding: 0px; margin: 0 5px; display: none;">
						<i class="glyphicon glyphicon-duplicate" style="font-size: x-large;"></i></button>
					<button type="button" data-widget="remove" data-toggle="tooltip" title="{{ trans('survey.tooltip_remove_question') }}" class="btn btn-box-tool jsRemoveQuestion" style="padding: 0px; margin: 0 5px;">
						<i class="glyphicon glyphicon-trash" style="font-size: x-large;"></i></button>
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
