@extends('admin::survey.form_survey')

@section('control')
    <script>
        function agreeCheck(){
//            var elementForms = document.getElementById("form-answer-survey");
//            for (var i = 0; i < elementForms.elements.length; i++) {
//                if (elementForms.elements[i].required) {
//                    if (elementForms.elements[i].value == '') {
//                        elChild = document.createElement('span');
//                        elChild.className = "validate";
//                        elChild.innerHTML = '必須';
//                        elementForms.elements[i].after(elChild);
//                    }
//                }
//            }
                document.form_answer_survey.submit();
        }
    </script>
    <div class="btnbox">
        <p class="btn1 AMRt20"><a href="javascript:;" onclick="return agreeCheck();">確認する</a></p>
    </div>
@endsection