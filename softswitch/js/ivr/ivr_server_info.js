
function table_initialize_ivr_server_info() {

  
    $('#tbl_view_table').html('<table class="table table-striped table-bordered table-hover responsive bootstrap-datatable datatable" id="dataTables_rcportal_ivr_server_info" width="100%"  ><tr><td  align="center"><img src="rcportal/img/31.gif"></td></tr></table>');
    alert('a');
}

function report_menu_start_ivr_server_info() {
//alert();
    var dataSet = [[]];
    var dataInfo = {};
    //dataInfo['uid'] = 'test@test.com';
    dataSet = connectServer(cms_url['view_ivr_server_info'], dataInfo);
    //alert(dataSet);
    dataSet = JSON.parse(dataSet);
    // console.log(dataSet);
    //alert(dataSet);

    table_data_ivr_server_info(dataSet);

    // data_table_responsive();
}


function table_data_ivr_server_info(dataSet) {
    // "bFilter": false,
    //alert(dataSet);
    $('#dataTables_rcportal_ivr_server_info').dataTable({
        "data": dataSet,
        "columns": [
            {"title": "Server Name", "class": "center"},
            {"title": "Database Type", "class": "center"},
            {"title": "Database Server", "class": "center"},
            {"title": "User ID", "class": "center"},
            {"title": "Database Password", "class": "center"},
            {"title": "Database Name", "class": "center"},
            {"title": "Prompt Location", "class": "center"},
            {"title": "URL", "class": "center"},
            {"title": "Recording Location", "class": "center"}, 
            {"title": "Action", "class": "center"},
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
function edit_input_form_ivr_server_info(obj, action_id) {
    var dataArray = [];
    var table = document.getElementById('dataTables_rcportal_ivr_server_info');
    var index = obj.parentNode.parentNode.rowIndex;
    var i = 0;
    for (i = 0; i < 9; i++) {
        dataArray[i] = table.rows[index].cells[i].innerHTML;
    }
    showUserMenu('ivr_server_info_add');
    $('#action').val('update');
    $('#action_id').val(action_id);
    $("#server_name[value='" + dataArray[0] + "']").attr('selected', true);
    $('#db_type').val(dataArray[1]);
    $('#db_server').val(dataArray[2]);
    $('#db_uid').val(dataArray[3]);
    $('#db_password').val(dataArray[4]);
    //$("#Status[value='" + dataArray[6] + "']").attr('selected', true);
    $('#db_name').val(dataArray[5]);
    $('#prompt_location').val(dataArray[6]);
    $('#web_service_url').val(dataArray[7]);
    $('#recording_location').val(dataArray[8]);
    $('#remane_button_wa').html('Update');
    dropdown_chosen_style();
}

/*============== delete operation===========================
 * delete
 * =========================================================*/

function delete_ivr_server_info(obj, data) {
    var dataArray = [];
    confirmMessage(this, 'ivr_server_info_yes', 'Delete Confirmation', 'Do you want to delete ?');
    var arrayInput = new Array(obj, data);
    $('#ivr_server_info_yes').click({id: arrayInput}, delete_confirm_ivr_server_info);
}

function delete_confirm_ivr_server_info(event) {
    var dataInfo = {};
    dataInfo['action'] = 'delete';
    var arrayInput = event.data.id;
    dataInfo['deleted_id'] = arrayInput[1];
    //  dataInfo['deleted_id'] = action_id;
    var response = JSON.parse(connectServer(cms_url['save_ivr_server_info'], dataInfo));

    if (response.status) {
        alertMessage(this, 'green', 'Successful', response.message);
        //alert("Deleted Successfully");
        showUserMenu('ivr_server_info_view');
    }

}

function ivr_server_info_add() {

    var formId = 'ivr_server_info';

    // console.log(formId);
    //call connectServerWithForm with a php url and for id

    var response = connectServerWithForm(cms_url['save_ivr_server_info'], formId)
    response = JSON.parse(response);
    if (response.status) {
        if (response.message != 'Successfully Saved') {
            showUserMenu('ivr_server_info_view');
        }
        alertMessage(this, 'green', 'Successful', response.message);

    } else {
        alertMessage(this, 'red', 'Unsuccessful', response.message);
    }
}