
function table_initialize_soft_config() {

    $('#tbl_view_table').html('<table class="table table-striped table-bordered table-hover responsive" id="dataTables_soft_config" width="100%"><tr><td  align="center"><img src="softswitch/img/31.gif"></td></tr></table>');
}

function report_menu_start_soft_config() {
//alert();
    var dataSet = [[]];
    var dataInfo = {};
    //dataInfo['uid'] = 'test@test.com';
    dataSet = connectServer(cms_url['view_configuration_info'], dataInfo);
    //  alert(dataSet);
    dataSet = JSON.parse(dataSet);
    //alert(dataSet);
    table_data_soft_config(dataSet);

}

function table_data_soft_config(dataSet) {
    // "bFilter": false,
    //alert(dataSet);
    $('#dataTables_soft_config').dataTable({
        "data": dataSet,
        "columns": [
            {"title": "UDP Bind IP", "class": "center"},
            {"title": "UDP Signaling Port", "class": "center"},
            {"title": "UDP Signaling Protocol", "class": "center"},
            {"title": "UDP Media Port", "class": "center"},
            {"title": "UDP Media Protocol", "class": "center"},
            {"title": "TCP Bind IP", "class": "center"},
            {"title": "TCP Signaling Port", "class": "center"},
            {"title": "TCP Signaling Protocol", "class": "center"},
            {"title": "TCP Media Port", "class": "center"},
            {"title": "TCP Media Protocol", "class": "center"},
            {"title": "Log Level", "class": "center"},
            {"title": "Log Destination", "class": "center"},
            {"title": "Control UDP Port", "class": "center"},
            {"title": "Log TCP Report", "class": "center"},
            {"title": "Action", "class": "center"}
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

function edit_soft_config(obj, data) {
//read table data.
    var dataArray = [];
    var table = document.getElementById('dataTables_soft_config');
    var index = obj.parentNode.parentNode.rowIndex;
    var i = 0;
    for (i = 0; i < 14; i++)
        dataArray[i] = table.rows[index].cells[i].innerHTML;

    display_content_custom("105", "#modalData");
    
    $('#remane_button_wa').html('Update');

    $('#action').val("update");
    $('#action_id').val(data);
    $('#udp_bind_ip').val(dataArray[0]);
    $('#udp_signaling_port').val(dataArray[1]);
    $('#udp_signaling_protocol').val(dataArray[2]);
    $('#udp_media_port').val(dataArray[3]);
    $('#udp_media_protocol').val(dataArray[4]);
    $('#tcp_bind_ip').val(dataArray[5]);
    $('#tcp_signaling_port').val(dataArray[6]);
    $('#tcp_signaling_protocol').val(dataArray[7]);
    $('#tcp_media_port').val(dataArray[8]);
    $('#tcp_media_protocol').val(dataArray[9]);
    $('#log_level').val(dataArray[10]);
    $('#log_destination').val(dataArray[11]);
    $('#rcportal_control_udp_port').val(dataArray[12]);
    $('#log_tcp_port').val(dataArray[13]);

    dropdown_chosen_style();

}

 

function add_soft_config() {
    form_id = "edit_configuration_info";

/*    //alert("meeeeeee");


    var flag1 = IPAddressOnly($('#udp_bind_ip').val());
    var flag2 = IPAddressOnly($('#tcp_bind_ip').val());

    if (flag1 && flag2) {

        var add_context_info = connectServerWithForm(cms_url['configuration_info'], form_id);

        response = JSON.parse(add_context_info);

        if (response.status) {
            alertMessage(this, 'green', 'Successful', response.message);
        } else {
            alertMessage(this, 'red', 'Unsuccessful', response.message);
        }
    }

    var action = $('#action').val();
    if (action == 'update') {
        showUserMenu('softswitch_configuration_view');
    }*/


    if($("#udp_bind_ip").val().trim()=='') {
        alert("Enter UDP Bind IP");
    } else if($("#udp_signaling_port").val().trim()==''){
        alert("Enter UDP Signaling Port");
    } else if($("#udp_signaling_protocol").val().trim()==''){
        alert("Enter corresponding SIP server IP");
    } else if($("#udp_media_port").val().trim()==''){
        alert("Enter Corresponding SIP server  port.");
    } else if($("#udp_media_protocol").val().trim()==''){
        alert("Enter iufp.");
    } else if($("#tcp_bind_ip").val().trim()==''){
        alert("Enter IBCP");
    } else if($("#tcp_signaling_port").val().trim()==''){
        alert("Enter Start channel");
    } else if($("#tcp_signaling_protocol").val().trim()==''){
        alert("Enter END channel");
    } else if($("#tcp_media_port").val().trim()==''){
        alert("Enter Corresponding SIP server IP");
    } else if($("#tcp_media_protocol").val().trim()==''){
        alert("Enter corresponding SIP server port.");
    } else if($("#log_level").val().trim()==''){
        alert("Enter iufp");
    } else if($("#log_destination").val().trim()==''){
        alert("Enter IBCP");
    }else if($("#rcportal_control_udp_port").val().trim()==''){
        alert("Enter iufp");
    } else if($("#log_tcp_port").val().trim()==''){
        alert("Enter IBCP");
    } else {

        var flag1 = IPAddressOnly($('#udp_bind_ip').val());
        var flag2 = IPAddressOnly($('#tcp_bind_ip').val());

        if (flag1 && flag2){

            var response = connectServerWithForm(cms_url['configuration_info'], form_id);
            response = JSON.parse(response);
            if (response.status) {
                alertMessage(this, 'green', 'Successful ( Title from configuration_info.js)', response.message);
            } else {
                alertMessage(this, 'red', 'Unsuccessful', response.message);
            }

//alert(response);
        }

        return true;
    }
    return false;

}


/*============== delete operation===========================
 * delete edited by Talemul for added confirmation.
 * =========================================================*/
function delete_soft_config(obj, action_id) {

    confirmMessage(this, 'soft_config_yes', 'Delete Confirmation', 'Do you want to delete ?');
    var arrayInput = new Array(obj, action_id);
    $('#soft_config_yes').click({id: arrayInput}, delete_confirm_soft_config);

}
function delete_confirm_soft_config(event) {
    var arrayInput = event.data.id;
    var dataInfo = {}
    dataInfo['action'] = 'delete';
    dataInfo['action_id'] = arrayInput[1];

    var response = connectServer(cms_url['configuration_info'], dataInfo);
    response = JSON.parse(response);
    if (response.status) {
        showUserMenu('softswitch_configuration_view');
        alertMessage(this, 'green', 'Successful', response.message);
    }else {
        alertMessage(this, 'red', '', 'Failed.');
    }

}


function parse_softswitch_config_data(){
    var response_of_user_info = connectServerWithForm(cms_url['view_configuration_info'], 'edit_configuration_info');
    var response = JSON.parse(response_of_user_info);
    if(response.status){
        var data = response.map;
        $.each(data, function(i, item){
            $("#"+i).val(item);
            //alert("Mine is " + i + "|" + item + "|" + item);
        });

    } else {
        alertMessage(this, 'red', '', 'Failed to read the conf.ini!');
    }
    return true;
}
