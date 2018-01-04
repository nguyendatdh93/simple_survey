<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
        $('#users-table').DataTable({
            'paging'      : true,
            'lengthChange': false,
            'searching'   : true,
            'ordering'    : true,
            'info'        : true,
            'autoWidth'   : false,
            "columnDefs": [
                { "orderable": false, "targets": 0, "visible" : false },
                { "orderable": true, "targets": 1 },
                { "orderable": true, "targets": 2 },
                { "orderable": false, "targets": 3 },
            ],
        });

        $('#survey-table').DataTable({
            'paging'      : true,
            'lengthChange': false,
            'searching'   : true,
            'ordering'    : true,
            'info'        : true,
            'autoWidth'   : false,
            'createdRow' : function( row, data, dataIndex ) {
                if(data.indexOf("{{ trans('adminlte_lang::survey.draf') }}") >= 0) {
                    $( row ).addClass("row-draf" );
                } else if(data.indexOf("{{ trans('adminlte_lang::survey.published') }}") >= 0) {
                    $( row ).addClass("row-published" );
                } else {
                    $( row ).addClass("row-closed" );
                }
            },
            "columnDefs": [
                { "targets": 0, "visible" : false },
                { "targets": 3, "orderable" : false},
                { "targets": 4, "orderable" : false},
                { "targets": 5, "orderable" : false},
                { "targets": 6, "orderable" : false},
                {
                    "targets": 7,
                    "orderable" : false,
                    "render" : function (data, type, full, meta) {
                        var html = '';
                        html += '<a href="#" class="btn btn-default" data-toggle="tooltip" title="{{ trans('adminlte_lang::datatable.detail') }}"><i class="fa fa-list-alt"></i></a>';
                        html += '<a href="#" class="btn btn-default" style="margin-left: 5px" data-toggle="tooltip" title="{{ trans('adminlte_lang::datatable.copy_survey') }}"><i class="fa fa-copy"></i></a>';

                        return html;
                    }
                },
            ],
        });
    });

</script>

<style>
    .row-draf {
        background-color: white !important;
    }
    .row-published {
        background-color: #d4eacc !important;
    }
    .row-closed {
        background-color: #cacaca !important;
    }
</style>