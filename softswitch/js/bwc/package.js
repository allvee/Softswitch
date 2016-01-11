/**
 * Created by Rakibul on 5/13/2015.
 */

function table_initialize_bwc_timepackage() {

    $('#tbl_view_table').html('<table class="table table-striped table-bordered table-hover responsive" id="dataTables_bwc_timepackage" width="100%"><tr><td  align="center"><img src="rcportal/img/31.gif"></td></tr></table>');

}

function table_bwc_timepackage_dataset(dataSet) {
    // "bFilter": false,
    //alert(dataSet);
    // "bFilter": false,
//    alert(dataSet);
    $('#dataTables_bwc_timepackage').dataTable({

        "data": dataSet,
        "columns": [
            {"title": "Package Name", "class": "center"},
            {"title": "StartTime", "class": "center"},
            {"title": "End Time", "class": "center"},
            {"title": "Days", "class": "center"},
            {"title": "Upload", "class": "center"},
            {"title": "Download", "class": "center"},
            {"title": "Action", "class": "center"},
        ],
        "order": [[0, "asc"]],
        dom: 'T<"clear">lfrtip',
        tableTools: {
            "sSwfPath": "rcportal/img/datatable/swf/copy_csv_xls_pdf.swf",
            "sRowSelect": "multi",
            "aButtons": [
                "select_all", "select_none", "copy", "csv",
                {
                    "sExtends": "xls",
                    "sFileName": "*.xls"
                }
            ],
            "filter": "applied"
        }
    });
}

function report_bwc_timepackage() {
    //alert();
    var dataSet = [[]];
    var dataInfo = {};
    //dataInfo['uid'] = 'test@test.com';

    dataSet = connectServer(cms_url['bwc_timepackage_table_view'], dataInfo);
     //alert(dataSet);
    dataSet = JSON.parse(dataSet);
    //alert(dataSet);
    table_initialize_bwc_timepackage();
    table_bwc_timepackage_dataset(dataSet);

    //console.log("dana");
}

function save_time_package(){

    var action = $("#action").val();
    var form_id = "edit_timepackage_info";
    var action_id = "";
    alert(action);
    if (action == 'insert') {
        var response = connectServerWithForm(cms_url['bwc_timepackage_save_action'], form_id,false);
        if (parseInt(response) == 0) {
            alertMessage(this, 'green', '', 'Successfully Submitted.');
            showUserMenu('bwc_time_add');
        } else {
            alertMessage(this, 'red', '', 'Failed.');
        }
    }
    else {
        var response = connectServerWithForm(cms_url['bwc_timepackage_save_action'], form_id,false);
        if (parseInt(response) == 0) {
            alertMessage(this, 'green', '', 'Successfully Submitted.');
            showUserMenu('bwc_time_view');
        } else {
            alertMessage(this, 'red', '', 'Failed.');
        }

    }

}

function edit_input_form_bwc_timepackage(obj, action_id) {
    var dataArray = [];
    var table = document.getElementById('dataTables_bwc_timepackage');
    var index = obj.parentNode.parentNode.rowIndex;
    //console.log("id::",index);
    var i = 0;
    for (i = 0; i <=5; i++)
        dataArray[i] = table.rows[index].cells[i].innerHTML;
    showUserMenu('bwc_time_add');


    $("#action").val('update');
    $("#action_id").val(action_id);
    //$("#remane_button_wa").text("Update");

    //$("#bwc_info_Group").val(dataArray[0]);
    $("#time_package_Name").val(dataArray[0]);
    $("#start_time").val(dataArray[1]);
    $("#end_time").val(dataArray[2]);
    $("#package_upload_Bandwidth").val(dataArray[4]);
    $("#package_download_Bandwidth").val(dataArray[5]);
    var track_array = dataArray[3].split(',');
    for (var i = 0; i < track_array.length; i++) {
        $("#bwc_timepackage option[value='" + track_array[i] + "']").attr('selected', true);
    }

    $('#submit').html('Update');
    dropdown_chosen_style();

}

function delete_bwc_timepackage(obj, action_id) {
    var dataInfo = {}
    dataInfo['action'] = 'delete';
    dataInfo['action_id'] = action_id;
   // alert();
    var response = connectServer(cms_url['bwc_timepackage_save_action'], dataInfo,false);
    if (parseInt(response) == 0) {
        alertMessage(this, 'green', '', 'Successfully Deleted.');
        showUserMenu('bwc_time_view');
    } else {
        alertMessage(this, 'red', '', 'Failed.');
    }

}

