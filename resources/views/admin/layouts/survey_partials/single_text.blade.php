<div class="row">
    <div class="col-md-4">
        <div class="col-md-10">
            <p>{{ $question['text'] }}</p>
        </div>
        <div class="col-md-2">
            @if(isset($question['require']) && $question['require'] == \App\Question::REQUIRE_QUESTION) <span style="color: red;font-size: 20px;font-weight: bold"> * </span> @endif
        </div>
    </div>
    <div class="col-md-8">
        <input type="text" class="form-control" {!!  \App\BaseWidget\Form::getAttributes($data_attributes) !!} >
    </div>
</div>