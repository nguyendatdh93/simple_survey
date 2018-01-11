<h1 class="headline1">{{ isset($survey['name']) ? $survey['name'] : "Survey must has name" }}</h1>
<!-- ▼MV -->
<p class="mainVisual"><img src="{{ isset($survey['image_path']) ? $survey['image_path'] : "" }}" alt="mainVisual"></p>
<!-- ▲MV-->

<!-- ▼変更可能エリア※div（headFreeArea）は固定なので変更しないで下さい -->
<div class="headFreeArea">{!! isset($survey['description']) ? $survey['description'] : "" !!}</div>
<!-- ▲変更可能エリア 終わり -->

@if(isset($survey['questions'][\App\Question::CATEGORY_HEADER]))
    {!! \App\BaseWidget\Survey::formAnswerPattern($survey['questions'][\App\Question::CATEGORY_HEADER]) !!}
@endif