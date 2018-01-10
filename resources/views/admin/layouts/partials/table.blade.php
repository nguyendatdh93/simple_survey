@include('admin::layouts.partials.alert_message')
<div class="box">
    <div class="box-header">
        <h3 class="box-title">{{ isset($settings['title']) ? $settings['title'] : "" }}</h3>
        <div class="pull-right">
            @if(isset($settings['buttons']))
                @foreach($settings['buttons'] as $button)
                    @if(\App\BaseWidget\Validator::checkIsButtonTag($button))
                        {!! \App\BaseWidget\Form::button($button['text'], $button['attributes']) !!}
                    @else
                        {!! \App\BaseWidget\Form::a($button['text'], $button['href'], $button['attributes']) !!}
                    @endif
                @endforeach
            @endif
        </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <table id="{{ isset($settings['id']) ? $settings['id'] : "table-default" }}" class="table table-bordered table-striped" data-setting-searching="false">
            <thead>
            <tr>
                @if(!isset($settings['headers_columns']['Id'])) <th style="text-align: center">{{ "ID" }}</th> @endif
                @foreach($settings['headers_columns'] as $key => $key_column)
                    <th style="text-align: center">{{ $key }}</th>
                @endforeach
                @if(isset($settings['controls']) && $settings['controls'] == true)
                    <th style="text-align: center">{{ trans('adminlte_lang::datatable.controls') }}</th>
                @endif
            </tr>
            </thead>
            <tbody>
            @php $stt = 1; @endphp
            @foreach($datas as $data)
                <tr>

                    @if(!isset($settings['headers_columns']['Id'])) <td>{{ $stt }}</td> @endif
                    @php $stt++; @endphp
                    @foreach($settings['headers_columns'] as $key => $key_column)
                        @if(is_array($key_column))
                            <td class="tbl-{{$key_column['column']}}">@if($key_column['type'] == \App\BaseWidget\Validator::TYPE_IMAGE) {!! \App\BaseWidget\Form::img($data[$key_column['column']], array("class" => "img-datatable","alt" => "Image")) !!} @endif </td>
                        @else
                            <td class="tbl-{{$key_column}}">{{ $data[$key_column] }}</td>
                        @endif
                    @endforeach
                    @if(isset($settings['controls']) && $settings['controls'] == true)
                        <td style="text-align: center" class="tbl-control">{{ "-" }}</td>
                    @endif
                </tr>
            @endforeach
            </tbody>
            <tfoot>
            <tr>
                @if(!isset($settings['headers_columns']['Id'])) <th style="text-align: center">{{ "ID" }}</th> @endif
                @foreach($settings['headers_columns'] as $key => $title)
                    <th style="text-align: center">{{ $key }}</th>
                @endforeach
                @if(isset($settings['controls']) && $settings['controls'] == true)
                    <th style="text-align: center">{{ trans('adminlte_lang::datatable.controls') }}</th>
                @endif
            </tr>
            </tfoot>
        </table>
    </div>
    <!-- /.box-body -->
</div>
