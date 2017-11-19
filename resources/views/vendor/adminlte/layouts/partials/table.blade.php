<div class="container-fluid spark-screen">
    <!-- Main content -->
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">{{ $title }}</h3>
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            @foreach($titleHeaders as $title)
                                                <th>{{ $title }}</th>
                                            @endforeach
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($datas as $data)
                                            <tr>
                                                @foreach($data as $value)
                                                    <td>{{$value}}</td>
                                                @endforeach
                                            </tr>
                                        @endforeach
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            @foreach($titleHeaders as $title)
                                                <th>{{ $title }}</th>
                                            @endforeach
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                <!-- /.box-body -->
                            </div>
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
