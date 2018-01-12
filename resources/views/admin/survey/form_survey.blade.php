<!doctype html>
<html lang="ja">
<head>
    @include('admin::survey.partials.htmlheader')
</head>
<body id="form">
@section('body')
    <div id="pagetop">
        <div id="layout">
            <div class="header">
                <div class="headerWrap1">
                    @include('admin::survey.partials.script')

                    @include('admin::survey.partials.form_header')

                    <!-- ▼年齢認証が必要ない場合は、削除してください -->
                    <!-- ▲年齢認証が必要ない場合は、削除してください -->

                    <!-- /.headerWrap1 --></div>
                <!-- /.header --></div>
            @include('admin::survey.partials.form_content')

            @include('admin::survey.partials.footer')

            <!-- /.layout --></div>
        <!-- /.pagetop --></div>
@show

</body>
</html>