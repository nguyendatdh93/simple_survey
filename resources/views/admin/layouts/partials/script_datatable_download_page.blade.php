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