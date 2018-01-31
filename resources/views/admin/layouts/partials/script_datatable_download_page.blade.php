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
    $(function () {
        $('#download-page-table').DataTable({
            'paging'      : true,
            'lengthChange': true,
            'searching'   : true,
            'ordering'    : true,
            'info'        : true,
            'autoWidth'   : true,
            "columnDefs": [
                { "targets": 0, "visible" : false },
                {
                    targets: '_all',
                    render: function (data, type, full, meta) {
                        return cutLineText(data);
                    }
                }
            ],
            "language": {
                "url" : "/setup-lang"
            }
        });

        function cutLineText(data)
        {
            if(data.length < 100)
                return data;

            var html = data.slice(0,100) + '<span>... </span><a href="#" class="more">{{ trans('adminlte_lang::survey.button_more') }}</a>'+
                '<span style="display:none;">'+ data.slice(100,data.length)+'<br><a href="#" class="less">{{ trans('adminlte_lang::survey.button_less') }}</a></span>'
            ;

            return html;
        }

        $('a.more').click(function(event){
            event.preventDefault();
            $(this).hide().prev().hide();
            $(this).next().show();
        });

        $('a.less').click(function(event){
            event.preventDefault();
            $(this).parent().hide().prev().show().prev().show();
        });

        $(".jsButtonDownload").click(function () {
            var survey_status = '{{ $survey_status }}';
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

<style>
    table#download-page-table {
        display: block;
        overflow-x: auto;
    }
    table#download-page-table th {
        white-space: nowrap;
    }
</style>