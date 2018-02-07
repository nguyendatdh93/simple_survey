@extends('user::layouts.survey')

@section('htmlheader_title')
    {{ trans('adminlte_lang::survey.htmlheader_title_answer_survey') }}
@endsection

@section('survey-header')
    <h1 class="headline1"></h1>

    <!-- ▼変更可能エリア※div（headFreeArea）は固定なので変更しないで下さい -->
    <div class="headFreeArea"></div>
@endsection

@section("content")
    <div class="secThanks1">
        <p>送信完了いたしました。<br>このたびはキャンペーンにご参加いただき、<br>誠にありがとうございました。</p>
        <!-- /.secThanks1 --></div>
@endsection

@section('addition-script')
<script>
    (function (global) {
        if(typeof (global) === "undefined") {
            console.log("window is undefined");
            return;
        }

        var _hash = "!";
        var noBackPlease = function () {
            global.location.href += "#";
            global.setTimeout(function () {
                global.location.href += "!";
            }, 50);
        };

        global.onhashchange = function () {
            if (global.location.hash !== _hash) {
                global.location.hash = _hash;
            }
        };

        global.onload = function () {
            noBackPlease();
            document.body.onkeydown = function (e) {
                var elm = e.target.nodeName.toLowerCase();
                if (e.which === 8 && (elm !== 'input' && elm  !== 'textarea')) {
                    e.preventDefault();
                }
                e.stopPropagation();
            };
        }

    })(window);
</script>
@stop