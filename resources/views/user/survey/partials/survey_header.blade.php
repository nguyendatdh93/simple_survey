@section('survey-header')
    <h1 class="headline1">{{ isset($survey['name']) ? $survey['name'] : "Survey must has name" }}</h1>
    <!-- ▼MV -->
    <p class="mainVisual">
       @if(isset($survey['image_path']) && $survey['image_path'] == route(\App\Survey::NAME_URL_SHOW_IMAGE).'/')
            {{ '' }}
       @else
            <img id="survey_thumbnail" src="{{ isset($survey['image_path']) ? $survey['image_path'] : "" }}" alt=" ">
       @endif
    </p>
    <!-- ▲MV-->

    @section('survey-description')
        <!-- ▼変更可能エリア※div（headFreeArea）は固定なので変更しないで下さい -->
        <div class="headFreeArea">{!! isset($survey['description']) ? $survey['description'] : "" !!}</div>
        <!-- ▲変更可能エリア 終わり -->
    @show

    @if(isset($survey['questions'][\App\Models\Question::CATEGORY_HEADER]))
        {!! \App\BaseWidget\Survey::formAnswerPattern($survey['questions'][\App\Models\Question::CATEGORY_HEADER]) !!}
    @endif
@show

@section('preview-script')
@show