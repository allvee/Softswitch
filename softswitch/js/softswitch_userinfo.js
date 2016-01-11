/**
 * Created by Talemul on 4/27/2015.
 */



/* =====================================================
 * Table Initialize
 * =====================================================*/

function table_initialize_user_info() {

    $('#rcportal_user_info').html('<table class="table table-striped table-bordered table-hover responsive" id="dataTables_rcportal_user_info" width="100%"><tr><td  align="center"><img src="rcportal/img/31.gif"></td></tr></table>');

}


function table_data_user_info(dataSet) {
    // "bFilter": false,
    //alert(dataSet);
    $('#dataTables_rcportal_user_info').dataTable({

        "data": dataSet,
        "columns": [
            {"title": "User ID", "class": "center"},
            {"title": "UserID", "class": "center"},
            {"title": "User Name", "class": "center"},

            {"title": "Password", "class": "center"},
            {"title": "Email", "class": "center"},
            {"title": "User Type", "class": "center"},

            {"title": "Last Update", "class": "center"},
            {"title": "Action", "class": "center"}
        ],
        "order": [[0, "asc"]],
        dom: 'T<"clear">lfrtip',
        tableTools: {
            "sSwfPath": "rcportal/img/datatable/swf/copy_csv_xls_pdf.swf",
            "sRowSelect": "multi",
            "aButtons": [
                "select_all", "select_none", "copy", "csv",
                {
                    "sExtends": "xls",
                    "sFileName": "*.xls"
                }
            ],
            "filter": "applied"
        }
    });
}


function report_menu_start_user_info() {
//alert();
    var dataSet = [[]];
    var dataInfo = {};
    dataInfo['uid'] = 'test@test.com';
    dataSet = connectServer(cms_url['rcportal_user_info'], dataInfo);
    //  alert(dataSet);
    dataSet = JSON.parse(dataSet);
    //alert(dataSet);
    table_data_user_info(dataSet);
/*============== for hidden colmn ====================
* if response plugin is enable, then this hidden method is not work.
* 
    var table = $('#dataTables_rcportal_user_info').DataTable();
    table.columns(3).visible(false);
    table.columns(4).visible(false);*/

}


/* =====================================================
 * edit function. for read all row
 * =====================================================*/
function edit_input_form_user_info(obj, data) {
//read table data.
    var dataArray = [];
    var table = document.getElementById('dataTables_rcportal_user_info');
    var index = obj.parentNode.parentNode.rowIndex;
    var i = 0;
    for (i = 0; i < 7; i++)
        dataArray[i] = table.rows[index].cells[i].innerHTML;
    // show api edit form.
    displayContent("64", "#cmsData", "#contentListLayout", "ContentID");
// set default value which is read from table
    $('#user_info_user_id').val(dataArray[0]);
    $('#user_info_user_id_text').html(dataArray[0]);
    $('#user_info_UserID').val(dataArray[1]);
    $('#user_info_UserName').val(dataArray[2]);
    $('#user_info_Email').val(dataArray[4]);
    $('#user_info_LastUpdate').val(dataArray[6]);
    // selected item makes true.
    $("#user_info_UserType option[value='" + dataArray[5] + "']").attr('selected', true);
// call chosen-select function for enable stylish select box.

    rcportal_DatePicker('user_info_LastUpdate');
    dropdown_chosen_style();

}
/*===================================================================================
 * update data
 *==================================================================================== */
function edit_controller_user_info(form_id) {
    // call connectServerWithForm with a php url and for id
    var response_of_user_info = connectServerWithForm(cms_url['rcportal_user_info_edit'], form_id);

    // call api_info_dhakagate page.
    showUserMenu('rcportal_user_info');
    // alert message for success.
    message_alert(response_of_user_info,'green');

}



/*============== delete operation===========================
 * delete
 * =========================================================*/
function delete_user_info(obj, data) {
    var dataArray = [];
    var table = document.getElementById('dataTables_rcportal_user_info');
    var index = obj.parentNode.parentNode.rowIndex;
    var i = 0;
    for (i = 0; i < 5; i++)
        dataArray[i] = table.rows[index].cells[i].innerHTML;
    confirmMessage(this, 'user_info_yes', 'Delete Confirmation', 'Do you want to delete ' + dataArray[2] + ' from User Info?');
    var arrayInput = new Array(obj, data);
    $('#user_info_yes').click({id: arrayInput}, delete_confirm_user_info);

}
function delete_confirm_user_info(event) {
    var arrayInput = event.data.id;

    var returnValue = '';
    var dataInfo = {};
    dataInfo['deleted_user_id'] = arrayInput[1];

    returnValue = connectServer(cms_url['rcportal_user_info_delete'], dataInfo);

    var table = $('#dataTables_rcportal_user_info').DataTable();
    table.row($(arrayInput[0]).parents('tr')).remove().draw();

    message_alert(returnValue, 'green');
}

