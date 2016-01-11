/**
 * Created by Rakibul on 5/11/2015.
 */

function table_initialize_bwc_group() {

    $('#tbl_view_table').html('<table class="table table-striped table-bordered table-hover responsive" id="dataTables_bwc_group" width="100%"><tr><td  align="center"><img src="rcportal/img/31.gif"></td></tr></table>');

}

function table_bwc_group_dataset(dataSet) {
    // "bFilter": false,
    //alert(dataSet);
    // "bFilter": false,
    //alert(dataSet);
    $('#dataTables_bwc_group').dataTable({

        "data": dataSet,
        "columns": [
            {"title": "Group Name", "class": "center"},
            {"title": "Lan Interface", "class": "center"},
            {"title": "Wan Interface", "class": "center"},
            {"title": "Upload", "class": "center"},
            {"title": "Download", "class": "center"},
            {"title": "Brust", "class": "center"},
            {"title": "Priority", "class": "center"},
            {"title": "Brust Upload", "class": "center"},
            {"title": "Brust Download", "class": "center"},
            {"title": "Queue", "class": "center"},
            {"title": "Mode", "class": "center"},
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

function report_bwc_group() {
//alert();
    var dataSet = [[]];
    var dataInfo = {};
    //dataInfo['uid'] = 'test@test.com';
//    alert();
    dataSet = connectServer(cms_url['bwc_group_table_view'], dataInfo);
   // alert(dataSet);
    dataSet = JSON.parse(dataSet);
    //alert(dataSet);
    table_initialize_bwc_group();
    table_bwc_group_dataset(dataSet);

    //console.log("dana");
}


function save_group(){

    var action = $("#action").val();
    var form_id = "bwc_group";
    var action_id = "";

    if (action == 'insert') {
           var response = connectServerWithForm(cms_url['bwc_group_save_action'], form_id,false);
            if (parseInt(response) == 0) {
                alertMessage(this, 'green', '', 'Successfully Submitted.');
                showUserMenu('bwc_group_add');
            } else {
                alertMessage(this, 'red', '', 'Failed.');
        }
    }
    else {
            var response = connectServerWithForm(cms_url['bwc_group_save_action'], form_id,false);
             if (parseInt(response) == 0) {
                alertMessage(this, 'green', '', 'Successfully Submitted.');
                showUserMenu('bwc_group_view');
            } else {
                alertMessage(this, 'red', '', 'Failed.');
            }

    }

}

function edit_input_form_bwc_group(obj, action_id) {
    var dataArray = [];
    var table = document.getElementById('dataTables_bwc_group');
    var index = obj.parentNode.parentNode.rowIndex;
    //console.log("id::",index);
    var i = 0;
    for (i = 0; i <=10; i++)
        dataArray[i] = table.rows[index].cells[i].innerHTML;
    showUserMenu('bwc_group_add');


    $("#action").val('update');
    $("#action_id").val(action_id);
    //$("#remane_button_wa").text("Update");

    $("#bwc_info_GroupName").val(dataArray[0]);

    $("#bwc_group_upload").val(dataArray[3]);
    $("#bwc_group_download").val(dataArray[4]);
    $("#bwc_group_Brust option[value='" + dataArray[5] + "']").attr('selected', true);
    $("#bwc_group_priority option[value='" + dataArray[6] + "']").attr('selected', true);
    $("#bwc_group_maxUpload").val(dataArray[7]);
    $("#bwc_group_maxDownload").val(dataArray[8]);
    $("#bwc_group_Que option[value='" + dataArray[9] + "']").attr('selected', true);
    $("#bwc_group_Mode option[value='" + dataArray[10] + "']").attr('selected', true);
    var track_array = dataArray[1].split(',');
    for (var i = 0; i < track_array.length; i++) {
        $("#bwc_lan_interface option[value='" + track_array[i] + "']").attr('selected', true);
    }

    var track_array = dataArray[2].split(',');
    for (var i = 0; i < track_array.length; i++) {
        $("#bwc_wan_interface option[value='" + track_array[i] + "']").attr('selected', true);
    }
    $('#submit').html('Update');
    dropdown_chosen_style();

}

function delete_bwc_group(obj, action_id) {
    var dataInfo = {}
    dataInfo['action'] = 'delete';
    dataInfo['action_id'] = action_id;
    var response = connectServer(cms_url['bwc_group_save_action'], dataInfo,false);
    if (parseInt(response) == 0) {
        alertMessage(this, 'green', '', 'Successfully Deleted.');
        showUserMenu('bwc_group_view');
    } else {
        alertMessage(this, 'red', '', 'Failed.');
    }

}
