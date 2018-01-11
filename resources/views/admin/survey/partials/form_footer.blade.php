@if(isset($survey['questions'][\App\Question::CATEGORY_FOOTER]))
    {!! \App\BaseWidget\Survey::formAnswerPattern($survey['questions'][\App\Question::CATEGORY_FOOTER]) !!}
@endif