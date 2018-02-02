<!doctype html>
<html lang="ja">
<head>
    @include('admin::survey.partials.htmlheader')
    @include('admin::survey.partials.script')
</head>
<body id="form">
@section('body')
    <div id="pagetop">
        <div id="layout">
            @include('admin::survey.partials.header')
            @include('admin::survey.partials.content')
            @include('admin::survey.partials.footer')
        <!-- /.layout --></div>
    <!-- /.pagetop --></div>
@show
</body>
</html>