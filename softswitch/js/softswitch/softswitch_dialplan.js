

function getSoftswitchGwInbound() {
    createDropDown('soft_inbound_gw', cms_url['softswitch_gw_inbound'], null, '--Select--', '');
	}

function getSoftswitchGwOutbound() {
    createDropDown('soft_outbound_gw', cms_url['softswitch_gw_outbound'], null, '--Select--', '');
	}

function save_soft_dialplan()
{

  var form_id = 'soft_dial_plan';
         var soft_dial_plan = connectServerWithForm(cms_url['soft_dial_plan'], form_id);
  
        soft_dial_plan=JSON.parse(soft_dial_plan);

        if (!soft_dial_plan.status) {
          
            alertMessage(this, 'red', '', 'Fail!');
        } else {
            alertMessage(this, 'green', '', 'Successfully Submitted.');
            if($('#action').val()=="update"){
                showUserMenu('softswitch_dial_plan_add');
            }

		}


//alert(soft_dial_plan);
}


function edit_soft_dialPlan(obj, info) {

 showUserMenu('softswitch_dial_plan_add');

    var data = info.split("|");
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

function table_initialize_soft_dialPlan() {

    $('#tbl_view_table').html('<table class="table table-striped table-bordered table-hover responsive" id="dataTables_softswitch_dialPlan" width="100%"><tr><td  align="center"><img src="softswitch/img/31.gif"></td></tr></table>');

}


function report_menu_start_soft_dialPlan() {
//alert();
    var dataSet = [[]];
    var dataInfo = {};
    //dataInfo['uid'] = 'test@test.com';
    dataSet = connectServer(cms_url['view_soft_dialplan'], dataInfo);
    //  alert(dataSet);
    dataSet = JSON.parse(dataSet);
    //alert(dataSet);
    table_data_soft_dialPlan(dataSet);

}



function table_data_soft_dialPlan(dataSet) {
    // "bFilter": false,
    //alert(dataSet);
    $('#dataTables_softswitch_dialPlan').dataTable({

        "data": dataSet,
        "columns": [
            {"title": "ID", "class": "center"},
            {"title": "Inbound", "class": "center"},
            {"title": "Ano Maximum", "class": "center"},
            {"title": "Ano Minimum", "class": "center"},
	     {"title": "Bno Maximim", "class": "center"},
            {"title": "Bno Minimum", "class": "center"},
            {"title": "Outbound", "class": "center"},
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


function delete_soft_dialplan(obj, action_id) {

    confirmMessage(this, 'soft_dialplan', 'Delete Confirmation', 'Do you want to delete ?');
    var arrayInput = new Array(obj, action_id);
    $('#soft_dialplan').click({id: arrayInput}, delete_confirm_soft_dialplan);

}


function delete_confirm_soft_dialplan(event) {
    var arrayInput = event.data.id;
    var dataInfo = {}
    dataInfo['action'] = 'delete';
    dataInfo['action_id'] = arrayInput[1];
    var response = connectServer(cms_url['soft_dial_plan'], dataInfo);
    response =JSON.parse(response);
    if (response.status) {
       showUserMenu('softswitch_dial_plan_view');
        alertMessage(this, 'green', 'Successful', response.message);
    }else {
        alertMessage(this, 'red', '', 'Failed.');
    }

}
