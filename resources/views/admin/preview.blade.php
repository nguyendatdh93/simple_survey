@extends('admin::survey.form_survey')

@section('htmlheader_title')
    @if ($survey['status'] == \App\Survey::STATUS_SURVEY_PUBLISHED)
        {{ trans('adminlte_lang::survey.htmlheader_title_preview_publish') }}
    @elseif ($survey['status'] == \App\Survey::STATUS_SURVEY_DRAF)
        {{ trans('adminlte_lang::survey.htmlheader_title_preview_draf') }}
    @elseif ($survey['status'] == \App\Survey::STATUS_SURVEY_CLOSED)
        {{ trans('adminlte_lang::survey.htmlheader_title_preview_close') }}
    @else
        {{ trans('adminlte_lang::survey.htmlheader_title_preview') }}
    @endif
@endsection

@section('bootstrap')
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
@endsection

@section('body')
    <link rel="stylesheet" href="{{ asset('css/styleusers.css') }}">

    <div class="container">
        <div id="pagetop">
            <div id="layout">
                @if($message = Session::get('alert_error'))
                    <div class="alert alert-success">
                        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                        <strong>{{ $message }}</strong>
                    </div>
                @endif
                @if($message = Session::get('alert_success'))
                    <div class="alert alert-success">
                        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                        <strong>{{ $message }}</strong>
                    </div>
                @endif

                <div class="header">
                    <div class="headerWrap1">
                    @include('admin::survey.partials.script')

                    @include('admin::survey.partials.form_header')
                        <!-- /.headerWrap1 --></div>
                    <!-- /.header --></div>
            @include('admin::survey.partials.form_content')

            @include('admin::survey.partials.footer')

            <!-- /.layout --></div>
            <!-- /.pagetop --></div>
    </div>
@endsection