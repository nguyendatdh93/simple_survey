@extends('admin::survey.form_survey')

@section('bootstrap')
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
@endsection

@section('body')
    <style>
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
            padding: 6px 0;
            font-size: 12px;
            line-height: 1.428571429;
            border-radius: 15px;
        }
        .btn-circle.btn-xl {
            width: 70px;
            height: 70px;
            padding: 4px 10px;
            font-size: 15px;
            line-height: 4.33;
            border-radius: 35px;
        }
        .jsCopyUrlForm {
            position: absolute;
            right: 0px;
            top: 19px;
            right: 24px;
        }
    </style>
    <nav class="navbar navbar-inverse navbar-fixed-top" style="background: #e6e6e6;border-bottom: 2px solid #e6e6e6">
        <div class="container-fluid">
            <div class="jsButtonControls">
                @if ($survey['status'] == \App\Survey::STATUS_SURVEY_PUBLISHED)
                    <a href="{{ route(\App\Survey::NAME_URL_CLOSE_SURVEY,['id' => $survey['id']]) }}" class="btn btn-danger btn-circle btn-xl">Close</a>
                @elseif ($survey['status'] == \App\Survey::STATUS_SURVEY_DRAF)
                    <a href="{{ route(\App\Survey::NAME_URL_PUBLISH_SURVEY,['id' => $survey['id']]) }}" class="btn btn-warning btn-circle btn-xl">Publish</a>
                @endif
            </div>
            @if ($survey['status'] == \App\Survey::STATUS_SURVEY_PUBLISHED)
                <div class="navbar-form navbar-right jsCopyUrlForm">
                    <div class="form-group">
                        <label class="jsUrlDomainCopy">{{ route(\App\Survey::NAME_URL_ANSWER_SURVEY) }}</label>
                        <input type="text" class="form-control jsUrlEncrypt" value="{{ $survey['encryption_url'] }}" placeholder="Search">
                    </div>
                    <button type="button" class="btn btn-link" style="color: dodgerblue" onclick="copyClipbroad()">Copy URL</button>
                </div>
            @endif
        </div>
    </nav>
    <div class="container">
        <div id="pagetop" style="margin-top: 120px">
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