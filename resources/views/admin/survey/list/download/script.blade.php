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
                $(row).addClass(surveyService.changeColorRowDownloadList(row));
            },
            "columnDefs": [
                {
                    targets: 2,
                    render: function (data, type, full, meta) {
                        return surveyService.cutLineText(data,['{{ trans('adminlte_lang::survey.button_more') }}' , '{{ trans('adminlte_lang::survey.button_less') }}']);
                    }
                },
                { "targets": 3, "orderable" : false},
                { "targets": 4, "orderable" : true},
                { "targets": 5, "orderable" : true},
                { "targets": 6, "orderable" : true},
                { "targets": 7,"orderable" : false, "width": "50px"},
            ],
            "language": {
                "url" : "/setup-lang"
            }
        });
    });

    surveyService.showTrTagAfterLoadCompletedData();
</script>