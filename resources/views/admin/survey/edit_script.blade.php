<script>
	$( document ).ready(function() {
	    var survey_status = {{ empty($survey['status']) ? \App\Survey::STATUS_SURVEY_DRAF : $survey['status'] }};
        if (survey_status == {{ \App\Survey::STATUS_SURVEY_PUBLISHED }}) {
            $('input').attr('disabled', 'disabled');
            $('select').attr('disabled', 'disabled');
            $('button.jsAddQuestion').attr('disabled', 'disabled');
            $('textarea').attr('disabled', 'disabled');
        }

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

        var current_url = window.location.href,
                pattern = /duplicate/,
                is_duplicate_page = pattern.test(current_url),
                is_edit_page = {{ empty($survey['id']) ? 'false' : 'true' }};
        if (!is_edit_page && !is_duplicate_page) {
            $('.jsAddQuestion').click();
        }

        sessionStorage.preview_image = $('.jsSurveyThumbnailPreview').attr('src');

        var preview_tab;
	});

	$(document).on('click', '.jsRemoveChoice',function(){
	    var choices = $(this).parent().parent().parent().parent();
        if(choices.find('.jsQuestionChoiceBox').length == 1) {
            var error_html = '<p class="jsError jsErrorNoChoice" style="color: red;">' + '{{ trans('survey.error_no_choice') }}' + '</p>';
            $(error_html).insertAfter(choices);
        }

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

        question.parent().find('.jsErrorNoChoice').remove();
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

    $(document).on('click', '.jsSaveSurvey', function () {
        if (validateOnSubmit()) {
            var survey_status = $(this).data('status'),
                survey_form = $('#survey_form'),
                input = $("<input>").attr("type", "hidden").attr("name", 'survey_status').val(survey_status);

            survey_form.append($(input));
            if (survey_status == '{{ \App\Survey::STATUS_SURVEY_DRAF }}') {
                survey_form.submit();
            } else if (survey_status == {{ \App\Survey::STATUS_SURVEY_PUBLISHED }}) {
                showConfirmBox('', '{{ trans('survey.confirm_publish_survey_content') }}', '{{ trans('survey.save_publish_survey') }}', '{{ trans('survey.cancel_publish_survey') }}', "$('#survey_form').submit();");
            }
        } else {
            showConfirmBox('', '{{ trans('survey.error_input_wrong_create_survey') }}');
        }
    });

    $(document).on('click', '.jsCloseSurvey', function () {
        showConfirmBox(
                '',
                '{{ trans('survey.confirm_close_survey_content') }}',
                '{{ trans('survey.confirm_button_close') }}',
                '{{ trans('survey.cancel_publish_survey') }}',
                'window.open("{{ route(\App\Survey::NAME_URL_CLOSE_SURVEY,['id' => empty($survey['id']) ? '' : $survey['id']]) }}", "_self");'
        );
    });

    function preview(preview_url) {
        preview_url = preview_url || '';

        if (preview_url) {
            preview_tab = window.open(preview_url, '_blank');
            return false;
        }

        if (!validateOnSubmit()) {
			showConfirmBox('', '{{ trans('adminlte_lang::survey.error_input_wrong_create_survey') }}');
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
                if($(this).find('.jsQuestionChoiceBox').length == 0) {
                    question_valid = false;
                    var question_box_body = $(this).find('.box-body')[0];
                    $('html, body').animate({
                        scrollTop: $(question_box_body).offset().top
                    }, 500);
                    return false;
                }

                $(this).find('.jsQuestionChoiceBox').each(function () {
                    var question_choice_text = $(this).find('.jsQuestionChoiceText')[0];
                    if (!validateText(question_choice_text)) {
                        $(question_choice_text).focus();
                        question_valid = false;
                        return false;
                    }
                });
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
                error.html('{{ trans('adminlte_lang::survey.error_not_allow_empty') }}');
                error.show();
                return false;
            }
        }

        if ($(target).hasClass('jsInputLimit255')) {
            if (content.length > 255) {
                error.html('{{ trans('adminlte_lang::survey.error_length_255_characters') }}');
                error.show();
                return false;
            }
        }

        if ($(target).hasClass('jsInputLimit5000')) {
            if (content.length > 5000) {
                error.html('{{ trans('adminlte_lang::survey.error_length_5000_characters') }}');
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
				error.html('{{ trans('adminlte_lang::survey.error_limit_5mb') }}');
				error.show();
				return false;
			}

			if (input_file.type.split('/')[0] != 'image') {
				error.html('{{ trans('adminlte_lang::survey.error_only_allow_file') }}');
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

    function copyClipbroad() {
        var urlCopy = $('.jsUrlDomainCopy').html() +'/'+ $('.jsUrlEncrypt').val();
        copyToClipboard(urlCopy);
    }

    function copyToClipboard(text) {
        if (window.clipboardData && window.clipboardData.setData) {
            // IE specific code path to prevent textarea being shown while dialog is visible.
            return clipboardData.setData("Text", text);

        } else if (document.queryCommandSupported && document.queryCommandSupported("copy")) {
            var textarea = document.createElement("textarea");
            textarea.textContent = text;
            textarea.style.position = "fixed";  // Prevent scrolling to bottom of page in MS Edge.
            document.body.appendChild(textarea);
            textarea.select();
            try {
                return document.execCommand("copy");  // Security exception may be thrown by some browsers.
            } catch (ex) {
                console.warn("Copy to clipboard failed.", ex);
                return false;
            } finally {
                document.body.removeChild(textarea);
            }
        }
    }
</script>
