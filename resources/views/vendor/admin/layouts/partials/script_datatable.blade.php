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
                { "orderable": true, "targets": 2 },
                { "orderable": false, "targets": 3 },
            ],
        });
    });

</script>