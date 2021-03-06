<script>
    var surveyService = new SurveyService();
    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
        var routers = {
            edit      : "{{ route(\App\Survey::NAME_URL_EDIT_SURVEY) }}",
            preview   : "{{ route(\App\Survey::NAME_URL_PREVIEW) }}",
            duplicate : "{{ route(\App\Survey::NAME_URL_DUPLICATE_SURVEY) }}"
        };

        var names = {
            draf      : "{{ trans('adminlte_lang::survey.draf') }}",
            published : "{{ trans('adminlte_lang::survey.published') }}",
            detail    : "{{ trans('adminlte_lang::survey.detail') }}",
            copy      : "{{ trans('adminlte_lang::survey.copy_survey') }}",
            edit      : "{{ trans('adminlte_lang::survey.edit_survey') }}",
        };

        $('#survey-table').DataTable({
            'paging'      : true,
            "order": [[ 0, "desc" ]],
            'searching'   : true,
            'ordering'    : true,
            'autoWidth'   : true,
            'lengthMenu'  : [ {!! implode(',', \App\BaseWidget\Form::SETTING_LENGHT_MENU_DATATABLE)  !!}],
            'createdRow' : function( row, data, dataIndex ) {
                $(row).children(".tbl-control").html(surveyService.addControlsForSurveyList(data, routers, names));
                $(row).children(".tbl-status").html(surveyService.addButtonForStatus(data, ["{{ trans('adminlte_lang::survey.draf') }}", "{{ trans('adminlte_lang::survey.published') }}", "{{ trans('adminlte_lang::survey.status_deleted') }}"]));
                $(row).children(".tbl-image_path").html(surveyService.addImageSurvey(data));
                $(row).children(".tbl-note").html(surveyService.setWitdthColumn(row, 'tbl-note', '250px',''));
                $(row).children(".tbl-name").html(surveyService.setWitdthColumn(row, 'tbl-name', '300px',''));
                $(row).children(".tbl-control").html(surveyService.setWitdthColumn(row, 'tbl-control', '', '50px'));
            },
            "columnDefs": [
                { "searchable": false, "targets": 0 },
                { "searchable": false, "targets": 1 },
//                { "targets": 3, "width": "400px"},
                { "searchable": false, "targets": 4, "orderable" : false },
                { "searchable": false, "targets": 5 },
                { "searchable": false, "targets": 6 },
                { "searchable": false, "targets": 7 },
                { "targets": 8, "orderable" : false},
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
                $('.tbl-note div').css('max-width', $('.tbl-note').width());
            }
        });
    });

    surveyService.showTrTagAfterLoadCompletedData();
</script>