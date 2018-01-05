@extends('admin::layouts.app')

@section('htmlheader_title')
    {{ trans('adminlte_lang::message.home') }}
@endsection

@section('main-content-form')
    <div class="container-fluid spark-screen">
            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-1"></div>
                    <div class="col-md-10">
                        @include('admin::layouts.partials.alert_message')
                        <div>
                            <div class="col-md-1"></div>
                            <!-- general form elements -->
                            <div class="col-md-10">
                                <div class="preview preview-header">
                                    <h1>{{ isset($survey['name']) ? $survey['name'] : "Survey must has name" }}</h1>
                                    @if($survey['image_path'] != '')
                                        {!! FormSimple::img(isset($survey['image_path']) ? $survey['image_path'] : "", array("class" => "img-rounded","alt" => "Cinque Terre")) !!}
                                    @endif
                                    <p>{{ isset($survey['description']) ? $survey['description'] : "" }}</p>
                                    @if(isset($survey['questions'][\App\Question::CATEGORY_HEADER]))
                                        {!! \App\BaseWidget\Survey::formAnswerPattern($survey['questions'][\App\Question::CATEGORY_HEADER]) !!}
                                    @endif
                                </div>
                                <div class="preview preview-content">
                                    @if(isset($survey['questions'][\App\Question::CATEGORY_CONTENT]))
                                        {!! \App\BaseWidget\Survey::formAnswerPattern($survey['questions'][\App\Question::CATEGORY_CONTENT]) !!}
                                    @endif
                                </div>
                                <div class="preview preview-footer">
                                    @if(isset($survey['questions'][\App\Question::CATEGORY_FOOTER]))
                                        {!! \App\BaseWidget\Survey::formAnswerPattern($survey['questions'][\App\Question::CATEGORY_FOOTER]) !!}
                                    @endif
                                </div>
                            </div>
                            <!-- /.box -->
                            <div class="col-md-1"></div>
                        </div>
                    </div>
                    <div class="col-md-1"></div>
                </div>
                <!-- /.row -->
                <div class="row preview">
                    <!-- left column -->
                    <div class="col-md-1"></div>
                    <div class="col-md-10">
                        <div class="preview-button">
                            @if($name_url == \App\Survey::NAME_URL_PREVIEW_DRAF)
                                {!! FormSimple::a('Publish', '#', array('class' => 'btn bg-olive btn-flat margin','icon' => '', "style" => "display:block; margin:0px auto;", 'data-toggle' =>"modal", 'data-target' => "#modal-confirm-publish")) !!}
                            @elseif($name_url == \App\Survey::NAME_URL_PREVIEW_PUBLISH)
                                {!! FormSimple::a('Close', '#', array('class' => 'btn bg-orange btn-flat margin','icon' => '', "style" => "display:block; margin:0px auto;", 'data-toggle' =>"modal", 'data-target' => "#modal-confirm-close")) !!}
                            @endif
                        </div>
                    </div>
                    <div class="col-md-1"></div>
                </div>
            </section>
    </div>
    {!! FormSimple::modalConfirm(array(
             'id'      => 'modal-confirm-publish',
             'title'   => trans('adminlte_lang::survey.confirm_publish_survey_title'),
             'content' => trans('adminlte_lang::survey.confirm_publish_survey_content'),
             'buttons' => array(
                array(
                    'text'  => trans('adminlte_lang::survey.confirm_publish_survey_button_close'),
                    'attributes' => array(
                        'class'        => 'btn btn-default pull-left',
                        'data-dismiss' => "modal"
                    )
                ),
                array(
                    'text'  => trans('adminlte_lang::survey.confirm_publish_survey_button_publish'),
                    'href'  => route(\App\Survey::NAME_URL_PUBLISH_SURVEY).'/'.$survey['id'],
                    'attributes' => array(
                        'class' => 'btn btn-primary',
                    )
                )
             )
        )) !!}

    {!! FormSimple::modalConfirm(array(
             'id'      => 'modal-confirm-close',
             'title'   => trans('adminlte_lang::survey.confirm_close_survey_title'),
             'content' => trans('adminlte_lang::survey.confirm_close_survey_content'),
             'buttons' => array(
                array(
                    'text'  => trans('adminlte_lang::survey.confirm_close_survey_button_close'),
                    'attributes' => array(
                        'class'        => 'btn btn-default pull-left',
                        'data-dismiss' => "modal"
                    )
                ),
                array(
                    'text'  => trans('adminlte_lang::survey.confirm_close_survey_button_publish'),
                    'href'  => route(\App\Survey::NAME_URL_CLOSE_SURVEY).'/'.$survey['id'],
                    'attributes' => array(
                        'class' => 'btn btn-primary',
                    )
                )
             )
        )) !!}
@endsection

<style>
    .preview {
        margin-top: 20px;
    }
    .preview-header {
        background: #e8e8e8;
        padding: 20px;
    }
    .preview-header .row {
        padding: 10px;
        border-top : solid 1px #d4d4d4;
    }
    .preview-header h1 {
        text-align: center;
    }
    .preview-header img {
        margin: 0px auto;
        display: block;
        width: 100%;
    }
    .preview-content {
        background: #fff;
        padding: 20px;
    }
    .preview-content .row {
        padding: 10px;
        border-top : solid 1px #d4d4d4;
    }
    .preview-footer {
        background: #e8e8e8;
        padding: 20px;
    }
    .preview-footer .row {
        padding: 10px;
        border-top : solid 1px #d4d4d4;
    }
    .btn-flat {
        width: 80px;
        display: block;
        margin: 0px auto;
    }
</style>