$(function () {
    function DatatableService() {

    }

    DatatableService.prototype.buttonForStatus = function(data) {
        var html            = '',
            class_button_status = '';

        if(data.indexOf("{{ trans('adminlte_lang::survey.draf') }}") >= 0) {
            class_button_status = "btn-default";
        } else if(data.indexOf("{{ trans('adminlte_lang::survey.published') }}") >= 0) {
            class_button_status = "btn-info";
        } else {
            class_button_status = "btn-warning";
        }

        html += '<button type="button" class="btn btn-block '+ class_button_status +' btn-xs">'+data[1]+'</button>';

        return html;
    }
});