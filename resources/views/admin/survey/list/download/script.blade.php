<script>
    var surveyService = new SurveyService();
    $(function () {
        $('#download-table').DataTable({
            'paging'      : true,
            "order": [[ 0, "desc" ]],
            'lengthChange': true,
            'searching'   : true,
            'ordering'    : true,
            'info'        : true,
            'lengthMenu'  : [ {!! implode(',', \App\BaseWidget\Form::SETTING_LENGHT_MENU_DATATABLE)  !!}],
            'autoWidth'   : true,
            'createdRow' : function( row, data, dataIndex ) {
                $(row).children(".tbl-control").html(surveyService.addControlsForDownloadList(row, data,["{{ route(\App\Survey::NAME_URL_DOWNLOAD_PAGE_SURVEY) }}"], ["{{ trans('adminlte_lang::survey.go_download_button') }}"]));
                $(row).children(".tbl-status").html(surveyService.addButtonForStatus(data, ["{{ trans('adminlte_lang::survey.draf') }}", "{{ trans('adminlte_lang::survey.published') }}"]));
                $(row).children(".tbl-image_path").html(surveyService.addImageSurvey(data));
                $(row).addClass(surveyService.changeColorRowDownloadList(row,'{{ trans('adminlte_lang::survey.status_deleted') }}'));
            },
            "columnDefs": [
                { "targets": 3, "width": "400px"},
                { "targets": 4, "orderable" : false},
                { "targets": 8,"orderable" : false, "width": "50px"},
            ],
            "language": {
                "url" : "/setup-lang"
            },
            "drawCallback": function(settings) {
                var pagination = $(this).closest('.dataTables_wrapper').find('.dataTables_paginate');
                pagination.toggle(this.api().page.info().pages > 1);
            }
        });
    });

    surveyService.showTrTagAfterLoadCompletedData();
</script>