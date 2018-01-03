<div class="box">
    <div class="box-header">
        <h3 class="box-title">{{ $title }}</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <table id="{{ $id_table }}" class="table table-bordered table-striped" data-setting-searching="false">
            <thead>
            <tr>
                @foreach($title_headers as $title)
                    <th style="text-align: center">{{ $title }}</th>
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
                @foreach($title_headers as $title)
                    <th style="text-align: center">{{ $title }}</th>
                @endforeach
            </tr>
            </tfoot>
        </table>
    </div>
    <!-- /.box-body -->
</div>

