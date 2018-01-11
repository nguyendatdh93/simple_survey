@section("form-content")
    <div class="formArea">
        <form method="GET" action="{{ route(\App\Survey::NAME_URL_ANSWER_CONFIRM, ['encrypt' => isset($survey['encrypt_url']) ? $survey['encrypt_url'] : ""]) }}" name="join_form">

            <input type="hidden" name="csrf_token" value="77d4ca95eee58cf58b3d5aec8eb0b73a423999ed">

            <!-- ▼変更可能エリア※table（formTable）は固定なので変更しないでください -->
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