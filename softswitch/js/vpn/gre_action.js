/**
 * Created by Nazibul on 5/6/2015.
 * Edited by Talemul Islam on 5/23/2015
 */

function save_action_gre() {

    var flag1 = IPAddressOnly($('#peer_outer').val());
    var flag2 = IPAddressOnly($('#peer_inner').val());
    var flag3 = IPAddressOnly($('#my_inner').val());

    var form_id = 'gre_config';
    //cms_url['vpn_l2tp_save_action']

    // call connectServerWithForm with a php url and for id

    if (flag1 && flag2 && flag3) {
        var response_of_user_info = connectServerWithForm(cms_url['vpn_gre_save_action'], form_id);


        if (response_of_user_info == 1) {
            alertMessage(this, 'red', '', 'fail !');
        } else {
            alertMessage(this, 'green', '', 'Success');
            if($('#action').val()=="update"){
                display_content_custom("150", "#modalData");
                table_initialize_vpn_gre();
                report_menu_start_vpn_gre();
            }
        }
    }

}


function edit_input_form_vpn_gre(obj, info) {

    var data = info.split("|");

    display_content_custom("44", "#modalData");

    $('#action_id').val(data[0]);
    $('#action').val("update");
    $('#remane_button_wa').html('Update');

    $('#gre_name').val(data[1]);

    $('#peer_outer').val(data[2]);

    $('#peer_inner').val(data[3]);
    $('#my_inner').val(data[4]);

    $('#gre_name').prop({
        'disabled': false,
        'readonly': true
    });

}
 

function active_vpn_gre(obj, id, status) {

    $.ajax({
        url: cms_url['vpn_gre_update_status'],
        type: 'POST',
        data: {action_id: id, status: status},
        success: function (result) {
            if (result == 0) {
                alertMessage(this, 'green', '', 'Successful');
            } else {
                alertMessage(this, 'red', '', 'Fail !');
            }
            table_initialize_vpn_gre();
            report_menu_start_vpn_gre();
        }
    });
}

/*   */

function table_initialize_vpn_gre() {

    $('#tbl_view_table').html('<table class="table table-striped table-bordered table-hover responsive" id="dataTables_rcportal_vpn_gre" width="100%"><tr><td  align="center"><img src="rcportal/img/31.gif"></td></tr></table>');

}


function report_menu_start_vpn_gre() {
//alert();
    var dataSet = [[]];
    var dataInfo = {};
    //dataInfo['uid'] = 'test@test.com';
    dataSet = connectServer(cms_url['vpn_gre_table_view'], dataInfo);
    //  alert(dataSet);
    dataSet = JSON.parse(dataSet);
    //alert(dataSet);
    table_data_vpn_gre(dataSet);

}


function table_data_vpn_gre(dataSet) {
    // "bFilter": false,
    //alert(dataSet);
    $('#dataTables_rcportal_vpn_gre').dataTable({

        "data": dataSet,
        "columns": [
            {"title": "ID", "class": "center"},
            {"title": "Device Name", "class": "center"},
            {"title": "Peer Outer IP", "class": "center"},
            {"title": "Peer Inner IP", "class": "center"},
            {"title": "My Inner IP", "class": "center"},
            {"title": "MANAGE", "class": "center"},
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

function vpn_gre_refresh() {
    $("#command_output_box").empty();
}

function vpn_gre_reload() {
    var data = {};
    var rs = confirm("Are you sure you want to restart?");
    data['command'] = "";
    if (rs) {
        var returnValue = connectServer(cms_url['routing_vpn_restart'], data, false);
        $("#command_output_box").append(returnValue).scrollTop($("#command_output_box")[0].scrollHeight);
    }
}

function vpn_gre_start() {
    var data = {};
    var rs = confirm("Are you sure you want to start?");
    data['command'] = "";
    if (rs) {
        var returnValue = connectServer(cms_url['routing_vpn_restart'], data, false);
        $("#command_output_box").append(returnValue).scrollTop($("#command_output_box")[0].scrollHeight);
    }
}

function vpn_gre_stop() {
    var data = {};
    var rs = confirm("Are you sure you want to stop?");
    data['command'] = "";
    if (rs) {
        var returnValue = connectServer(cms_url['routing_vpn_restart'], data, false);
        $("#command_output_box").append(returnValue).scrollTop($("#command_output_box")[0].scrollHeight);
    }
}




/*============== delete operation===========================
 * delete edited by Talemul for added confirmation.
 * =========================================================*/
function delete_vpn_gre(obj, action_id) {

    confirmMessage(this, 'vpn_gre_yes', 'Delete Confirmation', 'Do you want to delete ?');
    var arrayInput = new Array(obj, action_id);
    $('#vpn_gre_yes').click({id: arrayInput}, delete_confirm_vpn_gre);

}
function delete_confirm_vpn_gre(event) {
    var arrayInput = event.data.id;
    var dataInfo = {}
    dataInfo['action'] = 'delete';
    dataInfo['action_id'] = arrayInput[1];

    var response = connectServer(cms_url['vpn_gre_save_action'], dataInfo);
     if (response == 0) {
        showUserMenu('vpn_gre_view');
        alertMessage(this, 'green', 'Successful', response.message);
    }else {
        alertMessage(this, 'red', '', 'Failed.');
    }

}


