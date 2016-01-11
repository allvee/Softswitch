/**
 *
 * Edited by Talemul Islam on 5/23/2015
 */
 /** =========================================================for view ,edit,and delete====================================================== */
function table_initialize_dialplan_info() {

    $('#tbl_view_table').html('<table class="table table-striped table-bordered table-hover responsive" id="dataTables_dialplan_info" width="100%"><tr><td  align="center"><img src="softswitch/img/31.gif"></td></tr></table>');
}

function report_menu_start_dialplan_info() {
//alert();
    var dataSet = [[]];
    var dataInfo = {};
    //dataInfo['uid'] = 'test@test.com';
    dataSet = connectServer(cms_url['view_dialplan_info'], dataInfo);
    //  alert(dataSet);
    dataSet = JSON.parse(dataSet);
    //alert(dataSet);
    table_data_dialplan_info(dataSet);


}


function table_data_dialplan_info(dataSet) {
    // "bFilter": false,
    //alert(dataSet);
    $('#dataTables_dialplan_info').dataTable({
        "data": dataSet,
        "columns": [
            {"title": "Context Name", "class": "center"},
            {"title": "ANO Pattern", "class": "center"},
            {"title": "BNO Pattern", "class": "center"},
            {"title": "Destination Context", "class": "center"},
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
/*function edit_input_form_dialplan_info(obj, data) {
//read table data.
    var dataArray = [];
    var table = document.getElementById('dataTables_dialplan_info');
    var index = obj.parentNode.parentNode.rowIndex;
    var i = 0;
    for (i = 0; i < 4; i++)
        dataArray[i] = table.rows[index].cells[i].innerHTML;
    // show api edit form.
    display_content_custom("104", "#modalData");
// set default value which is read from table

$('#remane_button_wa').html('Update');

    $('#action').val("update");
    $('#action_id').val(data);
    $("#dial_plan_name option[value='" + dataArray[0] + "']").attr('selected', true);
    $('#dial_plan_ano').val(dataArray[1]);
    $('#dial_plan_bno').val(dataArray[2]);
    $("#dial_plan_des option[value='" + dataArray[3] + "']").attr('selected', true);

    dropdown_chosen_style();

}
 */

//////////////////////////////////for insertion//////////////////////////////////////

function add_dial_plan_info() {

    form_id = "softswitch_dial_plan";
    // call connectServerWithForm with a php url and for id
    var response = connectServerWithForm(cms_url['add_dial_plan_info'], form_id);
    response = JSON.parse(response);

    if (response.status) {
        alertMessage(this, 'green', 'Successful', response.message);
    } else {
        alertMessage(this, 'red', 'Unsuccessful', response.message);
    }
    showUserMenu('softswitch_dial_plan_add');
 /*   var action = $('#action').val();
    if (action == 'update') {
        showUserMenu('softswitch_dial_plan_view');
    }*/
}
//////////////////////////////////////////////////////////////////////////////////////	


/*============== delete operation===========================
 * delete edited by Talemul for added confirmation.
 * =========================================================*/
/*
function delete_dialplan_info(obj, action_id) {

    confirmMessage(this, 'dialplan_info_yes', 'Delete Confirmation', 'Do you want to delete ?');
    var arrayInput = new Array(obj, action_id);
    $('#dialplan_info_yes').click({id: arrayInput}, delete_confirm_dialplan_info);

}
function delete_confirm_dialplan_info(event) {
    var arrayInput = event.data.id;
    var dataInfo = {}
    dataInfo['action'] = 'delete';
    dataInfo['action_id'] = arrayInput[1];

    var response = connectServer(cms_url['add_dial_plan_info'], dataInfo);
    response = JSON.parse(response);
    if (response.status) {
        showUserMenu('softswitch_dial_plan_view');
        alertMessage(this, 'green', 'Successful', response.message);
    }else {
        alertMessage(this, 'red', '', 'Failed.');
    }

}
*/




