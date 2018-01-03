@extends('admin::layouts.app')

@section('htmlheader_title')
    {{ trans('adminlte_lang::message.home') }}
@endsection

@section('main-content-form')
    <div class="container-fluid spark-screen">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    General Form Elements
                    <small>Preview</small>
                </h1>
                <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li><a href="#">Forms</a></li>
                    <li class="active">General Elements</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-6">
                        <!-- general form elements -->
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">Quick Example</h3>
                            </div>
                            <!-- /.box-header -->
                            <!-- form start -->
                            <form role="form">
                                <div class="box-body">
                                    <div class="form-group">
                                        {{--<label for="exampleInputEmail1">Email address</label>--}}
                                        {!! FormSimple::label('Email address', array('for'=> 'exampleInputEmail1')) !!}
                                        {!! FormSimple::input(array('type'=>'email','class' => 'form-control', 'id'=>'exampleInputEmail1', 'placeholder'=> 'Enter email')) !!}
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Password</label>
                                        {!! FormSimple::input(array('type'=>'password','class' => 'form-control', 'id'=>'exampleInputPassword1', 'placeholder'=> 'Password')) !!}
                                    </div>
                                    <div class="form-group">
                                        {{--<label for="exampleInputFile">File input</label>--}}
                                        {!! FormSimple::label('Email address', array('for'=> 'exampleInputFile')) !!}
                                        {{--<input type="file" id="exampleInputFile">--}}
                                        {{--<p class="help-block">Example block-level help text here.</p>--}}
                                        {!! FormSimple::input(array('type' => 'file','id' => 'exampleInputFile', 'help-block' => 'Example block-level help text here.')) !!}
                                    </div>
                                    <div class="form-group">
                                        {!! FormSimple::label('Minimal') !!}
                                        {!! FormSimple::select(
                                         array(
                                            'class'=> 'form-control select2',
                                            'style' => 'width: 100%;'
                                            ),
                                         array(
                                            'Alabama'=> array('selected'=>'selected'),
                                            'Alaska',
                                            'California'
                                            )) !!}
                                    </div>
                                    <div class="checkbox">
                                        <label>
                                            {{--<input type="checkbox"> Check me out--}}
                                            {!! FormSimple::input(array('type'=>'checkbox')) !!} Check me out
                                        </label>
                                    </div>

                                    <div class="form-group">
                                        {!! FormSimple::label('Date') !!}
                                        {!! FormSimple::date(array('type'=> 'text', 'class' => 'form-control pull-right datepicker')) !!}
                                        <!-- /.input group -->
                                    </div>

                                    <!-- radio -->
                                    <div class="form-group">
                                        {!! FormSimple::radio('Demo', array('name'=> 'r1', 'checked' => 'checked')) !!}
                                        {!! FormSimple::radio('Demo2', array('name'=> 'r2')) !!}
                                        {!! FormSimple::radio('Demo2', array('name'=> 'r2', 'disabled' => 'disabled')) !!}
                                    </div>

                                    <!-- checkbox -->
                                    <div class="form-group">
                                        {!! FormSimple::checkbox('Demo', array('name'=> 'r1', 'checked' => 'checked')) !!}
                                        {!! FormSimple::checkbox('Demo2', array('name'=> 'r2')) !!}
                                        {!! FormSimple::checkbox('Demo2', array('name'=> 'r2', 'disabled' => 'disabled')) !!}
                                    </div>
                                </div>

                                <div class="box-footer">
                                    {!! \App\BaseWidget\Form::button('Submit', array('type' => 'submit','class' => 'btn btn-primary','icon' => 'fa fa-wifi' )) !!}
                                </div>
                            </form>
                        </div>
                        <!-- /.box -->
                    </div>
                    <!--/.col (right) -->
                </div>
                <!-- /.row -->
            </section>
    </div>
@endsection