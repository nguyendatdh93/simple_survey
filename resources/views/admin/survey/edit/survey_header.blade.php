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
