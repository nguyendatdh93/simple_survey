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
                        <div class="panel panel-default">
                            <div class="col-md-1"></div>
                            <!-- general form elements -->
                            <div class="col-md-10">
                                <div class="preview preview-header">
                                    <h1>{{ isset($survey['name']) ? $survey['name'] : "Survey must has name" }}</h1>
                                    @if($survey['image_path'] != '')
                                        <img src="https://www.w3schools.com/css/trolltunga.jpg" class="img-rounded" alt="Cinque Terre">
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
                            {!! FormSimple::button('Draf', array('type' => 'submit','class' => 'btn btn-default','icon' => '', "style" => "display:block; margin:0px auto; float: left" )) !!}
                            {!! FormSimple::button('Publish', array('type' => 'submit','class' => 'btn btn-primary','icon' => '', "style" => "display:block; margin:0px auto; float: left; margin-left : 10px" )) !!}
                        </div>
                    </div>
                    <div class="col-md-1"></div>
                </div>
            </section>
    </div>
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
    .preview-button {
        width: 300px;
        display: block;
        margin: 0px auto;
    }
</style>