/**
 * Created by Plabon Dutta on 26-Jul-15.
 */



function check_box_value_changed(){
    if($("#authentication").is(":checked"))
        document.getElementById('hidden_div').style.display = 'block';
        //$("#hidden_div").style.display = 'block';
    else
    //$("#hidden_div").style.display = 'none';
        document.getElementById('hidden_div').style.display = 'none';
}

function save_soft_gw() {

    var flag1 = IPAddressOnly($('#soft_gw_ip').val());

    var form_id = 'soft_gateway_conf';
    //cms_url['vpn_l2tp_save_action']

    // call connectServerWithForm with a php url and for id

    if (flag1) {
        var response_of_user_info = connectServerWithForm(cms_url['add_soft_gw'], form_id);
         
        response_of_user_info=JSON.parse(response_of_user_info);

        if (!response_of_user_info.status) {
          
            alertMessage(this, 'red', '', 'Fail!');
        } else {
            alertMessage(this, 'green', '', 'Successfully Submitted.');
            if($('#action').val()=="update"){
                showUserMenu('softswitch_gateway_view');
            }



        }
    }

}

function edit_soft_gw(obj, info) {

    var data = info.split("|");

 display_content_custom('1713', '#modalData');

    $('#action_id').val(data[0]);
    $('#action').val("update");
    $('#soft_inbound_gw').val(data[1]);

    $('#soft_ano_max').val(data[2]);

    $('#soft_ano_min').val(data[3]);

    $('#soft_bno_max').val(data[4]);
    $('#soft_bno_min').val(data[5]);

    $('#soft_outbound_gw').val(data[6]);

    dropdown_chosen_style();


}


function table_initialize_soft_gw() {

    $('#tbl_view_table').html('<table class="table table-striped table-bordered table-hover responsive" id="dataTables_softswitch_gw" width="100%"><tr><td  align="center"><img src="softswitch/img/31.gif"></td></tr></table>');

}


function report_menu_start_soft_gw() {
//alert();
    var dataSet = [[]];
    var dataInfo = {};
    //dataInfo['uid'] = 'test@test.com';
    dataSet = connectServer(cms_url['view_soft_gw'], dataInfo);
    //  alert(dataSet);
    dataSet = JSON.parse(dataSet);
    //alert(dataSet);
    table_data_soft_gw(dataSet);

}


function table_data_soft_gw(dataSet) {
    // "bFilter": false,
    //alert(dataSet);
    $('#dataTables_softswitch_gw').dataTable({

        "data": dataSet,
        "columns": [
            {"title": "ID", "class": "center"},
            {"title": "Name", "class": "center"},
            {"title": "IP", "class": "center"},
            {"title": "Port", "class": "center"},
	     {"title": "EP-type", "class": "center"},
            {"title": "User Name", "class": "center"},
            {"title": "Password", "class": "center"},
            {"title": "Type", "class": "center"},
            {"title": "Action", "class": "center"},
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

function delete_soft_gw(obj, action_id) {

    confirmMessage(this, 'soft_gw', 'Delete Confirmation', 'Do you want to delete ?');
    var arrayInput = new Array(obj, action_id);
    $('#soft_gw').click({id: arrayInput}, delete_confirm_soft_gw);

}
function delete_confirm_soft_gw(event) {
    var arrayInput = event.data.id;
    var dataInfo = {}
    dataInfo['action'] = 'delete';
    dataInfo['action_id'] = arrayInput[1];

    var response = connectServer(cms_url['add_soft_gw'], dataInfo);
    response =JSON.parse(response);
    if (response.status) {
        showUserMenu('softswitch_gateway_view');
        alertMessage(this, 'green', 'Successful', response.message);
    }else {
        alertMessage(this, 'red', '', 'Failed.');
    }

}

