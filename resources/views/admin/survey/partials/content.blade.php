@section("content")
    <div class="formArea">
        <form method="POST" action="{{ route(\App\Survey::NAME_URL_ANSWER_CONFIRM, ['encrypt' => isset($survey['encrypt_url']) ? $survey['encrypt_url'] : ""]) }}" name="form_answer_survey" id="form-answer-survey" enctype="multipart/form-data">
            <!-- ▼変更可能エリア※table（formTable）は固定なので変更しないでください -->
            {{ csrf_field() }}

            @include('admin::survey.partials.survey_content')
            @include('admin::survey.partials.survey_confirm')
            @include('admin::survey.partials.button_control')

        </form>
    <!-- /.formArea --></div>
@show