<!-- REQUIRED JS SCRIPTS -->

<!-- JQuery and bootstrap are required by Laravel 5.3 in resources/assets/js/bootstrap.js-->
<!-- Laravel App -->
<script src="{{ url (mix('/js/app.js')) }}" type="text/javascript"></script>

<!-- bootstrap datepicker -->
<script src="{{ url ('/assets/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
<script src="{{ url ('/assets/iCheck/icheck.min.js') }}" type="text/javascript"></script>
<!-- DataTables -->
<script src="{{ url ('/assets/datatables.net/js/jquery.dataTables.min.js') }}" type="text/javascript"></script>
<script src="{{ url ('/assets/datatables.net-bs/js/dataTables.bootstrap.min.js') }}" type="text/javascript"></script>
{{--<script src="../../bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>--}}

<!-- CK Editor -->
<script src="{{ url ('/assets/ckeditor/ckeditor.js') }}"></script>
<!-- Optionally, you can add Slimscroll and FastClick plugins.
      Both of these plugins are recommended to enhance the
      user experience. Slimscroll is required when using the
      fixed layout. -->
<script>
    $(function () {
        //Date picker
        $('.datepicker').datepicker({
            autoclose: true
        })

        //iCheck for checkbox and radio inputs
        $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
            checkboxClass: 'icheckbox_minimal-blue',
            radioClass   : 'iradio_minimal-blue'
        })

        $('#base-table').DataTable({
            'paging'      : true,
            'lengthChange': false,
            'searching'   : false,
            'ordering'    : true,
            'info'        : true,
            'autoWidth'   : false,
            "columnDefs": [
                { "orderable": false, "targets": 0 },
                { "orderable": true, "targets": 1 },
                { "orderable": false, "targets": 2 },
            ],
        });

        if($("[id*='ckeditor']").length > 0) {
            var id_ckeditor = $("[id*='ckeditor']").attr('id');
            CKEDITOR.replace(id_ckeditor)
        }
    });

</script>