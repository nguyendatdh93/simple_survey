@extends('admin::layouts.errors')

@section('htmlheader_title')
    {{ trans('adminlte_lang::message.pagenotfound') }}
@endsection

@section('main-content')

    <div class="error-page">
        <div class="error-content">

            <h2 class="headline text-yellow" style="font-size: 100px"> <i class="glyphicon glyphicon-warning-sign text-yellow" style="padding-left: 10px;padding-right: 14px;"></i>404</h2>
            <h3 style="margin-left: 23px"> Oops! {{ trans('adminlte_lang::message.pagenotfound') }}.</h3>
        </div><!-- /.error-content -->
    </div><!-- /.error-page -->
@endsection

<style>
    .error-page {
        background: none !important;
    }
</style>