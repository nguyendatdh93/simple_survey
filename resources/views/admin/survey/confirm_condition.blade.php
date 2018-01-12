<p class="btnRule1"><a href="#" id="js-toggleRule1">{{ $question['text'] }}</a></p>
<!-- ▼変更可能エリア※div（hruleArea1）は固定なので変更しないでください -->
<div class="ruleArea1" id="js-ruleArea1">
    @if(is_array($confirms))
        @foreach($confirms as $confirm)
            <p>{!! $confirm['text'] !!} </p>
    @endforeach
@endif
<!-- /.secCaution1 --></div>
<!-- ▲変更可能エリア 終わり -->
@if(isset($question['require']) && $question['require'] == \App\Question::REQUIRE_QUESTION_YES)
    @if(is_array($choices))
        @foreach($choices as $choice)
            <p class="txtCheck1"><label><input type="checkbox" class="confirm_checkbox" required {!!  \App\BaseWidget\Form::getAttributes($data_attributes) !!}> {{ $choice['text'] }}</label></p>
        @endforeach
    @endif
@endif