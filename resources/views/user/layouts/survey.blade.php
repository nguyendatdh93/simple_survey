<!doctype html>
<html lang="ja">
<head>
    @include('user::survey.partials.htmlheader')
    @include('user::survey.partials.script')
</head>
<body id="form">
@section('body')
    <div id="pagetop">
        <div id="layout">
            @include('user::survey.partials.header')
            @include('user::survey.partials.content')
            @include('user::survey.partials.footer')
        <!-- /.layout --></div>
    <!-- /.pagetop --></div>
@show

</body>
</html>