@extends('admin::layouts.base')

@section('htmlheader_title')
	{{ trans('create survey') }}
@endsection

<style>
	/* The switch - the box around the slider */
	.switch {
		position: relative;
		display: inline-block;
		width: 50px;
		height: 20px;
	}

	/* Hide default HTML checkbox */
	.switch input {display:none;}

	/* The slider */
	.slider {
		position: absolute;
		cursor: pointer;
		top: 0;
		left: 0;
		right: 0;
		bottom: 0;
		background-color: #ccc;
		-webkit-transition: .4s;
		transition: .4s;
	}

	.slider:before {
		position: absolute;
		content: "";
		height: 16px;
		width: 16px;
		left: 2px;
		bottom: 2px;
		background-color: white;
		-webkit-transition: .4s;
		transition: .4s;
	}

	input:checked + .slider {
		background-color: #2196F3;
	}

	input:focus + .slider {
		box-shadow: 0 0 1px #2196F3;
	}

	input:checked + .slider:before {
		-webkit-transform: translateX(30px);
		-ms-transform: translateX(30px);
		transform: translateX(30px);
	}

	/* Rounded sliders */
	.slider.round {
		border-radius: 13px;
	}

	.slider.round:before {
		border-radius: 50%;
	}
</style>

@section('main-content-form')
	<div class="container-fluid spark-screen">
<form method="post" action="/survey/save" enctype="multipart/form-data" id="survey_form">
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
							{!! FormSimple::textarea(['name' => 'survey_description', 'id'=>'survey_description', 'class'=> 'form-control', 'help-block' => '* You can list the description of the survey. (Up to 5,000 characters)']) !!}
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="row jsQuestionTemplate" style="display: none;">
			<div class="col-md-10 col-md-offset-1">
				<div class="panel panel-default" style="margin-bottom: 0;">
					<div class="box-header"></div>

					<div class="box-body" style="padding-left: 40px; padding-right: 20px; ">
						<div class="form-group row">
							<div class="col-md-9">
								<input type="hidden" class="jsQuestionCategory">
								<input type="text" class="form-control jsQuestionText" placeholder="Question">
								<p class="help-block">* Explain more about this.</p>
							</div>
							<div class="col-md-3">
								<select class="form-control jsChoiceQuestionType jsQuestionType">
									<option value="1" data-type="simple_text">Simple Text</option>
									<option value="2" data-type="long_answer">Long Answer</option>
									<option value="3" data-type="single_choice">Single Choice</option>
									<option value="4" data-type="multi_select">Multi Select</option>
									<option value="5" data-type="confirmation">Confirmation</option>
								</select>
							</div>
						</div>

						<div class="form-group jsQuestion jsQuestionSimpleText row">
							<div class="col-md-10">
								<input type="text" class="form-control" placeholder="Short answer text" disabled="disabled">
							</div>
						</div>

						<div class="form-group jsQuestion jsQuestionLongAnswer row" style="display: none;">
							<div class="col-md-10">
								<textarea id="long_answer" class="form-control" rows="4" disabled="disabled" placeholder="Long answer text">Long answer text</textarea>
							</div>
						</div>

						<div class="form-group jsQuestion jsQuestionConfirmation row" style="display: none;">
							<div class="col-md-12">
								<textarea id="confirmation" class="form-control jsQuestionConfirmationText" rows="10"></textarea>
								<p class="help-block">* The condition text for explain more about this question.</p>
							</div>
							<div class="col-md-12 jsQuestionConfirmationAgreeBox" style="margin-bottom: 5px; display: none;">
								<div class="col-md-1">
									<i class="fa fa-square-o" style="font-size: x-large; line-height: 36px;"></i>
								</div>
								<div class="col-md-10">
									<input type="text" class="form-control jsQuestionConfirmationAgreeText" placeholder="Agree text">
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
										<input type="text" class="form-control jsQuestionChoiceText">
									</div>
									<div class="col-md-1">
										<i class="fa fa-minus-circle jsRemoveChoice" style="font-size: large; line-height: 36px; color:red;"></i>
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
										<input type="text" class="form-control jsQuestionChoiceText" placeholder="Option 1">
									</div>
									<div class="col-md-1">
										<i class="fa fa-minus-circle jsRemoveChoice" style="font-size: large; line-height: 36px; color:red;"></i>
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
										<input type="text" class="form-control jsQuestionChoiceText" placeholder="Option 2">
									</div>
									<div class="col-md-1">
										<i class="fa fa-minus-circle jsRemoveChoice" style="font-size: large; line-height: 36px; color:red;"></i>
									</div>
								</div>

								<div class="row">
									<div class="col-md-10 col-md-offset-1">
										<i class="fa fa-plus-square jsAddChoice" style="font-size: x-large; line-height: 36px; color:green;"></i>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="box-footer" style="padding: 5px;">
						<div class="box-tools pull-right">
							<button type="button" class="btn btn-box-tool jsDuplicateQuestion" style="padding: 0px; margin: 0 5px; display: none;">
								<i class="fa fa-clone" style="font-size: x-large;"></i></button>
							<button type="button" class="btn btn-box-tool jsRemoveQuestion" style="padding: 0px; margin: 0 5px;">
								<i class="fa fa-trash-o" style="font-size: x-large;"></i></button>
							<span class="btn btn-box-tool" style="padding: 0px; margin: 0 20px; font-size: x-large;">|</span>
							<span style="margin: 0 5px; vertical-align: middle; font-size: large;">Required</span>
							<label class="switch" style="margin: 0; vertical-align: middle;">
								<input type="checkbox" class="jsQuestionRequired" value="1">
								<span class="slider round"></span>
							</label>
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
						<div>
							<div class="row">
								<div class="col-md-10 col-md-offset-1" style="margin-top: 10px; margin-bottom: 10px;">
									<div class="pull-right">
										<button type="button" class="btn btn-success btn-sm jsAddQuestion" data-question-category="2">
											<i class="fa fa-plus"></i> Add Question
										</button>
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
						<div>
							<div class="row">
								<div class="col-md-10 col-md-offset-1" style="margin-top: 10px; margin-bottom: 10px;">
									<div class="pull-right">
										<button type="button" class="btn btn-success btn-sm jsAddQuestion" data-question-category="3">
											<i class="fa fa-plus"></i> Add Question
										</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

{!! FormSimple::button('Submit', ['type' => 'submit', 'class' => 'btn btn-primary', 'icon' => 'fa fa-plus', "style" => "display: block; margin:0px auto"]) !!}
</form>
	</div>
@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script>
	$( document ).ready(function() {
		CKEDITOR.replace('survey_description');
	});

	$(document).on('click','.jsRemoveChoice',function(){
		$(this).parent().parent().remove();
	});

	$(document).on('click', '.jsRemoveQuestion', function () {
		$(this).parent().parent().parent().parent().parent().parent().remove();
	});

	$(document).on('change', '.jsChoiceQuestionType', function () {
		var question_type = $(this).find(":selected").data('type'),
			question_box = $(this).parent().parent().parent();

		question_box.children('.jsQuestion').hide();

		if (question_type == 'simple_text') {
			question_box.children(".jsQuestionSimpleText").show();
		} else if (question_type == 'long_answer') {
			question_box.children(".jsQuestionLongAnswer").show();
		} else if (question_type == 'single_choice' || question_type == 'multi_select') {
			var question_choices = question_box.children(".jsQuestionChoices");
			question_choices.show();

			if (question_type == 'single_choice') {
				question_choices.find('.jsQuestionChoice').hide();
				question_choices.find('.jsQuestionSingleChoice').show();
			} else if (question_type == 'multi_select') {
				question_choices.find('.jsQuestionChoice').hide();
				question_choices.find('.jsQuestionMultiSelect').show();
			}
		} else if (question_type == 'confirmation') {
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
				.attr('placeholder', 'Option ' + max_choice_number);
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
			$(this).find('.jsQuestionChoiceText').attr('name', 'question_' + max_number + '_choice_' + question_choice_number + "_text");
        });
	});
	
	$(document).on('click', '.jsQuestionRequired', function () {
		var agree_box = $(this).parent().parent().parent().parent().find('.jsQuestionConfirmationAgreeBox');

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

    $(document).on('submit', '#survey_form',function(event) {
        $.ajax({
            url: '/survey/save',
            type: 'POST',
            dataType: 'json',
            data: $('#survey_form').serialize(),
            success: function( data ) {
                for(var id in data) {
                    jQuery('#' + id).html(data[id]);
                }
            }
        });
        return false;
    });
</script>
