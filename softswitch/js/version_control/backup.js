/**
 * Created by Monir
 */


/* =====================================================
 * Table Initialize
 * =====================================================*/

function table_initialize_backup_history() {

    $('#tbl_view_table').html('<table class="table table-striped table-bordered table-hover responsive bootstrap-datatable datatable" id="dataTables_rcportal_backup_history" width="100%"><tr><td  align="center"><img src="rcportal/img/31.gif"></td></tr></table>');

}

function report_menu_start_backup_history() {
//alert();
    var dataSet = [[]];
    var dataInfo = {};
    //dataInfo['uid'] = 'test@test.com';
    dataSet = connectServer(cms_url['rcportal_backup_history'], dataInfo);
    //alert(dataSet);
    dataSet = JSON.parse(dataSet);
    //alert(dataSet);
    table_data_backup_history(dataSet);
    data_table_responsive();
}


function table_data_backup_history(dataSet) {
    $('#dataTables_rcportal_backup_history').dataTable({
        "data": dataSet,
        "columns": [
            {"title": "Name", "class": "center"},
            {"title": "Version", "class": "center"},
            {"title": "Options", "class": "center"},
            {"title": "Time", "class": "center"},
            {"title": "User", "class": "center"},
            {"title": "Action", "class": "center"}
        ],
        "order": [[0, "asc"]],
        dom: 'T<"clear">lfrtip',
        tableTools: {
            "sSwfPath": "rcportal/img/datatable/swf/copy_csv_xls_pdf.swf",
            "sRowSelect": "multi",
            "aButtons": [
                "copy", "csv",
                {
                    "sExtends": "xls",
                    "sFileName": "*.xls"
                }
            ],
            "filter": "applied"
        }
    });
}




/* =====================================================
 * edit function. for read all row
 * =====================================================*/
function restore_backup(obj, action_id) {
    var dataInfo = {}
    dataInfo['action'] = 'restore';
    dataInfo['action_id'] = action_id;
    var response = connectServer(cms_url['rcportal_backup_restore'], dataInfo);
    if (response.trim() == '0' || response == 0) {
        alertMessage(this, 'green', '', 'Successfully Restored.');
    } else {
        alertMessage(this, 'red', '', 'Failed.');
    }
}



/*============== delete operation===========================
 * delete
 * =========================================================*/

function delete_backup_history(obj, action_id) {
    var dataInfo = {}
    dataInfo['action'] = 'delete';
    dataInfo['action_id'] = action_id;

    alert("Delete Backup# " + action_id + "?");
//    var response = connectServer(cms_url['rcportal_backup_delete'], dataInfo);
//    if (response.trim() == '0' || response == 0) {
//        alertMessage(this, 'green', '', 'Successfully Deleted.');
//    } else {
//        alertMessage(this, 'red', '', 'Failed.');
//    }
}


function backup_controller() {
    var auth_session_data = checkSession('cms_auth');
    var auth_data = JSON.parse(auth_session_data);

    var username = auth_data.UserID;


    var action = $('#action').val();
    var form_id = "backup_form";
    var app = "";
    var webservice = "";
    var db = "";
    var options = "";
    var flag = true;
    var backup_name = $('#backup_name').val();

    options = backup_name;

    if ($('#app_checkbox').is(':checked')) {
        options += "|" + '1';
    } else {
        options += "|" + '0';
    }

    if ($('#webservice_checkbox').is(':checked')) {
        options += "|" + '1';
    } else {
        options += "|" + '0';
    }

    if ($('#db_checkbox').is(':checked')) {
        options += "|" + '1';
    } else {
        options += "|" + '0';
    }


    if (!($('#app_checkbox').is(':checked') || $('#webservice_checkbox').is(':checked') || $('#db_checkbox').is(':checked'))) {
        alert("Choose atleast one option!");
    } else {
        var dataInfo = {}
        dataInfo['options'] = options + '|' + username;
        ;



        $.ajax({
            type: 'POST',
            url: "http://192.168.244.201/upgrade/upgrade/upgrade.php",
            async: false,
            data: {'info': dataInfo},
            success: function (value) {
                if (value.trim() != '0') {
                    var html_data = '<a href="' + value.trim() + '" target="_blank" class="btn_custom_m" style="text-decoration:none;" ><span id="remane_button_wa">Download</span></a>';
                    $('#download_id').html(html_data);
                }
            }
        });

    }

}
 
 
 
function  upload_back_up_file(){
    var returnValue;
    var formId='restore_bachup';
    var fetchURL='http://192.168.244.201/upgrade/upgrade/upload_script.php';
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
        cache: false,
        async: true,
        contentType: false,
        processData: false
    });
    return returnValue;

}
 
 
 
 
 