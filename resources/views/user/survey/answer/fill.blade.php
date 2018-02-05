@extends('user::layouts.survey')

@section('htmlheader_title')
    {{ trans('survey.htmlheader_title_answer_survey') }}
@endsection

@section('control')
    <script>
        function agreeCheck(){
            var elementForms = document.getElementById("form-answer-survey"),
                flg_continue = true;
            for (var i = 0; i < elementForms.elements.length; i++) {
                if (elementForms.elements[i].type == 'text') {
                    if (elementForms.elements[i].value.length > 255)
                    {
                        removeErrorForAnswerText(elementForms.elements[i]);
                        addErrorForAnswerText(elementForms.elements[i], '{{ trans("adminlte_lang::survey.message_255_characters") }}');
                        elementForms.elements[i].focus();
                        flg_continue = false;
                    } else if(elementForms.elements[i].required) {
                        if (elementForms.elements[i].value == '') {
                            removeErrorForAnswerText(elementForms.elements[i]);
                            addErrorForAnswerText(elementForms.elements[i], '{{ trans("adminlte_lang::survey.message_repquire") }}');
                            elementForms.elements[i].focus();
                            flg_continue = false;
                        } else {
                            removeErrorForAnswerText(elementForms.elements[i]);
                        }
                    } else {
                        removeErrorForAnswerText(elementForms.elements[i]);
                    }
                } else if (elementForms.elements[i].type == 'textarea') {
                    if (elementForms.elements[i].value.length > 5000)
                    {
                        removeErrorForAnswerText(elementForms.elements[i]);
                        addErrorForAnswerText(elementForms.elements[i], '{{ trans("adminlte_lang::survey.message_5000_characters") }}');
                        elementForms.elements[i].focus();
                        flg_continue = false;
                    } else if(elementForms.elements[i].required) {
                        if (elementForms.elements[i].value == '') {
                            removeErrorForAnswerText(elementForms.elements[i]);
                            addErrorForAnswerText(elementForms.elements[i], '{{ trans("adminlte_lang::survey.message_repquire") }}');
                            elementForms.elements[i].focus();
                            flg_continue = false;
                        } else {
                            removeErrorForAnswerText(elementForms.elements[i]);
                        }
                    } else {
                        removeErrorForAnswerText(elementForms.elements[i]);
                    }
                }

                if (elementForms.elements[i].required) {
                    if (elementForms.elements[i].type == 'radio') {
                        var nameRadio = elementForms.elements[i].name;
                        if($("[name='"+nameRadio+"']:checked").length == 0) {
                            flg_continue = false;
                            removeErrorForAnswerChoice(elementForms.elements[i]);
                            addErrorForAnswerChoice(elementForms.elements[i],'{{ trans("adminlte_lang::survey.message_repquire") }}');
                            elementForms.elements[i].focus();
                        } else {
                            removeErrorForAnswerChoice(elementForms.elements[i]);
                        }
                    }

                    if (elementForms.elements[i].type == 'checkbox') {
                        var nameCheckbox = elementForms.elements[i].name;
                        if($('input[name="'+nameCheckbox+'"]:checked').length == 0) {
                            flg_continue = false;
                            removeErrorForAnswerChoice(elementForms.elements[i]);
                            if (nameCheckbox == 'optcheckbox_confirm') {
                                addErrorForAnswerChoice(elementForms.elements[i],'{{ trans("adminlte_lang::survey.message_confirm_condition") }}');
                                elementForms.elements[i].focus();
                            } else {
                                addErrorForAnswerChoice(elementForms.elements[i],'{{ trans("adminlte_lang::survey.message_repquire") }}');
                                elementForms.elements[i].focus();
                            }
                        } else {
                            removeErrorForAnswerChoice(elementForms.elements[i]);
                        }
                    }
                }
            }

            if (flg_continue == true) {
                document.form_answer_survey.submit();
            } else {
                return;
            }
        }

        function removeErrorForAnswerText(element)
        {
            if (element.parentElement.querySelectorAll(".validate").length > 0) {
                element.parentElement.querySelectorAll(".validate")[0].remove();
            }
        }

        function removeErrorForAnswerChoice(element)
        {
            if (element.parentElement.parentElement.querySelectorAll(".validate").length > 0) {
                element.parentElement.parentElement.querySelectorAll(".validate")[0].remove();
            }
        }

        function addErrorForAnswerChoice(element, error)
        {
            elChild = document.createElement('p');
            elChild.className = "validate";
            elChild.innerHTML = error;
            element.parentElement.parentElement.appendChild(elChild);
        }

        function addErrorForAnswerText(element, error)
        {
            elChild = document.createElement('span');
            elChild.className = "validate";
            elChild.innerHTML = error;
            element.parentElement.appendChild(elChild);
        }
    </script>

    <div class="btnbox">
        <p class="btn1 AMRt20"><a href="javascript:;" onclick="agreeCheck();">確認する</a></p>
    </div>
@endsection