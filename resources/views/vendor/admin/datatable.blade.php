@extends('admin::layouts.app')

@section('htmlheader_title')
    {{ trans('adminlte_lang::message.home') }}
@endsection

@section('main-content-form')
    <div class="container-fluid spark-screen">
        <!-- Main content -->
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            {!! \App\BaseWidget\Form::table($idTable, $title, $titleHeaders, $datas) !!}
                            <!-- /.box -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </section>
                <!-- /.content -->
                {!! \App\BaseWidget\Form::link('Go to homepage',array('href' => url('form'),'class' => 'btn btn-primary')) !!}
            </div>
            <!--/.col (right) -->
            <!-- /.row -->
            </section>
        </div>
    </div>
@endsection
