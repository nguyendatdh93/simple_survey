
@foreach($survey_contents as $survey_content)
    @if($survey_content['type'] == \App\Question::TYPE_SINGLE_TEXT)
        {!! \App\BaseWidget\Survey::singleText($survey_content, array('class' => 'exampleInputEmail1', 'placeholder' => 'Enter answer')) !!}
    @elseif($survey_content['type'] == \App\Question::TYPE_MULTI_TEXT)
        {!! \App\BaseWidget\Survey::multiText($survey_content, array("rows" => "3", "placeholder" => "Enter ...")) !!}
    @elseif($survey_content['type'] == \App\Question::TYPE_SINGLE_CHOICE)
        {!! \App\BaseWidget\Survey::singleChoice($survey_content, $survey_content['question_choices'], array("name" => "optradio")) !!}
    @elseif($survey_content['type'] == \App\Question::TYPE_MULTI_CHOICE)
        {!! \App\BaseWidget\Survey::multiChoice($survey_content, $survey_content['question_choices'], array("name" => "optcheckbox")) !!}
    @endif
@endforeach