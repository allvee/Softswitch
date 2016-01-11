/**
 *
 * Edited by Talemul Islam on 5/23/2015
 */
/** =========================================================for view ,edit,and delete====================================================== */
function table_initialize_server_info() {

    $('#tbl_view_table').html('<table class="table table-striped table-bordered table-hover responsive" id="dataTables_server_info" width="100%"><tr><td  align="center"><img src="softswitch/img/31.gif"></td></tr></table>');
}

function report_menu_start_server_info() {
//alert();
    var dataSet = [[]];
    var dataInfo = {};

    dataSet = connectServer(cms_url['parse_server_info'], dataInfo);
    //  alert(dataSet);
    dataSet = JSON.parse(dataSet);
    //alert(dataSet);
    table_data_server_info(dataSet);
}


function table_data_server_info(dataSet) {
    // "bFilter": false,
    //alert(dataSet);
    $('#dataTables_server_info').dataTable({
        "data": dataSet,
        "columns": [
            {"title": "Server IP", "class": "center"},
            {"title": "Server Port", "class": "center"},
            {"title": "Protocol", "class": "center"},
            {"title": "Client Bind IP", "class": "center"},
            {"title": "Client Bind Port", "class": "center"},
            {"title": "Is Register Need Flag", "class": "center"},
            {"title": "From Number Start Range", "class": "center"},
            {"title": "From Number End Range", "class": "center"},
            {"title": "To Number Start Range", "class": "center"},
            {"title": "To Number End Range", "class": "center"},
            {"title": "SIP UserID", "class": "center"},
            {"title": "SIP Password", "class": "center"},
            {"title": "Is Proxy Status", "class": "center"},
            {"title": "Forward Per Index", "class": "center"},
            {"title": "Is Active Status", "class": "center"},
            {"title": "Is Internal Status", "class": "center"}
        ],
        "order": [[0, "asc"]],
        dom: 'T<"clear">lfrtip',
        tableTools: {
            "sSwfPath": "softswitch/img/datatable/swf/copy_csv_xls_pdf.swf",
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


function softswitch_ippbx_server_controller() {

    if ($("#server_ip").val().trim() == '') {
        alert("Please fill all the necessary fields");
    } else if ($("#server_port").val().trim() == '') {
        alert("Please fill all the necessary fields");
    } else if ($("#client_bind_ip").val().trim() == '') {
        alert("Please fill all the necessary fields");
    } else if ($("#client_bind_port").val().trim() == '') {
        alert("Please fill all the necessary fields");
    } else if ($("#is_need_flag").val().trim() == '') {
        alert("Please fill all the necessary fields");
    } else if ($("#from_number_start_range").val().trim() == '') {
        alert("Please fill all the necessary fields");
    } else if ($("#from_number_end_range").val().trim() == '') {
        alert("Please fill all the necessary fields");
    } else if ($("#to_number_start_range").val().trim() == '') {
        alert("Please fill all the necessary fields");
    } else if ($("#to_number_end_range").val().trim() == '') {
        alert("Please fill all the necessary fields");
    } else if ($("#is_proxy_status").val().trim() == '') {
        alert("Please fill all the necessary fields");
    } else if ($("#sip_user_id").val().trim() == '') {
        alert("Please fill all the necessary fields");
    } else if ($("#sip_password").val().trim() == '') {
        alert("Please fill all the necessary fields");
    } else if ($("#protocol").val().trim() == '') {
        alert("Please fill all the necessary fields");
    } else if ($("#forward_per_index").val().trim() == '') {
        alert("Please fill all the necessary fields");
    } else if ($("#is_active_status").val().trim() == '') {
        alert("Please fill all the necessary fields");
    } else if ($("#is_internal_status").val().trim() == '') {
        alert("Please fill all the necessary fields");
    }else {
        var flag1 = IPAddressOnly($('#server_ip').val());
        var flag2 = IPAddressOnly($('#client_bind_ip').val());

        if (flag1 && flag2) {

            var response = connectServerWithForm(cms_url['add_server_info'], 'softswitch_ippbx_server');
            response = JSON.parse(response);
            if (response.status) {
                alertMessage(this, 'green', 'Successful', response.message);
            } else {
                alertMessage(this, 'red', 'Unsuccessful', response.message);
            }


        }

        return true;
    }
    return false;


}

function parse_softswitch_servers() {

    var response_of_user_info = connectServerWithForm(cms_url['view_server_info'], 'softswitch_ippbx_server');
    var response = JSON.parse(response_of_user_info);
    if (response.status) {
        var data = response.map;
        $.each(data, function (i, item) {
            if (i == 'is_need_flag') {
                var chosen_is_need_flag = item;
                $("#is_need_flag option[value='" + chosen_is_need_flag + "']").attr('selected', true);
                $("#is_need_flag").trigger("chosen:updated");
            } else if (i == 'is_proxy_status') {
                var chosen_is_proxy_status = item;
                $("#is_proxy_status option[value='" + chosen_is_proxy_status + "']").attr('selected', true);
                $("#is_proxy_status").trigger("chosen:updated");
            } else if (i == 'protocol') {
                var chosen_protocol = item;
                $("#protocol option[value='" + chosen_protocol + "']").attr('selected', true);
                $("#protocol").trigger("chosen:updated");
            } else if (i == 'is_active_status') {
                var chosen_is_active_status = item;
                $("#is_active_status option[value='" + chosen_is_active_status + "']").attr('selected', true);
                $("#is_active_status").trigger("chosen:updated");
            } else if (i == 'is_internal_status') {
                var chosen_is_internal_status = item;
                $("#is_internal_status option[value='" + chosen_is_internal_status + "']").attr('selected', true);
                $("#is_internal_status").trigger("chosen:updated");
            } else {
                $("#" + i).val(item);
            }


            //alert("Mine is " + i + "|" + item + "|" + item);
        });

    } else {
        alertMessage(this, 'red', '', 'Failed to read the servers.ini!');
    }
    return true;


}




/* =====================================================
 * edit function. for read all row
 * =====================================================*/
/*
function edit_input_form_server_info(obj, data) {
//read table data.
    var dataArray = [];
    var table = document.getElementById('dataTables_server_info');
    var index = obj.parentNode.parentNode.rowIndex;
    var i = 0;
    for (i = 0; i < 7; i++)
        dataArray[i] = table.rows[index].cells[i].innerHTML;
    // show api edit form.
    display_content_custom("107", "#modalData");
// set default value which is read from table
    $('#action').val("update");
    $('#submit').html("Update");
    $('#action_id').val(data);
    $('#server_ip').val(dataArray[0]);
    $('#server_port').val(dataArray[1]);
    $("#protocol option[value='" + dataArray[2] + "']").attr('selected', true);
    $('#client_bind_ip').val(dataArray[3]);
    $('#client_bind_port').val(dataArray[4]);
    $('#sip_user_id').val(dataArray[5]);
    $('#sip_password').val(dataArray[6]);
    // selected item makes true.
    dropdown_chosen_style();

}

*/


////////////////////////////////////for add//////////////////////////////////////////////////
/*
function softswitch_ippbx_server_controller() {
    form_id = "softswitch_ippbx_server";

    var action = $('#action').val();

    var server_ip = $('#server_ip').val();
    var client_bind_ip = $('#client_bind_ip').val();
    var flag = true;
    flag = flag && IPAddressOnly(server_ip) && IPAddressOnly(client_bind_ip);

    if (flag) {
        var add_server_info = connectServerWithForm(cms_url['add_server_info'], form_id);

        response = JSON.parse(add_server_info);

        if (response.status) {
            alertMessage(this, 'green', 'Successful', response.message);
            if (action == "insert") {
                showUserMenu('softswitch_server_add');
            } else {
                showUserMenu('softswitch_server_view');
            }
        } else {
            alertMessage(this, 'red', 'Unsuccessful', response.message);
        }
    }
}

*/


/*============== delete operation===========================
 * delete edited by Talemul for added confirmation.
 * =========================================================*/
/*
function delete_server_info(obj, action_id) {

    confirmMessage(this, 'server_info_yes', 'Delete Confirmation', 'Do you want to delete ?');
    var arrayInput = new Array(obj, action_id);
    $('#server_info_yes').click({id: arrayInput}, delete_confirm_server_info);

}
function delete_confirm_server_info(event) {
    var arrayInput = event.data.id;
    var dataInfo = {}
    dataInfo['action'] = 'delete';
    dataInfo['action_id'] = arrayInput[1];

    var response = connectServer(cms_url['add_server_info'], dataInfo);
    response = JSON.parse(response);
    if (response.status) {
        showUserMenu('softswitch_server_view');
        alertMessage(this, 'green', 'Successful', response.message);
    } else {
        alertMessage(this, 'red', '', 'Failed.');
    }

}

*/
