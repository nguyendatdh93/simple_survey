@section("form-content")
    <div class="formArea">
        <form method="POST" action="{{ route(\App\Survey::NAME_URL_ANSWER_CONFIRM, ['encrypt' => isset($survey['encrypt_url']) ? $survey['encrypt_url'] : ""]) }}" name="form_answer_survey" id="form-answer-survey" enctype="multipart/form-data">
            <!-- ▼変更可能エリア※table（formTable）は固定なので変更しないでください -->
            {{ csrf_field() }}
            <table class="formTable">
                @if(isset($survey['questions'][\App\Question::CATEGORY_CONTENT]))
                    {!! \App\BaseWidget\Survey::formAnswerPattern($survey['questions'][\App\Question::CATEGORY_CONTENT]) !!}
                @endif
            </table>
            <!-- ▲変更可能エリア 終わり -->

            @include('admin::survey.partials.form_footer')
            @include('admin::survey.partials.button_control')

        </form>
        <!-- /.formArea --></div>
@show