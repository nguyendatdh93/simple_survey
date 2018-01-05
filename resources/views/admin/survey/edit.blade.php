@extends('admin::layouts.base')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.home') }}
@endsection

@section('contentheader_title')
	{{ 'Create / Edit' }}
@endsection

@section('contentheader_description')
	{{ 'survey' }}
@endsection

@section('main-content-form')
	<div class="container-fluid spark-screen">
<form method="post" action="/survey/save" enctype="multipart/form-data">
{{ csrf_field() }}
		{{-- Survey Header Box --}}
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="box">
					<div class="box-header with-border">
						<h3 class="box-title">Survey Header</h3>

						<div class="box-tools pull-right">
							<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
								<i class="fa fa-minus"></i></button>
						</div>
					</div>
					<div class="box-body">
						<div class="form-group">
							{!! FormSimple::label('Survey Name', ['for' => 'survey_name', 'class' => 'required']) !!}
							{!! FormSimple::input(['type' => 'text', 'name' => 'survey_name', 'id' => 'survey_name', 'class' => 'form-control required', 'help-block' => '* You can write survey name. (Up to 255 characters)']) !!}
						</div>
						<div class="form-group">
							{!! FormSimple::label('Image Header', ['for'=> 'survey_thumbnail']) !!}
							{!! FormSimple::input(['type' => 'file', 'name' => 'survey_thumbnail', 'id' => 'survey_thumbnail', 'class' => 'form-control', 'help-block' => '* Please specify the upload file. Uploading is possible up to 5MB in size.']) !!}
						</div>
						<div class="form-group">
							{!! FormSimple::label('Description', ['for'=> 'survey_description']) !!}
							{!! FormSimple::textarea(['name' => 'survey_description', 'id'=>'ckeditor_survey_description', 'class'=> 'form-control', 'help-block' => '* You can list the description of the survey. (Up to 5,000 characters)']) !!}
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
						<h3 class="box-title">Survey Content</h3>

						<div class="box-tools pull-right">
							<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
								<i class="fa fa-minus"></i></button>
						</div>
					</div>

					<div class="box-body">
						<div class="row">
							<div class="col-md-10 col-md-offset-1">
								<div class="box box-solid">
									<div class="form-group">
										{!! FormSimple::label('Description', ['for'=> 'survey_description']) !!}
										{!! FormSimple::textarea(['name' => 'survey_description', 'id'=>'ckeditor_survey_description', 'class'=> 'form-control', 'help-block' => '* You can list the description of the survey. (Up to 5,000 characters)']) !!}
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		{{-- Survey Footer Box --}}
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="box">
					<div class="box-header with-border">
						<h3 class="box-title">Survey Footer</h3>

						<div class="box-tools pull-right">
							<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
								<i class="fa fa-minus"></i></button>
						</div>
					</div>
					<div class="box-body">

					</div>
				</div>
			</div>
		</div>

{!! FormSimple::button('Submit', ['type' => 'submit', 'class' => 'btn btn-primary', 'icon' => 'fa fa-plus', "style" => "display: block; margin:0px auto"]) !!}
</form>
	</div>
@endsection
