{{-- Survey Header Box --}}
<div class="row">
	<div class="col-md-8 col-md-offset-2">
		<div class="box">
			<div class="box-header with-border">
				<h3 class="box-title">{{ trans('survey.survey_header_box_title') }}</h3>

				<div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="">
						<i class="glyphicon glyphicon-minus"></i></button>
				</div>
			</div>
			<div class="box-body" style="padding-left: 30px; padding-right: 30px;">
				<div class="form-group row">
					<div class="col-md-3">
						<label for="survey_name">{{ trans('survey.survey_name_title') }}</label>
						<span class="jsValidate">{{ trans('survey.require_text') }}</span>
					</div>
					<div class="col-md-9">
						<input type="text"
							   name="survey_name"
							   id="survey_name"
							   value="{{ empty($survey['name']) ? '' : $survey['name'] }}"
							   class="form-control required jsInputLimit255">
						<p class="help-block">{{ trans('survey.survey_name_help_block') }}</p>
						<p class="jsError" style="color: red; display: none;"></p>
					</div>
				</div>
				<div class="form-group row">
					<div class="col-md-3">
						<label for="survey_thumbnail">{{ trans('survey.survey_thumbnail_title') }}</label>
					</div>
					<div class="col-md-9">
						<div class="jsSurveyThumbnailPreviewBox"
							 style="width: 100%; margin-bottom: 5px; position: relative;
							 @if(empty($survey['image_path'])) display: none; @endif">
							<img class="jsSurveyThumbnailPreview"
								 src="{{ empty($survey['image_path']) ? 'no-image' : $survey['image_path'] }}"
								 style="max-height: 200px; max-width: 200px;">
							<span data-toggle="tooltip"
								  data-original-title="削除"
								  class="jsRemoveSurveyThumbnail glyphicon glyphicon-remove"
								  style="position: absolute; top: 0; left: 205px;"></span>
						</div>
						<input type="file"
							   name="survey_thumbnail"
							   id="survey_thumbnail"
							   class="form-control">
						<p class="help-block">{!!  trans('survey.survey_thumbnail_help_block') !!}</p>
						<p class="jsError" style="color: red; display: none;"></p>
					</div>
				</div>
				<div class="form-group row">
					<div class="col-md-3">
						<label for="survey_description">{{ trans('survey.survey_description_title') }}</label>
					</div>
					<div class="col-md-9">
						<textarea id="survey_description"
								  name="survey_description"
								  class="form-control jsInputLimit5000">
							{{ empty($survey['description']) ? '' : $survey['description'] }}
						</textarea>
						<p class="help-block">{{ trans('survey.survey_description_help_block') }}</p>
						<p class="jsError" style="color: red; display: none;"></p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
