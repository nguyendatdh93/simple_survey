<script>
    $(function () {
        $('#download-table').DataTable({
            'paging'      : true,
            "order": [[ 0, "desc" ]],
            'lengthChange': true,
            'searching'   : true,
            'ordering'    : true,
            'info'        : true,
            'autoWidth'   : true,
            'createdRow' : function( row, data, dataIndex ) {
                $(row).children(".tbl-control").html(addControls(row,data));
                $(row).children(".tbl-status").html(buttonForStatus(data));
            },
            "columnDefs": [
                { "targets": 0, "visible" : false },
                { "targets": 3, "orderable" : false},
                { "targets": 4, "orderable" : true},
                { "targets": 5, "orderable" : true},
                { "targets": 6, "orderable" : true},
                { "targets": 7,"orderable" : false},
            ],
            "language": {
                "url" : "/setup-lang"
            }
        });

        function addControls(row,data)
        {
            var html                = '',
                url_redirect_detail = '';

            url_redirect_detail = "{{ route(\App\Survey::NAME_URL_DOWNLOAD_PAGE_SURVEY) }}/"+ data[0];

            html += '<a href="'+ url_redirect_detail +'" class="btn btn-default bg-olive" data-toggle="tooltip" title="{{ trans('adminlte_lang::survey.go_download_button') }}"><i class="glyphicon glyphicon-download-alt"></i></a>';

            return html;
        }

        function buttonForStatus(data)
        {
            var html            = '',
                class_button_status = '';

            if(data.indexOf("{{ trans('adminlte_lang::survey.draf') }}") >= 0) {
                class_button_status = "btn-info";
            } else if(data.indexOf("{{ trans('adminlte_lang::survey.published') }}") >= 0) {
                class_button_status = "btn-warning";
            } else {
                class_button_status = "btn-default";
            }

            html += '<button type="button" class="btn '+ class_button_status +' btn-xs">'+data[1]+'</button>';

            return html;
        }
    });
</script>

<style>
    #download-table tr td:not(.tbl-name) {
        text-align: center;
    }
</style>