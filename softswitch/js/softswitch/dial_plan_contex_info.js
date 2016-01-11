/**
 *
 * Edited by Talemul Islam on 5/23/2015
 */
 
 /*=========================================================for view ,edit,and delete======================================================*/
function table_initialize_dial_plan_context_info() {

    $('#tbl_view_table').html('<table class="table table-striped table-bordered table-hover responsive" id="dataTables_dial_plan_context_info" width="100%"><tr><td  align="center"><img src="softswitch/img/31.gif"></td></tr></table>');
}

function report_menu_start_dial_plan_context_info() {
//alert();
    var dataSet = [[]];
    var dataInfo = {};
    //dataInfo['uid'] = 'test@test.com';
    dataSet = connectServer(cms_url['view_dial_plan_context_info'], dataInfo);
    //  alert(dataSet);
    dataSet = JSON.parse(dataSet);
    //alert(dataSet);
    table_data_dial_plan_context_info(dataSet);


}


function table_data_dial_plan_context_info(dataSet) {
    // "bFilter": false,
    //alert(dataSet);
    $('#dataTables_dial_plan_context_info').dataTable({
        "data": dataSet,
        "columns": [
            {"title": "Context Name", "class": "center"},
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




/* =====================================================
 * edit function. for read all row
 * =====================================================*/
function edit_input_form_dial_plan_context_info(obj, data) {
//read table data.
    var dataArray = [];
    var table = document.getElementById('dataTables_dial_plan_context_info');
    var index = obj.parentNode.parentNode.rowIndex;
    var i = 0;
    for (i = 0; i < 1; i++)
        dataArray[i] = table.rows[index].cells[i].innerHTML;
    // show api edit form.
	display_content_custom("103", "#modalData");
// set default value which is read from table

$('#remane_button_wa').html('Update');

	$('#action').val("update");
	$('#action_id').val(data);
    $('#dial_plan_context_name').val(dataArray[0]);

    dropdown_chosen_style();
}


 


///////////////////////////////////for add//////////////////////////////////////////////////
	function add_dial_plan_context_info() {
		form_id="edit_dial_plan_contet_user_info";

		var add_dial_plan_context_info = connectServerWithForm(cms_url['add_dial_plan_context_info'],form_id );
		response = JSON.parse(add_dial_plan_context_info);

		if (response.status) {
			alertMessage(this, 'green', 'Successful', response.message);
		} else {
			alertMessage(this, 'red', 'Unsuccessful', response.message);
		}

        var action=$('#action').val();
        if(action=='update'){
            showUserMenu('softswitch_dial_context_view');
        }

	
	}
 
 
 
 
/*============== delete operation===========================
 * delete edited by Talemul for added confirmation.
 * =========================================================*/
function delete_dial_plan_context_info(obj, action_id) {

    confirmMessage(this, 'dial_plan_context_info_yes', 'Delete Confirmation', 'Do you want to delete ?');
    var arrayInput = new Array(obj, action_id);
    $('#dial_plan_context_info_yes').click({id: arrayInput}, delete_confirm_dial_plan_context_info);

}
function delete_confirm_dial_plan_context_info(event) {
    var arrayInput = event.data.id;
    var dataInfo = {}
    dataInfo['action'] = 'delete';
    dataInfo['action_id'] = arrayInput[1];

    var response = connectServer(cms_url['add_dial_plan_context_info'], dataInfo);
    response = JSON.parse(response);
    if (response.status) {
        showUserMenu('softswitch_dial_context_view');
        alertMessage(this, 'green', 'Successful', response.message);
    }else {
        alertMessage(this, 'red', '', 'Failed.');
    }

}
