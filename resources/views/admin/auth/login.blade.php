@extends('admin::layouts.auth')

@section('htmlheader_title')
    Log in
@endsection

@section('content')
<body class="hold-transition login-page">
    <div id="app" v-cloak>
        <div class="login-box" style="width: 500px">
            <div class="login-logo">
                <a href="{{ url('/home') }}"><b style="font-size: 34px;"> @if(trans('adminlte_lang::header.logo') != '') {{ trans('adminlte_lang::header.logo') }} @endif</b></a>
            </div><!-- /.login-logo -->

        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <strong>Whoops!</strong> {{ trans('adminlte_lang::message.someproblems') }}<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="login-box-body" style="width: 80%;margin: 0px auto;">
            @include('admin::auth.partials.social_login')
        </div>

    </div>
    </div>
    @include('admin::layouts.partials.scripts_auth')

    <script>
        $(function () {
            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' // optional
            });
        });
    </script>
</body>

@endsection
