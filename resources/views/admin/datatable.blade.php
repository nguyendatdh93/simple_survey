@extends('admin::layouts.app')

@section('htmlheader_title', $settings['title'])

@section('datatable')
    {{--<script src="{{ url ('datatableservice.js') }}"></script>--}}
@stop

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
                            {!! \App\BaseWidget\Form::table($settings, $datas) !!}
                            <!-- /.box -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </section>
                <!-- /.content -->
            </div>
            <!--/.col (right) -->
            <!-- /.row -->
            </section>
        </div>
    </div>
@endsection

