<!doctype html>
<html lang="ja">
<head>
    @include('admin::survey.partials.htmlheader')
</head>
<body id="form">

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

        <script>
            function agreeCheck(){
                var flg1 = document.getElementById('JChkCaution1').checked;
                if(!flg1){
                    alert('規約に承諾してください');
                    return false;
                } else {
                    document.join_form.submit();
                }
            }
        </script>

        @include('admin::survey.partials.form_content')

        <div class="footer">
            <!-- ▼変更可能エリア※div（copy）は固定なので変更しないでください -->
            <p class="copy">Copyright &copy; 2016 ●●●●●, Inc. All Rights Reserved.</p>
            <!-- ▲変更可能エリア 終わり -->
            <!-- /.footer --></div>

        <!-- /.layout --></div>
    <!-- /.pagetop --></div>

</body>
</html>