@section('form-header')
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

    <!-- ▼変更可能エリア※div（headFreeArea）は固定なので変更しないで下さい -->
    <div class="headFreeArea">{!! isset($survey['description']) ? $survey['description'] : "" !!}</div>
    <!-- ▲変更可能エリア 終わり -->

    @if(isset($survey['questions'][\App\Question::CATEGORY_HEADER]))
        {!! \App\BaseWidget\Survey::formAnswerPattern($survey['questions'][\App\Question::CATEGORY_HEADER]) !!}
    @endif
@show

<script>
    var current_url = window.location.href,
        pattern = /editing\/preview/;

    if (pattern.test(current_url)) {
        var image_data = sessionStorage.preview_image;
        if (image_data == 'no-image') {
            $('#survey_thumbnail').remove();
        } else {
            $('#survey_thumbnail').attr('src', image_data);
        }
    }
</script>