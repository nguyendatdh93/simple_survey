<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
        $('#survey-table').DataTable({
            'paging'      : true,
            "order": [[ 0, "desc" ]],
            'searching'   : true,
            'ordering'    : true,
            'autoWidth'   : true,
            'lengthMenu'  : [ {!! implode(',', \App\BaseWidget\Form::SETTING_LENGHT_MENU_DATATABLE)  !!}],
            'createdRow' : function( row, data, dataIndex ) {
                $(row).children(".tbl-control").html(addControls(row,data));
                $(row).children(".tbl-status").html(buttonForStatus(data));
                $(row).children(".tbl-image_path").html(addImageSurvey(data));
            },
            "columnDefs": [
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

        function addControls(row,data)
        {
            var html            = '',
            url_redirect_detail = '',
            url_redirect_copy   = '',
            url_edit_survey     = '';

            if(data.indexOf("{{ trans('adminlte_lang::survey.draf') }}") >= 0) {
                url_redirect_detail = "{{ route(\App\Survey::NAME_URL_PREVIEW) }}/"+ data[0];
                url_edit_survey = "{{ route(\App\Survey::NAME_URL_EDIT_SURVEY) }}/"+ data[0];
            } else if(data.indexOf("{{ trans('adminlte_lang::survey.published') }}") >= 0) {
                url_redirect_detail = "{{ route(\App\Survey::NAME_URL_PREVIEW) }}/"+ data[0];
                url_edit_survey = "{{ route(\App\Survey::NAME_URL_EDIT_SURVEY) }}/"+ data[0];
            } else {
                url_redirect_detail = "{{ route(\App\Survey::NAME_URL_PREVIEW) }}/"+ data[0];
            }

            url_redirect_copy   = "{{ route(\App\Survey::NAME_URL_DUPLICATE_SURVEY) }}/"+ data[0];

            html += '<a href="'+ url_redirect_detail +'" class="btn btn-default jsbtn-controll" data-toggle="tooltip" target="_blank" title="{{ trans('adminlte_lang::survey.detail') }}"><i class="glyphicon glyphicon-eye-open"></i></a>';
            html += '<a href="'+ url_redirect_copy +'" class="btn btn-default jsbtn-controll" style="margin-left: 5px" data-toggle="tooltip" title="{{ trans('adminlte_lang::survey.copy_survey') }}"><i class="glyphicon glyphicon-duplicate"></i></a>';
            if(data.indexOf("{{ trans('adminlte_lang::survey.draf') }}") >= 0 || data.indexOf("{{ trans('adminlte_lang::survey.published') }}") >= 0) {
                html += '<a href="'+ url_edit_survey +'" class="btn btn-default jsbtn-controll" data-toggle="tooltip" style="margin-left: 5px" title="{{ trans('adminlte_lang::survey.edit_survey') }}"><i class="glyphicon glyphicon-edit"></i></a>';
            }

            return html;
        }

        function addImageSurvey(data)
        {
            var html            = '';

            if ($(data[3]).html() != '')
            {
                html += '<img style="height: 35px;" src="'+$(data[3]).html()+'" alt="Image"></img>';
            }

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

    $(document).ready(function() {
        $('tr').show();
    });

</script>

<style>
    #survey-table tr td:not(.tbl-name) {
        text-align: center;
    }

    #survey-table td.tbl-control {
        text-align: unset !important;
    }
</style>