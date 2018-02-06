function SurveyService() {
}

SurveyService.prototype.showTrTagAfterLoadCompletedData = function() {
    $(document).on('change', '.dataTables_length select', function () {
        $('tr').show();
    }).on('keyup', 'div.dataTables_filter :input', function () {
        $('tr').show();
    }).on('click', '.paginate_button', function () {
        $('tr').show();
    });
}

SurveyService.prototype.addImageSurvey = function(data) {
    var html = '<div style="min-height: 35px;">';

    if ($(data[3]).html() != '')
    {
        html += '<img style="height: 35px;" src="'+$(data[3]).html()+'" alt="Image" />';
    }

    html += '</div>';

    return html;
}

SurveyService.prototype.addButtonForStatus = function(data, status) {
    var html                = '',
        class_button_status = '';

    if(data.indexOf(status[0]) >= 0) {
        class_button_status = "btn-info";
    } else if(data.indexOf(status[1]) >= 0) {
        class_button_status = "btn-warning";
    } else {
        class_button_status = "btn-default";
    }

    html += '<button type="button" class="btn '+ class_button_status +' btn-xs">'+data[1]+'</button>';

    return html;
}

SurveyService.prototype.cutLineText = function(data, texts) {
    if(data.length < 100)
        return data;

    var html = data.slice(0,100) + '<span class="jsMoreText" >... </span><br/><a href="#" class="more">'+ texts[0] + '</a>'+
    '<span style="display:none;">'+ data.slice(100,data.length)+'<br><a href="#" class="less"> '+ texts[1] +' </a></span>'
    ;

    return html;
}


SurveyService.prototype.addControlsForDownloadList = function(row, data, router, names) {
    var html                = '',
        url_redirect_detail = '';

    if (row.querySelectorAll( ".tbl-number_answers" )[0].innerText.trim() != '-') {
        url_redirect_detail = router[0] + "/" + data[0];

        html += '<a href="'+ url_redirect_detail +'" class="btn btn-default bg-olive jsbtn-controll" data-toggle="tooltip" title="'+ names[0] +'"><i class="glyphicon glyphicon-download-alt"></i></a>';
    }

    return html;
}

SurveyService.prototype.addControlsForSurveyList = function(data, routers, names) {
    var html            = '',
        url_redirect_detail = '',
        url_redirect_copy   = '',
        url_edit_survey     = '';

    if(data.indexOf(names['draf']) >= 0) {
        url_redirect_detail = routers['preview'] + "/" + data[0];
        url_edit_survey = routers['edit'] + "/" + data[0];
    } else if(data.indexOf(names['published']) >= 0) {
        url_redirect_detail = routers['preview'] + "/" + data[0];
        url_edit_survey = routers['edit'] + "/" + data[0];
    } else {
        url_redirect_detail =  routers['preview'] + "/" + data[0];
    }

    url_redirect_copy = routers['duplicate'] + "/" + data[0];

    html += '<a href="'+ url_redirect_detail +'" class="btn btn-default jsbtn-controll" data-toggle="tooltip" target="_blank" title="'+ names['detail'] +'"><i class="glyphicon glyphicon-eye-open"></i></a>';
    html += '<a href="'+ url_redirect_copy +'" class="btn btn-default jsbtn-controll" style="margin-left: 5px" data-toggle="tooltip" title="'+ names['copy'] +'"><i class="glyphicon glyphicon-duplicate"></i></a>';
    if(data.indexOf(names['draf']) >= 0 || data.indexOf(names['published']) >= 0) {
        html += '<a href="'+ url_edit_survey +'" class="btn btn-default jsbtn-controll" data-toggle="tooltip" style="margin-left: 5px" title="'+ names['edit'] +'"><i class="glyphicon glyphicon-edit"></i></a>';
    }

    return html;
}

SurveyService.prototype.changeColorRowDownloadList = function(row) {
    if (row.querySelectorAll( ".tbl-number_answers" )[0].innerText.trim() == '-') {
        return "row-deleted";
    }

    return '';
}

$(document).on('click', 'a.more' , function(event){
    event.preventDefault();
    $('.jsMoreText').hide();
    $(this).hide().prev().hide();
    $(this).next().show();
});

$(document).on('click', 'a.less' , function(event){
    event.preventDefault();
    $('.jsMoreText').show();
    $(this).parent().hide().prev().show().prev().show();
});


