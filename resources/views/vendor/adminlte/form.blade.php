@extends('adminlte::layouts.app')

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
                                        {!! \App\BaseWidget\Form::label('Email address', array('for'=> 'exampleInputEmail1')) !!}
                                        {!! \App\BaseWidget\Form::input(array('type'=>'email','class' => 'form-control', 'id'=>'exampleInputEmail1', 'placeholder'=> 'Enter email')) !!}
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Password</label>
                                        {!! \App\BaseWidget\Form::input(array('type'=>'password','class' => 'form-control', 'id'=>'exampleInputPassword1', 'placeholder'=> 'Password')) !!}
                                    </div>
                                    <div class="form-group">
                                        {{--<label for="exampleInputFile">File input</label>--}}
                                        {!! \App\BaseWidget\Form::label('Email address', array('for'=> 'exampleInputFile')) !!}
                                        {{--<input type="file" id="exampleInputFile">--}}
                                        {{--<p class="help-block">Example block-level help text here.</p>--}}
                                        {!! \App\BaseWidget\Form::input(array('type' => 'file','id' => 'exampleInputFile', 'help-block' => 'Example block-level help text here.')) !!}
                                    </div>
                                    <div class="form-group">
                                        {!! \App\BaseWidget\Form::label('Minimal') !!}
                                        {!! \App\BaseWidget\Form::select(
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
                                            {!! \App\BaseWidget\Form::input(array('type'=>'checkbox')) !!} Check me out
                                        </label>
                                    </div>

                                    <div class="form-group">
                                        {!! \App\BaseWidget\Form::label('Date') !!}
                                        {!! \App\BaseWidget\Form::date(array('type'=> 'text', 'class' => 'form-control pull-right datepicker')) !!}
                                        <!-- /.input group -->
                                    </div>

                                    <!-- radio -->
                                    <div class="form-group">
                                        {!! \App\BaseWidget\Form::radio('Demo', array('name'=> 'r1', 'checked' => 'checked')) !!}
                                        {!! \App\BaseWidget\Form::radio('Demo2', array('name'=> 'r2')) !!}
                                        {!! \App\BaseWidget\Form::radio('Demo2', array('name'=> 'r2', 'disabled' => 'disabled')) !!}
                                    </div>

                                    <!-- checkbox -->
                                    <div class="form-group">
                                        {!! \App\BaseWidget\Form::checkbox('Demo', array('name'=> 'r1', 'checked' => 'checked')) !!}
                                        {!! \App\BaseWidget\Form::checkbox('Demo2', array('name'=> 'r2')) !!}
                                        {!! \App\BaseWidget\Form::checkbox('Demo2', array('name'=> 'r2', 'disabled' => 'disabled')) !!}
                                    </div>
                                </div>

                                <div class="box-footer">
                                    {!! \App\BaseWidget\Form::button('Submit', array('type' => 'submit','class' => 'btn btn-primary')) !!}
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