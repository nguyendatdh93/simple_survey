<script>
    $(function () {
        $('#download-table').DataTable({
            'paging'      : true,
            'lengthChange': true,
            'searching'   : true,
            'ordering'    : true,
            'info'        : true,
            'autoWidth'   : true,
            'createdRow' : function( row, data, dataIndex ) {
//                var DatatableSerbvice = new DatatableService();
                $(row).children(".tbl-control").html(addControls(row,data));
                $(row).children(".tbl-status").html(buttonForStatus(data));
            },
            "columnDefs": [
                { "targets": 0, "visible" : false },
                { "targets": 3, "orderable" : false},
                { "targets": 4, "orderable" : false},
                { "targets": 5, "orderable" : false},
                { "targets": 6, "orderable" : false},
                { "targets": 7,"orderable" : false},
            ],
        });

        function addControls(row,data)
        {
            var html            = '',
                url_redirect_detail = '',
                url_redirect_copy   = '';

            if(data.indexOf("{{ trans('adminlte_lang::survey.draf') }}") >= 0) {
                url_redirect_detail = "{{ route("draf") }}/"+ data[0];
            } else if(data.indexOf("{{ trans('adminlte_lang::survey.published') }}") >= 0) {
                url_redirect_detail = "{{ route("publish") }}/"+ data[0];
            } else {
                url_redirect_detail = "{{ route("close") }}/"+ data[0];
            }

            html += '<a href="'+ url_redirect_detail +'" class="btn btn-default bg-olive" data-toggle="tooltip" title="{{ trans('adminlte_lang::survey.go_download_button') }}"><i class="fa fa-download"></i></a>';

            return html;
        }

        function buttonForStatus(data)
        {
            var html            = '',
                class_button_status = '';

            if(data.indexOf("{{ trans('adminlte_lang::survey.draf') }}") >= 0) {
                class_button_status = "btn-default";
            } else if(data.indexOf("{{ trans('adminlte_lang::survey.published') }}") >= 0) {
                class_button_status = "btn-info";
            } else {
                class_button_status = "btn-warning";
            }

            html += '<button type="button" class="btn btn-block '+ class_button_status +' btn-xs">'+data[1]+'</button>';

            return html;
        }


    });

</script>