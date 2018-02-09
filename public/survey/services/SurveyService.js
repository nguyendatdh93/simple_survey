function SurveyService() {
}

var surveyService = new SurveyService();
SurveyService.prototype.showTrTagAfterLoadCompletedData = function() {
    $(document).on('change', '.dataTables_length select', function () {
        $('tr').show();
        setMaxWidthColumnTable();
    }).on('keyup', 'div.dataTables_filter :input', function () {
        $('tr').show();
        setMaxWidthColumnTable();
    }).on('click', '.paginate_button', function () {
        $('tr').show();
        setMaxWidthColumnTable();
    }).on('click', 'table th', function () {
        $('tr').show();
        setMaxWidthColumnTable();
    });
};

function setMaxWidthColumnTable() {
    $('.tbl-name div').css('max-width', $('.tbl-name').width());
    $('.tbl-note div').css('max-width', $('.tbl-note').width());
}

SurveyService.prototype.addImageSurvey = function(data) {
    var html = '<div style="min-height: 35px;">';

    if ($(data[4]).html() != '')
    {
        html += '<img style="height: 35px;" src="'+$(data[4]).html()+'" alt="Image" />';
    }

    html += '</div>';

    return html;
};

SurveyService.prototype.addButtonForStatus = function(data, status) {
    var html                = '',
        class_button_status = '';

    if(data.indexOf(status[0]) >= 0) {
        class_button_status = "label-info";
    } else if(data.indexOf(status[1]) >= 0) {
        class_button_status = "label-warning";
    } else {
        class_button_status = "label-default";
    }

    // html += '<button type="button" class="btn '+ class_button_status +' btn-xs">'+data[1]+'</button>';
    html += '<span class="label '+ class_button_status +'">'+data[1]+'</span>';

    return html;
};

SurveyService.prototype.cutLineText = function(data, texts) {
    if(data.length < 100)
        return data;

    var html = data.slice(0,100) + '<span class="jsMoreText" >... </span><br/><a href="#" class="more">'+ texts[0] + '</a>'+
    '<span style="display:none;">'+ data.slice(100,data.length)+'<br><a href="#" class="less"> '+ texts[1] +' </a></span>'
    ;

    return html;
};


SurveyService.prototype.setMaxWitdthForSurveyName = function(row) {
    var survey_name = row.querySelectorAll( ".tbl-name" )[0].innerHTML;

    survey_name = '<div style="max-width: 300px">'+ survey_name +'</div>'

    return survey_name;
};

SurveyService.prototype.setMaxWitdthForSurveyNote = function(row) {
    var survey_note = row.querySelectorAll( ".tbl-note" )[0].innerHTML;

    survey_note = '<div style="max-width: 250px">'+ survey_note +'</div>'

    return survey_note;
};

SurveyService.prototype.addControlsForDownloadList = function(row, data, router, names) {
    var html                = '',
        url_redirect_detail = '';

    if (row.querySelectorAll( ".tbl-number_answers" )[0].innerText.trim() != '-') {
        url_redirect_detail = router[0] + "/" + data[0];

        html += '<a href="'+ url_redirect_detail +'" class="btn btn-default bg-olive jsbtn-controll" data-toggle="tooltip" title="'+ names[0] +'"><i class="glyphicon glyphicon-download-alt"></i></a>';
    }

    return html;
};

SurveyService.prototype.addControlsForSurveyList = function(data, routers, names) {
    var html = '',
        url_redirect_copy = '',
        url_edit_survey   = '';

    if(data.indexOf(names['draf']) >= 0) {
        url_edit_survey = routers['edit'] + "/" + data[0];
    } else if(data.indexOf(names['published']) >= 0) {
        url_edit_survey = routers['edit'] + "/" + data[0];
    }

    url_redirect_copy = routers['duplicate'] + "/" + data[0];

    html += '<a href="'+ url_redirect_copy +'" class="btn btn-default jsbtn-controll" style="margin-left: 5px" data-toggle="tooltip" title="'+ names['copy'] +'"><i class="glyphicon glyphicon-duplicate"></i></a>';
    if(data.indexOf(names['draf']) >= 0 || data.indexOf(names['published']) >= 0) {
        html += '<a href="'+ url_edit_survey +'" class="btn btn-default jsbtn-controll" data-toggle="tooltip" style="margin-left: 5px" title="'+ names['edit'] +'"><i class="glyphicon glyphicon-edit"></i></a>';
    }

    return html;
};

SurveyService.prototype.changeColorRowDownloadList = function(row, name) {
    if (row.querySelectorAll( ".tbl-number_answers" )[0].innerText.trim() == '-') {
        surveyService.changeStatusSurveyToCleared(row, name);

        return "row-deleted";
    }

    return '';
}

SurveyService.prototype.changeStatusSurveyToCleared = function(row, name) {
    row.querySelectorAll( ".tbl-status" )[0].querySelectorAll('span')[0].innerText = name;
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


