@extends('admin::layouts.app')

@section('htmlheader_title')
    {{ trans('adminlte_lang::message.home') }}
@endsection

@section('main-content-form')
    <div class="container-fluid spark-screen">
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

                                    <!-- textaria -->
                                    <div class="form-group">
                                        {!! FormSimple::textarea(array('class'=> 'textarea')) !!}
                                    </div>

                                    <!-- textaria ckeditor -->
                                    <div class="form-group">
                                        {!! FormSimple::textarea(array('id'=>'ckeditor1', 'class'=> 'editor1', 'name'=>'editor1')) !!}
                                    </div>
                                </div>

                                <div class="box-footer">
                                    {!! FormSimple::button('Submit', array('type' => 'submit','class' => 'btn btn-primary','icon' => 'fa fa-wifi' )) !!}
                                </div>
                            </form>
                        </div>
                        <!-- /.box -->
                    </div>
                    <!--/.col (right) -->
                    <div class="col-md-6">
                        <!-- general form elements -->
                        <div class="panel panel-default">
                            <div class="box-header with-border panel-heading">
                                <h3 class="box-title">Survey example</h3>
                            </div>
                            <div class="box-body">
                                <div class="form-group">
                                    <div class="col-md-1"></div>
                                    <div class="col-md-10">
                                        <div class="form-block">
                                            <div class="form-group">
                                                <div class="col-md-8">
                                                    <div class="form-group">
                                                        {!! FormSimple::input(array('type'=>'text','class' => 'form-control', 'id'=>'exampleInputEmail1', 'placeholder'=> 'Question', "style" => "border: none;
                border-bottom: 1px solid #d2d6de;")) !!}
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        {!! FormSimple::select(
                                                         array(
                                                            'class'=> 'form-control select2',
                                                            'style' => 'width: 100%;'
                                                            ),
                                                         array(
                                                            'single text'=> array('selected'=>'selected'),
                                                            'Multi text',
                                                            'Single choice',
                                                            'Multi choices'
                                                            )) !!}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-md-12">
                                                {!! FormSimple::input(array('type'=>'text','class' => 'form-control', 'id'=>'exampleInputEmail1', 'placeholder'=> 'Single line',"style" => "border: none;
            border-bottom: 1px solid #d2d6de;")) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-1"></div>
                                    {{--<label for="exampleInputEmail1">Email address</label>--}}
                                </div>

                            </div>
                        </div>
                        {!! FormSimple::button('Next', array('type' => 'submit','class' => 'btn btn-primary','icon' => 'fa fa-wifi', "style" => "display:block; margin:0px auto" )) !!}
                        <!-- /.box -->
                    </div>
                </div>
                <!-- /.row -->
            </section>
    </div>
@endsection