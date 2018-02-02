@section("survey-content")
    <table class="formTable">
        @if(isset($survey['questions'][\App\Question::CATEGORY_CONTENT]))
            {!! \App\BaseWidget\Survey::formAnswerPattern($survey['questions'][\App\Question::CATEGORY_CONTENT]) !!}
        @endif
    </table>
@show