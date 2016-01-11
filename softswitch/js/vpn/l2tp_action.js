/**
 * Created by Nazibul on 5/5/2015.
 */

function save_action_l2tp_server() {
    //alert('l2tp_configuration');
    var form_id = 'l2tp_configuration';
    //cms_url['vpn_l2tp_save_action']

    var flag1 = IPAddressOnly($('#from_ip').val());
    var flag2 = IPAddressOnly($('#to_ip').val());
    var flag3 = IPAddressOnly($('#local_ip').val());
    var flag4 = IPAddressOnly($('#local_ip').val());

    // call connectServerWithForm with a php url and for id
    if (flag1 && flag2 && flag3 && flag4) {
        var response_of_user_info = connectServerWithForm(cms_url['vpn_l2tp_save_action'], form_id);

        if(response_of_user_info==0) {
            alertMessage(this, 'green', '', 'Success');
            if($('#action').val()=="update"){
                display_content_custom("150", "#modalData");
                table_initialize_vpn_l2tp();
                report_menu_start_vpn_l2tp();
            }
        }else{
            alertMessage(this, 'red', '', 'Fail !');
        }

    }


}

/*
 function update_action_l2tp_server(){
 alert('edit_user_info');
 var form_id='edit_user_info';
 $('#action').val("update");
 //cms_url['vpn_l2tp_save_action']

 // call connectServerWithForm with a php url and for id
 var response_of_user_info = connectServerWithForm(cms_url['vpn_l2tp_save_action'], form_id);

 // alert message for success.
 message_alert(response_of_user_info,'green');
 }*/

function edit_input_form_vpn_l2tp_server(obj, info) {

    var data = info.split("|");

    display_content_custom("45", "#modalData");

    $('#action_id').val(data[0]);
    $('#action').val("update");
    $('#button_id').html("Update");
    $('#listen_address').val(data[1]);

    var range = data[2].split("-");

    $('#from_ip').val(range[0]);
    $('#to_ip').val(range[1]);

    $('#local_ip').val(data[3]);
    $('#ms-dns').val(data[4]);

}

function delete_vpn_l2tp_server(obj, id) {
    /* confirmMessage(this, 'user_info_yes', 'Delete Confirmation', 'Do you want to delete ID=' + id + ' from User Info?');
     $('#user_info_yes').click(
     $.ajax({
     url: cms_url['vpn_l2tp_save_action'],
     type: 'POST',
     data: {action: 'delete', action_id: id},
     success: function (result) {
     message_alert(result,'green');
     table_initialize_vpn_l2tp();
     report_menu_start_vpn_l2tp();
     }
     })
     );
     */

    var flag = confirm("Delete ID=" + id);

    if (flag) {
        $.ajax({
            url: cms_url['vpn_l2tp_save_action'],
            type: 'POST',
            data: {action: 'delete', action_id: id},
            success: function (result) {
                alertMessage(this, 'green', '', result);
                table_initialize_vpn_l2tp();
                report_menu_start_vpn_l2tp();
            }
        });
    }


}

/*   */

function table_initialize_vpn_l2tp() {

    $('#tbl_view_table').html('<table class="table table-striped table-bordered table-hover responsive" id="dataTables_rcportal_vpn_l2tp" width="100%"><tr><td  align="center"><img src="rcportal/img/31.gif"></td></tr></table>');

}


function report_menu_start_vpn_l2tp() {
//alert();
    var dataSet = [[]];
    var dataInfo = {};
    //dataInfo['uid'] = 'test@test.com';
    dataSet = connectServer(cms_url['vpn_l2tp_table_view'], dataInfo);
    //  alert(dataSet);
    dataSet = JSON.parse(dataSet);
    //alert(dataSet);
    table_data_vpn_l2tp(dataSet);

}


function table_data_vpn_l2tp(dataSet) {
    // "bFilter": false,
    //alert(dataSet);
    $('#dataTables_rcportal_vpn_l2tp').dataTable({

        "data": dataSet,
        "columns": [
            {"title": "ID", "class": "center"},
            {"title": "Listen Address", "class": "center"},
            {"title": "IP Range", "class": "center"},
            {"title": "Local IP", "class": "center"},
            {"title": "MS DNS", "class": "center"},
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

