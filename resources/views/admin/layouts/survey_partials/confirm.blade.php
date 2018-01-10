<div class="row">
    <div class="col-md-12">
        <h1>{{ $question['text'] }}</h1>
        @if(is_array($confirms))
            @foreach($confirms as $confirm)
                <p>{!! $confirm['text'] !!} </p>
            @endforeach
        @endif
        @if(isset($question['require']) && $question['require'] == \App\Question::REQUIRE_QUESTION)
            @if(is_array($choices))
                @foreach($choices as $choice)
                    <div class="checkbox">
                        <label><input type="checkbox" {!!  \App\BaseWidget\Form::getAttributes($data_attributes) !!}>{{ $choice['text'] }}</label>
                    </div>
                @endforeach
            @endif
        @endif
    </div>
</div>