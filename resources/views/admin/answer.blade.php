@extends('admin::survey.form_survey')

@section('htmlheader_title')
    {{ trans('adminlte_lang::survey.htmlheader_title_answer_survey') }}
@endsection

@section('control')
    <script>
        function agreeCheck(){
            var elementForms = document.getElementById("form-answer-survey"),
                flg_continue = true;
            for (var i = 0; i < elementForms.elements.length; i++) {
                if (elementForms.elements[i].required) {
                    if (elementForms.elements[i].type == 'text') {
                        if (elementForms.elements[i].value == '') {
                            if (elementForms.elements[i].parentElement.querySelectorAll(".validate").length == 0) {
                                elChild = document.createElement('span');
                                elChild.className = "validate";
                                elChild.innerHTML = '{{ trans("adminlte_lang::survey.message_repquire") }}';
                                elementForms.elements[i].parentElement.appendChild(elChild);
                            }
                            flg_continue = false;
                        } else {
                            if (elementForms.elements[i].parentElement.querySelectorAll(".validate").length > 0) {
                                elementForms.elements[i].parentElement.querySelectorAll(".validate")[0].remove();
                            }
                        }
                    }

                    if (elementForms.elements[i].type == 'radio') {
                        var nameRadio = elementForms.elements[i].name;
                        if($("[name='"+nameRadio+"']:checked").length == 0) {
                            flg_continue = false;
                            if (elementForms.elements[i].parentElement.parentElement.querySelectorAll(".validate").length == 0) {
                                elChild = document.createElement('span');
                                elChild.className = "validate";
                                elChild.innerHTML = '{{ trans("adminlte_lang::survey.message_repquire") }}';
                                elementForms.elements[i].parentElement.parentElement.appendChild(elChild);
                            }
                        } else {
                            if (elementForms.elements[i].parentElement.parentElement.querySelectorAll(".validate").length > 0) {
                                elementForms.elements[i].parentElement.parentElement.querySelectorAll(".validate")[0].remove();
                            }
                        }
                    }

                    if (elementForms.elements[i].type == 'checkbox') {
                        var nameCheckbox = elementForms.elements[i].name;
                        if($('input[name="'+nameCheckbox+'"]:checked').length == 0) {
                            flg_continue = false;
                            if (elementForms.elements[i].parentElement.parentElement.querySelectorAll(".validate").length == 0) {
                                elChild = document.createElement('span');
                                elChild.className = "validate";
                                if (nameCheckbox == 'optcheckbox_confirm') {
                                    elChild.innerHTML = '{{ trans("adminlte_lang::survey.message_confirm_condition") }}';
                                } else {
                                    elChild.innerHTML = '{{ trans("adminlte_lang::survey.message_repquire") }}';
                                }

                                elementForms.elements[i].parentElement.parentElement.appendChild(elChild);
                            }
                        } else {
                            if (elementForms.elements[i].parentElement.parentElement.querySelectorAll(".validate").length > 0) {
                                elementForms.elements[i].parentElement.parentElement.querySelectorAll(".validate")[0].remove();
                            }
                        }
                    }

                    if (elementForms.elements[i].type == 'textarea') {
                        var nameCheckbox = elementForms.elements[i].name;
                        if(elementForms.elements[i].value == '') {
                            flg_continue = false;
                            if (elementForms.elements[i].parentElement.querySelectorAll(".validate").length == 0) {
                                elChild = document.createElement('span');
                                elChild.className = "validate";
                                elChild.innerHTML = '{{ trans("adminlte_lang::survey.message_repquire") }}';
                                elementForms.elements[i].parentElement.appendChild(elChild);
                            }
                        } else {
                            console.log(elementForms.elements[i].parentElement.querySelectorAll(".validate").length);
                            if (elementForms.elements[i].parentElement.querySelectorAll(".validate").length > 0) {
                                elementForms.elements[i].parentElement.querySelectorAll(".validate")[0].remove();
                            }
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
    </script>

    <div class="btnbox">
        <p class="btn1 AMRt20"><a href="javascript:;" onclick="agreeCheck();">確認する</a></p>
    </div>
@endsection