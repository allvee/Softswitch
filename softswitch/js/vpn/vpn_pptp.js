/**
 * Created by Talemul on 5/6/2015.
 */

/* save vpn pptp config     */
function edit_controller_vpn_pptp_config_server() {

    if ($('#local_ip').val().length < 2 || $('#remote_ip').val().length < 2) {
        alertMessage(this, 'yellow', 'Required Field', 'Please fill all Required field');
    } else {
        var response = connectServerWithForm(cms_url['save_vpn_pptp_server'], 'vpn_pptp_config_server');
        response = JSON.parse(response);

        if (response.status) {
            alertMessage(this, 'green', 'Successful', response.message);

        } else {
            alertMessage(this, 'red', 'Unsuccessful', response.message);
        }
    }
}

function edit_controller_vpn_pptp_config_client() {

    if ($('#user_name').val().length < 2 || $('#password').val().length < 2) {
        alertMessage(this, 'yellow', 'Required Field', 'Please fill all Required field');

    } else {
        var response = connectServerWithForm(cms_url['save_vpn_pptp_client'], 'vpn_pptp_config_client');
        response = JSON.parse(response);

        if (response.status) {
            alertMessage(this, 'green', 'Successful', response.message);
        } else {
            alertMessage(this, 'red', 'Unsuccessful', response.message);
        }
    }
}


/* =====================================================
 * Table Initialize
 * =====================================================*/

function table_initialize_vpn_pptp_server() {
    $('#table_title').html('PPTP Server');
    $('#tbl_view_table').html('<table class="table table-striped table-bordered table-hover responsive" id="dataTables_rcportal_vpn_ppt_server" width="100%"><title>PPTP Server</title><tr><td  align="center"><img src="rcportal/img/31.gif"></td></tr></table>');
    $('#second_tbl_view_table').html('<div class="col-md-12"> <div > <div class="tabtitle"> <div class="row" style="text-align: center"> <span id="table_title2"></span> </div> </div> <div class="row tabinner clearfix"> <div  id="tbl_view_table2"> </div> </div> </div></div>');
    $('#table_title2').html('PPTP Client');
    $('#tbl_view_table2').html('<table class="table table-striped table-bordered table-hover responsive" id="dataTables_rcportal_vpn_ppt_client" width="100%"><title>PPTP Server</title><tr><td  align="center"><img src="rcportal/img/31.gif"></td></tr></table>');

}


function table_data_vpn_pptp_server(dataSet1, dataSet2) {
    // "bFilter": false,
    //alert(dataSet);

    $('#dataTables_rcportal_vpn_ppt_server').dataTable({
        "data": dataSet1,
        "columns": [
            {"title": "ID", "class": "center"},
            {"title": "Server IP", "class": "center"},
            {"title": "Remote IP", "class": "center"},
            {"title": "Action", "class": "center nowrap2"}
        ],
        "order": [[0, "asc"]],
        'iDisplayLength': 3,
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
    $('#dataTables_rcportal_vpn_ppt_client').dataTable({

        "data": dataSet2,
        "columns": [
            {"title": "ID", "class": "center"},
            {"title": "User", "class": "center"},
            {"title": "Password", "class": "center"},
            {"title": "IP", "class": "center"},
            {"title": "Action", "class": "center nowrap2"}
        ],
        "order": [[0, "asc"]],
        'iDisplayLength': 3,
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


function report_menu_start_vpn_pptp_server() {
//alert();
    var dataSet = [[]];
    var dataInfo = {};
    //dataInfo['uid'] = 'test@test.com';
    dataSet = connectServer(cms_url['view_vpn_pptp_server'], dataInfo);
    //  alert(dataSet);
    dataSet = JSON.parse(dataSet);
    //alert(dataSet);

    table_data_vpn_pptp_server(dataSet.table1, dataSet.table2);

    $(".nowrap2").css("width", "30%");
}


/* =====================================================
 * edit function. for read all row
 * =====================================================*/
function edit_input_form_vpn_pptp_server(obj, data) {
//read table data.
    var dataArray = [];
    var table = document.getElementById('dataTables_rcportal_vpn_ppt_server');
    var index = obj.parentNode.parentNode.rowIndex;
    var i = 0;
    for (i = 0; i < 3; i++)
        dataArray[i] = table.rows[index].cells[i].innerHTML;
    // show api edit form.
    display_content_custom('43', '#modalData');
// set default value which is read from table
    $('#action_id_s').val(data);
    $('#action_s').val('update');
    $('#local_ip').val(dataArray[1]);
    $('#remote_ip').val(dataArray[2]);
    $('#remane_button_s').html('<i class="fa fa-pencil-square"></i><b>Update</b>');
}


/*============== delete operation===========================
 * delete
 * =========================================================*/
function delete_vpn_pptp_server(obj, data) {
    var dataArray = [];
    var table = document.getElementById('dataTables_rcportal_vpn_ppt_server');
    var index = obj.parentNode.parentNode.rowIndex;
    var i = 0;
    for (i = 0; i < 3; i++)
        dataArray[i] = table.rows[index].cells[i].innerHTML;
    confirmMessage(this, 'vpn_ipsec_yes', 'Delete Confirmation', 'Do you want to delete ?');
    var arrayInput = new Array(obj, data);
    $('#vpn_ipsec_yes').click({id: arrayInput}, delete_confirm_vpn_pptp_server);

}
function delete_confirm_vpn_pptp_server(event) {
    var arrayInput = event.data.id;
    var returnValue = '';
    var dataInfo = {};
    dataInfo['deleted_id'] = arrayInput[1];
    dataInfo['action'] = 'delete';

    returnValue = connectServer(cms_url['save_vpn_pptp_server'], dataInfo);

    response = JSON.parse(returnValue);

    if (response.status) {
        alertMessage(this, 'green', 'Successful', response.message);
        showUserMenu('vpn_pptp_view');
    } else {
        alertMessage(this, 'red', 'Unsuccessful', response.message);
    }
}


/* =====================================================
 * edit function. for read all row
 * =====================================================*/
function edit_input_form_vpn_pptp_client(obj, data) {
//read table data.
    var dataArray = [];
    var table = document.getElementById('dataTables_rcportal_vpn_ppt_client');
    var index = obj.parentNode.parentNode.rowIndex;
    var i = 0;
    for (i = 0; i < 4; i++)
        dataArray[i] = table.rows[index].cells[i].innerHTML;
    // show api edit form.
    display_content_custom('43', '#modalData');
// set default value which is read from table
    $('#action_id_c').val(data);
    $('#action_c').val('update');
    $('#user_name').val(dataArray[1]);
    $('#password').val(dataArray[2]);
    $('#pptp_client_ip').val(dataArray[3]);
    $('#remane_button_c').html('<i class="fa fa-pencil-square"></i><b>Update</b>');
}


/*============== delete operation===========================
 * delete
 * =========================================================*/
function delete_vpn_pptp_client(obj, data) {
    var dataArray = [];
    var table = document.getElementById('dataTables_rcportal_vpn_ppt_client');
    var index = obj.parentNode.parentNode.rowIndex;
    var i = 0;
    for (i = 0; i < 4; i++)
        dataArray[i] = table.rows[index].cells[i].innerHTML;
    confirmMessage(this, 'vpn_ipsec_yes', 'Delete Confirmation', 'Do you want to delete ?');
    var arrayInput = new Array(obj, data);
    $('#vpn_ipsec_yes').click({id: arrayInput}, delete_confirm_vpn_pptp_client);

}
function delete_confirm_vpn_pptp_client(event) {
    var arrayInput = event.data.id;

    var returnValue = '';
    var dataInfo = {};
    dataInfo['deleted_id'] = arrayInput[1];
    dataInfo['action'] = 'delete';
    returnValue = connectServer(cms_url['save_vpn_pptp_client'], dataInfo);

    response = JSON.parse(returnValue);

    if (response.status) {
        alertMessage(this, 'green', 'Successful', response.message);
        showUserMenu('vpn_pptp_view');
    } else {
        alertMessage(this, 'red', 'Unsuccessful', response.message);
    }
}

function vpn_pptp_refresh() {
    $("#command_output_box").empty();
}

function vpn_pptp_reload() {
    var data = {};
    var rs = confirm("Are you sure you want to restart?");
    data['command'] = "pptpd_restart";
    if (rs) {
        var returnValue = connectServer(cms_url['routing_vpn_restart'], data, false);
        var result = returnValue.replace("pptpd","PPTP");
        $("#command_output_box").append(result).scrollTop($("#command_output_box")[0].scrollHeight);
    }
}

function vpn_pptp_start() {
    var data = {};
    var rs = confirm("Are you sure you want to start?");
    data['command'] = "pptpd_start";
    if (rs) {
        var returnValue = connectServer(cms_url['routing_vpn_restart'], data, false);
        var result = returnValue.replace("pptpd","PPTP");
        $("#command_output_box").append(result).scrollTop($("#command_output_box")[0].scrollHeight);
    }
}

function vpn_pptp_stop() {
    var data = {};
    var rs = confirm("Are you sure you want to stop?");
    data['command'] = "pptpd_stop";
    if (rs) {
        var returnValue = connectServer(cms_url['routing_vpn_restart'], data, false);
        var result = returnValue.replace("pptpd","PPTP");
        $("#command_output_box").append(result).scrollTop($("#command_output_box")[0].scrollHeight);
    }
}



