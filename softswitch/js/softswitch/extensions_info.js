function table_initialize_dial_plan_info() {

    $('#tbl_view_table').html('<table class="table table-striped table-bordered table-hover responsive" id="dataTables_extensions_info" width="100%"><tr><td  align="center"><img src="softswitch/img/31.gif"></td></tr></table>');

}

function report_menu_start_extensions_info() {
//alert();
    var dataSet = [[]];
    var dataInfo = {};
    //dataInfo['uid'] = 'test@test.com';
    dataSet = connectServer(cms_url['parse_extensions_info'], dataInfo);
    //  alert(dataSet);
    dataSet = JSON.parse(dataSet);
    //alert(dataSet);
    table_data_extensions_info(dataSet);


}



function table_data_extensions_info(dataSet) {
    // "bFilter": false,
    //alert(dataSet);
    $('#dataTables_extensions_info').dataTable({
        "data": dataSet,
        "columns": [
            {"title": "ID", "class": "center"},
            {"title": "User ID", "class": "center"},
            {"title": "Password", "class": "center"},
            {"title": "User type", "class": "center"},
            {"title": "Hardware No", "class": "center"},
            {"title": "Allowed IP", "class": "center"},
            {"title": "Allowed Port", "class": "center"},
            {"title": "FWD If Busy", "class": "center"},
            {"title": "FWD If Unreachable", "class": "center"},
            {"title": "FWD If No Ans", "class": "center"},
            {"title": "RBT NO", "class": "center"},
            {"title": "MCA NO", "class": "center"},
            {"title": "STATUS", "class": "center"},
            {"title": "AAA Ip", "class": "center"},
            {"title": "AAA Port", "class": "center"},
            {"title": "No of Allowed Sessions", "class": "center"},
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




function add_extensions_info() {

    if ($("#basic_user_id").val().trim() == '') {
        alert("Please fill all the necessary fields");
    } else if ($("#basic_pass").val().trim() == '') {
        alert("Please fill all the necessary fields");
    } else if ($("#basic_user_type").val().trim() == '') {
        alert("Please fill all the necessary fields");
    } else if ($("#advance_hw").val().trim() == '') {
        alert("Please fill all the necessary fields");
    } else if ($("#advance_ip").val().trim() == '') {
        alert("Please fill all the necessary fields");
    } else if ($("#advance_port").val().trim() == '') {
        alert("Please fill all the necessary fields");
    } else if ($("#advance_busy").val().trim() == '') {
        alert("Please fill all the necessary fields");
    } else if ($("#advance_unreachable").val().trim() == '') {
        alert("Please fill all the necessary fields");
    } else if ($("#advance_no_ans").val().trim() == '') {
        alert("Please fill all the necessary fields");
    } else if ($("#advance_rbt_no").val().trim() == '') {
        alert("Please fill all the necessary fields");
    } else if ($("#advance_mca_no").val().trim() == '') {
        alert("Please fill all the necessary fields");
    } else if ($("#advance_status").val().trim() == '') {
        alert("Please fill all the necessary fields");
    } else if ($("#advance_aaa_ip").val().trim() == '') {
        alert("Please fill all the necessary fields");
    } else if ($("#advance_aaa_port").val().trim() == '') {
        alert("Please fill all the necessary fields");
    } else if ($("#advance_session").val().trim() == '') {
        alert("Please fill all the necessary fields");
    }else {
       // var flag1 = IPAddressOnly($('#advance_ip').val());
        // var flag2 = IPAddressOnly($('#advance_aaa_ip').val());

      //  if (flag1 && flag2) {

            var response = connectServerWithForm(cms_url['add_extensions_info'], 'softswitch_extension_info');
//alert(response);
            response = JSON.parse(response);
            if (response.status) {
                alertMessage(this, 'green', 'Successful', response.message);
            } else {
                alertMessage(this, 'red', 'Unsuccessful', response.message);
            }

            showUserMenu('softswitch_extensions_add');
     //   }

        return true;
    }
    return false;

}

function edit_input_form_extensions_info(obj, data) {

    var dataArray = [];
    var table = document.getElementById('dataTables_extensions_info');
    var index = obj.parentNode.parentNode.rowIndex;
    var i = 0;
    for (i = 0; i < 15; i++)
        dataArray[i] = table.rows[index].cells[i].innerHTML;

    display_content_custom('1702', '#modalData');

    $('#remane_button_wa').html('Update');

    $('#action').val("update");
    $('#action_id').val(dataArray[0]);



    $('#basic_user_id').val(dataArray[1]);
    $('#basic_pass').val(dataArray[2]);
    $('#basic_user_type').val(dataArray[3]);
    $('#advance_hw').val(dataArray[4])
    $('#advance_ip').val(dataArray[5]);
    $('#advance_port').val(dataArray[6]);
    $('#advance_busy').val(dataArray[7]);
    $('#advance_unreachable').val(dataArray[8]);
    $('#advance_no_ans').val(dataArray[9]);
    $('#advance_rbt_no').val(dataArray[10]);
    $('#advance_mca_no').val(dataArray[11]);
    $('#advance_status').val(dataArray[12]);
    $('#advance_aaa_ip').val(dataArray[13]);
    $('#advance_aaa_port').val(dataArray[14]);
    $('#advance_session').val(dataArray[15]);

 /*   var for_search = dataArray[0] + " " + dataArray[1]+ " " +dataArray[2]+ " "+dataArray[3]+ " "+dataArray[4]+ " "+dataArray[5]+ " " + dataArray[6] + " " + dataArray[7] + " " +dataArray[8] + " " + dataArray[9] + " " + dataArray[10] + " " + dataArray[11] + " " + dataArray[12] + " " + dataArray[13]+ " " + dataArray[14] +  "\n";
    $('#for_search').val(for_search);*/
    dropdown_chosen_style();

}



function delete_extensions_info(obj, action_id) {

    confirmMessage(this, 'extensions_info_yes', 'Delete Confirmation', 'Do you want to delete ?');
    var arrayInput = new Array(obj, action_id);
    $('#extensions_info_yes').click({id: arrayInput}, delete_confirm_extensions_info);

}
function delete_confirm_extensions_info(event) {
    var arrayInput = event.data.id;
    var dataInfo = {}
    dataInfo['action'] = 'delete';
    dataInfo['action_id'] = arrayInput[1];

    var response = connectServer(cms_url['add_extensions_info'], dataInfo);
    response = JSON.parse(response);
    
if (response.status) {
        showUserMenu('softswitch_extensions_view');
        alertMessage(this, 'green', 'Successful', response.message);
    } else {
        alertMessage(this, 'red', '', 'Failed.');
    }


display_content_custom('1702', '#modalData');
}



