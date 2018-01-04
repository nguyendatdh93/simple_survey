<div class="row">
    <div class="col-md-4">
        <p>{{ $question_text }}</p>
    </div>
    <div class="col-md-8">
        <input type="text" class="form-control" {!!  \App\BaseWidget\Form::getAttributes($data_attributes) !!} >
    </div>
</div>