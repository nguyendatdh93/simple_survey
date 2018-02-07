{{-- Survey Header Box --}}
<div class="row">
	<div class="col-md-8 col-md-offset-2">
		<div class="box">
			<div class="box-header with-border">
				<h3 class="box-title">{{ trans('survey.survey_note_box_title') }}</h3>

				<div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
						<i class="glyphicon glyphicon-minus"></i></button>
				</div>
			</div>
			<div class="box-body" style="padding-left: 30px; padding-right: 30px;">
				<div class="form-group row">
					<div class="col-md-3">
						<label for="survey_name">{{ trans('survey.survey_note_title') }}</label>
					</div>
					<div class="col-md-9">
						<input type="text"
							   name="survey_note"
							   id="survey_note"
							   value="{{ empty($survey['note']) ? '' : $survey['note'] }}"
							   class="form-control jsInputLimit255">
						<p class="help-block">{{ trans('survey.survey_note_help_block') }}</p>
						<p class="jsError" style="color: red; display: none;"></p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
