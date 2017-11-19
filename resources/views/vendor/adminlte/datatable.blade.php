@extends('adminlte::layouts.app')

@section('htmlheader_title')
    {{ trans('adminlte_lang::message.home') }}
@endsection

@section('main-content-form')
    {!! \App\BaseWidget\Form::table($title, $titleHeaders, $datas) !!}
@endsection
