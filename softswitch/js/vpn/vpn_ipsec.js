/**
 * Created by Talemul on 5/5/2015.
 */

/* save vpn ipsec config     */
function edit_controller_vpn_ipsec_config() {

    if ($('#ipsec_name').val().length < 2 || $('#leftsubnet').val().length < 2 || $('#rightsubnet').val().length < 2 || $('#right_v').val().length < 2 || $('#keylife').val().length < 2 || $('#ikelifetime').val().length < 2 ) {
        alertMessage(this, 'yellow', 'Required Field', 'Please fill all Required field');

    } else {
        var response = connectServerWithForm(cms_url['save_vpn_ipsec'], 'vpn_ipsec_config');
        response = JSON.parse(response);

        if (response.status) {
            alertMessage(this, 'green', 'Successful', response.message);
            var flag_action = $('#action').val();
            if (flag_action == 'update') {
                showUserMenu('vpn_ipsec_view');
// set default value which is read from table
            }
        } else {
            alertMessage(this, 'red', 'Unsuccessful', response.message);
        }
    }
}


/* =====================================================
 * Table Initialize
 * =====================================================*/

function table_initialize_vpn_ipsec() {

    $('#tbl_view_table').html('<table class="table table-striped table-bordered table-hover responsive" id="dataTables_rcportal_vpn_ipsec" width="100%"><tr><td  align="center"><img src="rcportal/img/31.gif"></td></tr></table>');

}


function table_data_vpn_ipsec(dataSet) {
    // "bFilter": false,
    //alert(dataSet);
    $('#dataTables_rcportal_vpn_ipsec').dataTable({

        "data": dataSet,
        "columns": [
            {"title": "ID", "class": "center"},
            {"title": "Name", "class": "center"},
            {"title": "Local ID", "class": "center"},

            {"title": "Local subnet", "class": "center"},
            {"title": "Remote ID", "class": "center"},
            {"title": "Remote subnet", "class": "center"},

            {"title": "Phase1", "class": "center"},
            {"title": "Phase2", "class": "center"},
            {"title": "PFS", "class": "center"},
            {"title": "P1 lifetime", "class": "center"},
            {"title": "Key life", "class": "center"},
            {"title": "PSK", "class": "center"},
            {"title": "Action", "class": "center nowrap2"}
        ],
        "order": [[0, "asc"]],
        'iDisplayLength': 5,
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


function report_menu_start_vpn_ipsec() {
//alert();
    var dataSet = [[]];
    var dataInfo = {};
    //dataInfo['uid'] = 'test@test.com';
    dataSet = connectServer(cms_url['view_vpn_ipsec'], dataInfo);
    //  alert(dataSet);
    dataSet = JSON.parse(dataSet);
    //alert(dataSet);
    table_data_vpn_ipsec(dataSet);

    $(".nowrap2").css("width", "45%");
}


/* =====================================================
 * edit function. for read all row
 * =====================================================*/
function edit_input_form_vpn_ipsec(obj, data) {
//read table data.
    var dataArray = [];
    var table = document.getElementById('dataTables_rcportal_vpn_ipsec');
    var index = obj.parentNode.parentNode.rowIndex;
    var i = 0;
    for (i = 0; i < 12; i++)
        dataArray[i] = table.rows[index].cells[i].innerHTML;
    // show api edit form.
    display_content_custom('41', '#modalData');
// set default value which is read from table
    $('#action_id').val(data);
    $('#action').val('update');
    $('#ipsec_name').val(dataArray[1]);
    $('#left_v').val(dataArray[2]);
    $('#leftsubnet').val(dataArray[3]);
    $('#right_v').val(dataArray[4]);
    $('#rightsubnet').val(dataArray[5]);
    $('#remane_button_wa').html('<i class="fa fa-pencil-square"></i><b>Update</b>');
    $("#ike option[value='" + dataArray[6] + "']").attr('selected', true);
    $("#esp option[value='" + dataArray[7] + "']").attr('selected', true);
    $("#pfs option[value='" + dataArray[8] + "']").attr('selected', true);

    $('#ikelifetime').val(dataArray[9]);
    $('#keylife').val(dataArray[10]);
    $('#psk').val(dataArray[11]);

// call chosen-select function for enable stylish select box.

    // rcportal_DatePicker('user_info_LastUpdate');
    dropdown_chosen_style();

}


/*============== delete operation===========================
 * delete
 * =========================================================*/
function delete_vpn_ipsec(obj, data) {
    var dataArray = [];
    var table = document.getElementById('dataTables_rcportal_vpn_ipsec');
    var index = obj.parentNode.parentNode.rowIndex;
    var i = 0;
    for (i = 0; i < 5; i++)
        dataArray[i] = table.rows[index].cells[i].innerHTML;
    confirmMessage(this, 'vpn_ipsec_yes', 'Delete Confirmation', 'Do you want to delete ?');
    var arrayInput = new Array(obj, data);
    $('#vpn_ipsec_yes').click({id: arrayInput}, delete_confirm_vpn_ipsec);

}
function delete_confirm_vpn_ipsec(event) {
    var arrayInput = event.data.id;

    var returnValue = '';
    var dataInfo = {};
    dataInfo['deleted_id'] = arrayInput[1];
    dataInfo['action'] = 'delete';

    returnValue = connectServer(cms_url['save_vpn_ipsec'], dataInfo);

    response = JSON.parse(returnValue);

    if (response.status) {
        alertMessage(this, 'green', 'Successful', response.message);
        showUserMenu('vpn_ipsec_view');
    } else {
        alertMessage(this, 'red', 'Unsuccessful', response.message);
    }
}

function vpn_ipsec_refresh() {
    $("#command_output_box").empty();
}

function vpn_ipsec_reload() {
    var data = {};
    var rs = confirm("Are you sure you want to restart?");
    data['command'] = "ipsec_restart";
    if (rs) {
        var returnValue = connectServer(cms_url['routing_vpn_restart'], data, false);
        var result = returnValue.replaceAll("ipsec","IPSEC");
        $("#command_output_box").append(result).scrollTop($("#command_output_box")[0].scrollHeight);
    }
}

function vpn_ipsec_start() {
    var data = {};
    var rs = confirm("Are you sure you want to start?");
    data['command'] = "ipsec_start";
    if (rs) {
        var returnValue = connectServer(cms_url['routing_vpn_restart'], data, false);
        var result = returnValue.replaceAll("ipsec","IPSEC");
        $("#command_output_box").append(result).scrollTop($("#command_output_box")[0].scrollHeight);
    }
}

function vpn_ipsec_stop() {
    var data = {};
    var rs = confirm("Are you sure you want to stop?");
    data['command'] = "ipsec_stop";
    if (rs) {
        var returnValue = connectServer(cms_url['routing_vpn_restart'], data, false);
        var result = returnValue.replaceAll("ipsec","IPSEC");
        $("#command_output_box").append(result).scrollTop($("#command_output_box")[0].scrollHeight);
    }
}


