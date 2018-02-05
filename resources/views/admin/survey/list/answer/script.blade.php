{!! FormSimple::modalConfirm(array(
             'id'      => 'modal-confirm-clear-data-survey',
             'title'   => trans('adminlte_lang::survey.confirm_clear_data_title'),
             'content' => trans('adminlte_lang::survey.confirm_clear_data_content'),
             'buttons' => array(
                array(
                    'text'  => trans('adminlte_lang::survey.confirm_button_cancel'),
                    'attributes' => array(
                        'class'        => 'btn btn-danger',
                        'data-dismiss' => "modal",
                        'aria-label'   => "Close",
                    )
                ),
                array(
                    'text'  => trans('adminlte_lang::survey.confirm_button_clear_data'),
                    'href'  => route(\App\Survey::NAME_URL_CLEAR_DATA_SURVEY).'/'. (isset($survey_id) ? $survey_id : ''),
                    'attributes' => array(
                        'class' => 'btn btn-success',
                    )
                )
             )
        )) !!}
<script>
    var surveyService = new SurveyService();

    $(function () {
        $('#download-page-table').DataTable({
            'paging'      : true,
            'lengthChange': true,
            'searching'   : true,
            'ordering'    : true,
            'info'        : true,
            'lengthMenu'  : [ {!! implode(',', \App\BaseWidget\Form::SETTING_LENGHT_MENU_DATATABLE)  !!}],
            'autoWidth'   : true,
            "columnDefs": [
                {
                    targets: '_all',
                    render: function (data, type, full, meta) {
                        return surveyService.cutLineText(data,['{{ trans('adminlte_lang::survey.button_more') }}' , '{{ trans('adminlte_lang::survey.button_less') }}']);
                    }
                }
            ],
            "language": {
                "url" : "/setup-lang"
            }
        });

        $(".jsButtonDownload").click(function () {
            var survey_status = '{{ isset($survey_status) ? $survey_status : -1 }}';
            if ($('.jsButtonClearData').length == 0 && survey_status == '{{ \App\Models\Survey::STATUS_SURVEY_CLOSED }}') {
                timer();
            }
        });

        var flgRefreshPage = false;
        function timer() {
            var downloadTimer = window.setInterval(function () {
                var token = getTokenDownload();
                if (token) {
                    window.clearInterval(downloadTimer);
                    flgRefreshPage = true;
                }
            }, 1000);
        }

        function getTokenDownload() {
            var tokenDownload = '{{ Session::get('tokenDownload') }}';

            return tokenDownload;
        }

        var stopMouseMove = false;
        $('body').mousemove(function () {
            if (stopMouseMove == false) {
                if (flgRefreshPage == true) {
                    location.reload();
                    stopMouseMove = true;
                }
            }
        });
    });

</script>