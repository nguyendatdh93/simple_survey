<div class="row">
    <div class="col-md-4">
        <p>{{ $question_text }}</p>
    </div>
    <div class="col-md-8">
        @if(is_array($choices))
            @foreach($choices as $choice)
                <div class="checkbox">
                    <label><input type="checkbox" {!!  \App\BaseWidget\Form::getAttributes($data_attributes) !!}>{{ $choice['text'] }}</label>
                </div>
            @endforeach
        @endif
    </div>
</div>