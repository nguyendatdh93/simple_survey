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
                $(row).children(".tbl-status").html(surveyService.addButtonForStatus(data, ["{{ trans('adminlte_lang::survey.draf') }}", "{{ trans('adminlte_lang::survey.published') }}"]));
                $(row).children(".tbl-image_path").html(surveyService.addImageSurvey(data));
            },
            "columnDefs": [
                {
                    targets: 2,
                    {{--render: function (data, type, full, meta) {--}}
                        {{--return surveyService.cutLineText(data,['{{ trans('adminlte_lang::survey.button_more') }}' , '{{ trans('adminlte_lang::survey.button_less') }}']);--}}
                    {{--}--}}
                },
                { "targets": 3, "orderable" : false},
                { "targets": 4, "orderable" : true},
                { "targets": 5, "orderable" : true},
                { "targets": 6, "orderable" : true},
                { "targets": 7,"orderable" : false, "width": "95px"},
            ],
            "language": {
                "url" : "/setup-lang"
            }
        });
    });

    surveyService.showTrTagAfterLoadCompletedData();

</script>