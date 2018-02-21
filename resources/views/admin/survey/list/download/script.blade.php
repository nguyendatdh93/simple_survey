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
                $(row).children(".tbl-note").html(surveyService.setWitdthColumn(row, 'tbl-note', '250px',''));
                $(row).children(".tbl-name").html(surveyService.setWitdthColumn(row, 'tbl-name', '300px',''));
                $(row).children(".tbl-control").html(surveyService.setWitdthColumn(row, 'tbl-control', '', '50px'));
            },
            "columnDefs": [
                { "searchable": false, "targets": 0 },
                { "searchable": false, "targets": 1 },
                { "searchable": false, "targets": 4, "orderable" : false },
                { "searchable": false, "targets": 5 },
                { "searchable": false, "targets": 6 },
                { "searchable": false, "targets": 7 },
                { "targets": 8,"orderable" : false},
            ],
            "language": {
                "url" : "/setup-lang"
            },
            "drawCallback": function(settings) {
                var pagination = $(this).closest('.dataTables_wrapper').find('.dataTables_paginate');
                pagination.toggle(this.api().page.info().pages > 1);
            },
            "initComplete": function(settings, json) {
                $('.dataTables_filter').find('label').contents().first().replaceWith('{{ trans('adminlte_lang::survey.search_by') }}');
                $('.tbl-name div').css('max-width', $('.tbl-name').width());
            }
        });
    });

    surveyService.showTrTagAfterLoadCompletedData();
</script>