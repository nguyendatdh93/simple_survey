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