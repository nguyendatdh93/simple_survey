@foreach($survey_contents as $survey_content)
    @if(isset($survey_content['type']))
        @if($survey_content['type'] == \App\Question::TYPE_SINGLE_TEXT)
            @if( isset($survey_content['answer']))
                @php $value = $survey_content['answer']; @endphp
            @endif
            {!! \App\BaseWidget\Survey::singleText($survey_content, array("name" => "num", "value" => (isset($value) ? $value : ""), "class" => "ipt01","maxlength" => "")) !!}
        @elseif($survey_content['type'] == \App\Question::TYPE_MULTI_TEXT)
            {!! \App\BaseWidget\Survey::multiText($survey_content, array("id" => "comment", "class" => "txt01","value" => (isset($value) ? $value : "") , "name" => "comment", "maxlength" => "", "placeholder" => "")) !!}
        @elseif($survey_content['type'] == \App\Question::TYPE_SINGLE_CHOICE)
            {!! \App\BaseWidget\Survey::singleChoice($survey_content, $survey_content['question_choices'], array("name" => "optradio")) !!}
        @elseif($survey_content['type'] == \App\Question::TYPE_MULTI_CHOICE)
            {!! \App\BaseWidget\Survey::multiChoice($survey_content, $survey_content['question_choices'], array("name" => "optcheckbox[]")) !!}
        @else
            {!! \App\BaseWidget\Survey::termConfirm($survey_content, $survey_content['confirm_contents'],  empty($survey_content['question_choices']) ? [] : $survey_content['question_choices'], array("name" => "optcheckbox_confirm")) !!}
        @endif
    @endif
@endforeach