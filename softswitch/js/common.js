/**
 * Created by Mazhar on 10/2/2014.
 */
$('document').ready(function () {

    /*
     * Global verible for getting web content
     */
    CMS_CATEGORY_URL = cms_service_url['cms_service_host'] + "CMSWebService/getCMSCategoryList.php";
    CMS_CONTENT_URL = cms_service_url['cms_service_host'] + "CMSWebService/getCMSContentList.php";

    /*
     * function initCMS
     * source : cmscore.js
     * input : a call back function
     */
      $.ajaxSetup({timeout: 20000000});
      initCMS("onCMSDataReceived");
     
   
});


/*
 * Base call function
 * */
function onCMSDataReceived() {
    //load catagory
    loadCMSCategory("1", "#cmsData");

    var layout_var = new Object();
    layout_var.header_location = '.header';
    layout_var.footer_location = 'footer';
    layout_var.auth_menu_location = '.header';

    var auth_session_data = checkSession('cms_auth');
    if (auth_session_data != null) {
        var auth_data = JSON.parse(auth_session_data);

        if (parseInt(auth_data.layoutId) > 0) {
            var layoutId = 8;
            cms_service_url['get_header_footer'] = cms_service_url['cms_service_host'] + 'CMSWebService/getHeaderFooter.php?layoutid=' + layoutId;
        }
    }
    processLayout(layout_var);

    //display content
    defaultViewController();

   // $('.graph-content').loadDashboardGraph();
}


/* =========================================================
 * Created by Mazhar on 10/25/2014.
 *
 * generic call ajax
 *
 * @param dataInfo can be array declare
 *  like:- var dataInfo = {}
 *         dataInfo['matha'] = 'matha';
 * ========================================================= */
function connectServer(fetchURL, dataInfo, asyncFlag) {

    var returnValue;
    if (asyncFlag == undefined) {
        asyncFlag = false;
    }

    $.ajax({
        type: 'POST',
        url: fetchURL,
        async: asyncFlag,
        data: {'info': dataInfo},
        success: function (value) {
            returnValue = value;
        },
        error: function (jqXHR, textStatus, errorThrown) {
            genericError(jqXHR, textStatus, errorThrown);
        }
    });
    return returnValue;
}

/* =========================================================
 * Created by Mazhar on 10/25/2014.
 *
 * generic call ajax
 * ========================================================= */
function connectServerWithForm(fetchURL, formId) {
    var returnValue;
    var formData = new FormData(document.getElementById(formId));

    $.ajax({
        type: "POST",
        url: fetchURL,
        async: false,
        data: formData,
        success: function (value) {
            returnValue = value;
        },
        error: function (jqXHR, textStatus, errorThrown) {
            genericError(jqXHR, textStatus, errorThrown);
        },
        processData: false,  // tell jQuery not to process the data
        contentType: false   // tell jQuery not to set contentType
    });
    return returnValue;
}

/* =========================================================
 * Created by Talemul on 03/29/2015.
 *
 * generic call ajax
 * ========================================================= */
function connectServerWithFileUpload(fetchURL, formId) {
    var returnValue;
    var formData = new FormData(document.getElementById(formId));
    $.ajax({
        url: fetchURL,  //server script to process data
        type: 'POST',
        success: function (data) {
            returnValue = data;

        },
        error: function (jqXHR, textStatus, errorThrown) {
            genericError(jqXHR, textStatus, errorThrown)
        },
        // Form data
        data: formData,
        //Options to tell JQuery not to process data or worry about content-type
        cache: false,
        async: false,
        contentType: false,
        processData: false
    });
    return returnValue;
}
/* =========================================================
 * Created by Talemul.
 *
 * gets formatted user local time
 * ========================================================= */
function return_local_time() {

    var currentDate = new Date();
    var day = currentDate.getDate();
    var month = currentDate.getMonth() + 1;
    var year = currentDate.getFullYear();
    var curHour = currentDate.getHours();
    var curMinute = currentDate.getMinutes();
    var curSeconds = currentDate.getSeconds();
    return year + "-" + month + "-" + day + " " + curHour + ":" + curMinute + ":" + curSeconds;
    //  2015-01-10 18:30:25
}

/* =========================================================
 * Created by Talemul.
 *
 * gets user local timezone
 *
 * @return minutes
 * ========================================================= */
function local_time_zone() {
    var d = new Date();
    var n = d.getTimezoneOffset();//time zone in minute
    n = parseInt(n);
    n = n * (-1);
    return n;
}


/*============================ show message alert message==================================
 *if its a error message then call call message_alert(message,'red')
 * or call message_alert(message,'error')
 * if success call message_alert(message,'green')
 * or message_alert(message,'success')
 *============================================================================================ */

function message_alert(message, alert_type) {

    var color_type = '#009900';

    if (alert_type != undefined) {
        alert_type = alert_type.toLowerCase();
        if (alert_type == 'red' || alert_type == 'error') {
            var color_type = '#FF0000';
        }
    }

    var all_message = '<div class="panel panel-default"><h4 style="text-align: left; font-weight: bold; padding-left: .5em; color:' + color_type + ';" content_id="11">' + message + '</h4></div>';
    $('#message_display').html(all_message);
}

function message_clear() {
    $('#message_display').html('');
}

function getBalance(){
    $.post(cms_url['dhakagate_get_balance'], function(response){
        updateDashboardInfo(response)
       // return response;
    });
}

/*===============================data picker function ===========================================
* to use this data picker just call the function with id
* ===============================================================================================*/


function softswitch_DatePicker(input_id) {
    //alert('enter here');
    input_id='#'+input_id;
    $(input_id).datepicker({
        format: "yyyy-mm-dd",
        todayBtn: "linked",
        keyboardNavigation: false,
        autoclose: true,
        todayHighlight: true
    });
}

function softswitch_DateTimePicker(input_id){
                
                input_id = '#'+input_id;
                $(input_id).datetimepicker();
                                
}


/*****
 Important function
 */

function display_content_custom(id, target) {

    var cmsContentData = localStorage.cmsContent;

    if (cmsContentData != null) {
        var cmsContentData = JSON.parse(cmsContentData);
        for (i = 0; i < cmsContentData.length; i++)
        {
            if (cmsContentData[i].id == cmsContentData[i].cid && cmsContentData[i].cid == id) {
                cmsContentData[i].details=cmsContentData[i].details.replace(/\\/g,'');
                $(target).html(cmsContentData[i].details);
                return true;
            }

        }
    }
}
/* default menu */

    function default_menu () {
        $('ul.dropdown-menu [data-toggle=dropdown]').on('click', function (event) {
            event.preventDefault();
            event.stopPropagation();
            $(this).parent().siblings().removeClass('open');
            $(this).parent().toggleClass('open');
        });
    }
/*
*
* datatable responsive plugin
 * just call this function after prepare table content
* */


function data_table_responsive(){
    var switched = false;
    var updateTables = function() {
        if (($(window).width() < 767) && !switched ){
            switched = true;
            $("table.responsive").each(function(i, element) {
                splitTable($(element));
            });
            return true;
        }
        else if (switched && ($(window).width() > 767)) {
            switched = false;
            $("table.responsive").each(function(i, element) {
                unsplitTable($(element));
            });
        }
    };

    $(window).load(updateTables);
    $(window).on("redraw",function(){switched=false;updateTables();}); // An event to listen for
    $(window).on("resize", updateTables);


    function splitTable(original)
    {
        original.wrap("<div class='table-wrapper' />");

        var copy = original.clone();
        copy.find("td:not(:first-child), th:not(:first-child)").css("display", "none");
        copy.removeClass("responsive");

        original.closest(".table-wrapper").append(copy);
        copy.wrap("<div class='pinned' />");
        original.wrap("<div class='scrollable' />");

        setCellHeights(original, copy);
    }

    function unsplitTable(original) {
        original.closest(".table-wrapper").find(".pinned").remove();
        original.unwrap();
        original.unwrap();
    }

    function setCellHeights(original, copy) {
        var tr = original.find('tr'),
            tr_copy = copy.find('tr'),
            heights = [];

        tr.each(function (index) {
            var self = $(this),
                tx = self.find('th, td');

            tx.each(function () {
                var height = $(this).outerHeight(true);
                heights[index] = heights[index] || 0;
                if (height > heights[index]) heights[index] = height;
            });

        });

        tr_copy.each(function (index) {
            $(this).height(heights[index]);
        });
    }
}


/**
 * IP address, Net Mask
 * And Gateway Validation
 */
function IPAddressOnly(val,type){
    val = typeof val !== 'undefined' ? val : "";
    type = typeof type !== 'undefined' ? type : "ip";
    var val_arr = val.split(".");
    if( val_arr.length != 4 ||
        (parseInt(val_arr[0])< 1 || parseInt(val_arr[0]) > 255) ||
        (parseInt(val_arr[1])< 0 || parseInt(val_arr[1]) > 255) ||
        (parseInt(val_arr[2])< 0 || parseInt(val_arr[2]) > 255) ||
        (type == "g" && (parseInt(val_arr[3]) < 1 || parseInt(val_arr[3]) > 254)) ||
        (type == "ip" && (parseInt(val_arr[3]) < 0 || parseInt(val_arr[3]) > 255))
    ){
        alertMessage(this,'yellow','',"Wrong IP address " + val);
        return false;
    }
    return true;
}

/**
 * Mac address
 * And HD Ethernet Validation
 */

function MACAddressOnly(val){
    val = typeof val !== 'undefined' ? val : "";
    var mac_format = /^([0-9a-fA-F]{2}[:-]){5}([0-9a-fA-F]{2})$/;

    if(mac_format.test(val)==false){
        alert("Wrong MAC or Ethernet address "+val);
        return false;
    }
    return true;
}




/*
 inputarray is a two dimentional array ;

 inputarray[][0]= tab name;
 inputarray[][1]= menu lebel name;
 inputarray[][2]= active/deactive; only one index should be active.

 tarhgetName is optional and is the div id where tab should be seen
 */
function tab_custom(inputarray, tarhgetName) {

    var flag = 0;
    var i = 0, len = inputarray.length;
    var html_string = "";
    var tarhgetName = typeof tarhgetName !== 'undefined' ? tarhgetName : "tab_view";
    var tab_active_custom = 'tab_active_custom';
    var tab_deactive_custom = 'tab_deactive_custom';
    if (len < 4) {
        len = 3;
    } else if (len < 7) {
        len = 2;
        tab_active_custom='tab_active_custom_m';
        tab_deactive_custom='tab_deactive_custom_m';
    } else {
        len = 1;
        tab_deactive_custom='tab_deactive_custom_s';
        tab_active_custom='tab_active_custom_s';
    }

    for (i = 0; i < inputarray.length; i++) {
        if (inputarray[i][2] == "active" && flag == 0) {
            flag = 1;
            html_string += "<div class=\"col-md-" + len + " " + tab_active_custom + "\" onclick=\"showUserMenu('" + inputarray[i][1] + "');\">" + inputarray[i][0] + "</div>";
        } else {
            html_string += "<div class=\"col-md-" + len + " " + tab_deactive_custom + "\" onclick=\"showUserMenu('" + inputarray[i][1] + "');\">" + inputarray[i][0] + "</div>";

        }
    }

    $('#' + tarhgetName).html(html_string);
}