@extends('admin::survey.form_survey')

@section('bootstrap')
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
@endsection

@section('body')
    <style>
        nav.navbar.navbar-inverse.navbar-fixed-top {
            position: fixed;
            width: 100%;
            top: 0;
            background: #b5b5b5;
        }

        .navbar .jsButtonControls {
            display: inline-block;
            float: none;
            margin-bottom: 10px;
            margin-top: 10px;
        }

        .navbar .container-fluid {
            text-align: center;
        }

        .btn-circle {
            width: 30px;
            height: 30px;
            text-align: center;
            font-size: 12px;
            line-height: 1.428571429;
            border-radius: 15px;
        }
        .btn-circle.btn-xl {
            width: 60px;
            height: 60px;
            /* padding: 4px 10px; */
            font-size: 15px;
            line-height: 4.0;
            border-radius: 35px;
            display: block;
            border-radius: 50%;
        }
        .jsCopyUrlForm {
            position: absolute;
            right: 0px;
            top: 27px;
            right: 24px;
        }
        .jsLinkGoEditSurvey {
            position: absolute;
            left: 10px;
            top: 21px;
            background: #d9534f;
            padding: 6px;
            border-radius: 5px;
            color: white;
        }
        .btn-danger {
            background-color: #d9534f;
            color : #fff;
        }
        .btn-warning {
            background-color: #428bca;
            color : #fff;
        }
    </style>
    @if ($survey['status'] != \App\Survey::STATUS_SURVEY_CLOSED)
        <nav class="navbar navbar-inverse navbar-fixed-top" style="background: #e6e6e6;border-bottom: 2px solid #e6e6e6">
            <div class="container-fluid">
                <div class="jsButtonControls">
                    @if ($survey['status'] == \App\Survey::STATUS_SURVEY_PUBLISHED)
                        <a href="#open-modal-confirm-close" style="text-decoration: none" class="btn btn-danger btn-circle btn-xl">{{ trans('adminlte_lang::survey.confirm_button_close') }}</a>
                    @elseif ($survey['status'] == \App\Survey::STATUS_SURVEY_DRAF)
                        {{--<a href="{{ route(\App\Survey::NAME_URL_PUBLISH_SURVEY,['id' => $survey['id']]) }}" style="text-decoration: none" class="btn btn-warning btn-circle btn-xl">{{ trans('adminlte_lang::survey.confirm_button_publish') }}</a>--}}
                        <a href="#open-modal-confirm-publish" style="text-decoration: none" class="btn btn-warning btn-circle btn-xl">{{ trans('adminlte_lang::survey.confirm_button_publish') }}</a>
                    @endif
                </div>
                @if ($survey['status'] == \App\Survey::STATUS_SURVEY_PUBLISHED)
                    <div class="navbar-form navbar-right jsCopyUrlForm">
                        <div class="form-group" style="float: left">
                            <label class="jsUrlDomainCopy">{{ route(\App\Survey::NAME_URL_ANSWER_SURVEY) }}</label>
                            <input type="text" class="form-control jsUrlEncrypt" value="{{ $survey['encryption_url'] }}" placeholder="Search">
                        </div>
                        <p style="float: left; margin-left: 5px;color: #0072ef;cursor: pointer;" class="btn btn-link" style="color: dodgerblue" onclick="copyClipbroad()">Copy URL</p>
                    </div>
                @endif

                @if ($survey['status'] == \App\Survey::STATUS_SURVEY_DRAF)
                    <a href="" class="btn btn-link jsLinkGoEditSurvey"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> {{ trans('adminlte_lang::survey.go_to_edit') }}</a>
                @endif
            </div>
        </nav>
    @endif
    <div class="container">
        <div id="pagetop" @if ($survey['status'] != \App\Survey::STATUS_SURVEY_CLOSED) style="margin-top: 120px" @endif>
            <div id="layout">
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

    <link rel="stylesheet" type="text/css" href="{{ asset('/css/modal.css') }}" />
    <!-- Modal -->
    <div id="open-modal-confirm-close" class="modal-window">
        <div>
            <a href="#modal-close" title="Close" class="modal-close"><i class="fa fa-times-circle" style="position: absolute;top: 2px;right: 3px;font-size: 18px;" aria-hidden="true"></i></a>
            <h1>{{ trans('adminlte_lang::survey.confirm_close_survey_title') }}</h1>
            <div>{{ trans('adminlte_lang::survey.confirm_close_survey_content') }}</div>
            <div class="jsButtonModalControls">
                <a href="#modal-close" title="Close" class="jsButton jsbutton-danger">{{ trans('adminlte_lang::survey.confirm_button_cancel') }}</a>
                <a href="{{ route(\App\Survey::NAME_URL_CLOSE_SURVEY,['id' => $survey['id']]) }}" class="jsButton jsbutton-success">{{ trans('adminlte_lang::survey.confirm_close_survey_button_close') }}</a>
            </div>
        </div>
    </div>

    <div id="open-modal-confirm-publish" class="modal-window">
        <div>
            <a href="#modal-close" title="Close" class="modal-close"><i class="fa fa-times-circle" style="position: absolute;top: 2px;right: 3px;font-size: 18px;" aria-hidden="true"></i></a>
            <h1>{{ trans('adminlte_lang::survey.confirm_close_survey_title') }}</h1>
            <div>{{ trans('adminlte_lang::survey.confirm_close_survey_content') }}</div>
            <div class="jsButtonModalControls">
                <a href="#modal-close" title="Close" class="jsButton jsbutton-danger">{{ trans('adminlte_lang::survey.confirm_button_cancel') }}</a>
                <a href="{{ route(\App\Survey::NAME_URL_PUBLISH_SURVEY,['id' => $survey['id']]) }}" class="jsButton jsbutton-success">{{ trans('adminlte_lang::survey.confirm_close_survey_button_close') }}</a>
            </div>
        </div>
    </div>
    <!-- /Modal -->

    <script>
        function copyClipbroad() {
            var urlCopy = $('.jsUrlDomainCopy').html() +'/'+ $('.jsUrlEncrypt').val();
            copyToClipboard(urlCopy);
        }

        function copyToClipboard(text) {
            if (window.clipboardData && window.clipboardData.setData) {
                // IE specific code path to prevent textarea being shown while dialog is visible.
                return clipboardData.setData("Text", text);

            } else if (document.queryCommandSupported && document.queryCommandSupported("copy")) {
                var textarea = document.createElement("textarea");
                textarea.textContent = text;
                textarea.style.position = "fixed";  // Prevent scrolling to bottom of page in MS Edge.
                document.body.appendChild(textarea);
                textarea.select();
                try {
                    return document.execCommand("copy");  // Security exception may be thrown by some browsers.
                } catch (ex) {
                    console.warn("Copy to clipboard failed.", ex);
                    return false;
                } finally {
                    document.body.removeChild(textarea);
                }
            }
        }
    </script>
@endsection