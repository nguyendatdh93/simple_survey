<script>
    $(function () {
        $('#users-table').DataTable({
            'paging'      : true,
            'lengthChange': false,
            'searching'   : false,
            'ordering'    : true,
            'info'        : true,
            'autoWidth'   : false,
            "columnDefs": [
                { "orderable": false, "targets": 0, "visible" : false },
                { "orderable": true, "targets": 1 },
                { "orderable": false, "targets": 2 },
            ],
        });
    });

</script>