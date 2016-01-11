/**
 *
 * Edited by Talemul Islam on 5/23/2015
 */
/** =========================================================for view ,edit,and delete====================================================== */
function table_initialize_route_info() {

    $('#tbl_view_table').html('<table class="table table-striped table-bordered table-hover responsive" id="dataTables_route_info" width="100%"><tr><td  align="center"><img src="softswitch/img/31.gif"></td></tr></table>');
}

function report_menu_start_route_info() {
//alert();
    var dataSet = [[]];
    var dataInfo = {};
    dataSet = connectServer(cms_url['parse_route_info'], dataInfo);
    dataSet = JSON.parse(dataSet);
    table_data_route_info(dataSet);


}


function table_data_route_info(dataSet) {
    $('#dataTables_route_info').dataTable({
        "data": dataSet,
        "columns": [
	     {"title": "ID", "class": "center"},
            {"title": "Source IP", "class": "center"},
            {"title": "Source Port", "class": "center"},
            {"title": "Source Protocol", "class": "center"},
            {"title": "Destination IP", "class": "center"},
            {"title": "Destination Port", "class": "center"},
            {"title": "Destination Protocol", "class": "center"},
            {"title": "Route type", "class": "center"},
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

function softswitch_ippbx_routes_controller() {

    if ($("#source_ip").val().trim() == '') {
        alert("Enter Source IP");
    } else if ($("#source_port").val().trim() == '') {
        alert("Enter Source Port");
    } else if ($("#source_protocol").val().trim() == '') {
        alert("Enter Source Protocol");
    } else if ($("#destination_ip").val().trim() == '') {
        alert("Enter Destination IP");
    } else if ($("#destination_port").val().trim() == '') {
        alert("Enter Destination Port");
    } else if ($("#destination_protocol").val().trim() == '') {
        alert("Enter Destination Protocol");
    } else if ($("#route_type").val().trim() == '') {
        alert("Enter Route Type");
    } else if ($("#context_name").val().trim() == '') {
        alert("Enter Context Name");
    } else {

       // var flag1 = IPAddressOnly($('#source_ip').val());
       // var flag2 = IPAddressOnly($('#destination_ip').val());

      //  if (flag1 && flag2) {
         
            var response = connectServerWithForm(cms_url['add_route_info'], 'softswitch_ippbx_route');
  		//alert(response);
         
             response = JSON.parse(response);
            if (response.status) {
                alertMessage(this, 'green', 'Successful', response.message);
            } else {
                alertMessage(this, 'red', 'Unsuccessful', response.message);
            }



    //    }

        return true;
    }
    return false;


}
/*
function parse_softswitch_routes() {

    var response_of_user_info = connectServerWithForm(cms_url['view_route_info'], 'softswitch_ippbx_route');
    var response = JSON.parse(response_of_user_info);
    if (response.status) {
        var data = response.map;
        $.each(data, function (i, item) {
            if (i == 'source_protocol') {
                var chosen_source_protocol = item;
                $("#source_protocol option[value='" + chosen_source_protocol + "']").attr('selected', true);
                $("#source_protocol").trigger("chosen:updated");
            } else if (i == 'destination_protocol') {
                var chosen_destination_protocol = item;
                $("#destination_protocol option[value='" + chosen_destination_protocol + "']").attr('selected', true);
                $("#destination_protocol").trigger("chosen:updated");
            } else if (i == 'route_type') {
                var chosen_route_type = item;
                $("#route_type option[value='" + chosen_route_type + "']").attr('selected', true);
                $("#route_type").trigger("chosen:updated");
            } else if (i == 'context_name') {
                var chosen_context_name = item;
                $("#context_name option[value='" + chosen_context_name + "']").attr('selected', true);
                $("#context_name").trigger("chosen:updated");
            } else {
                $("#" + i).val(item);
            }


            //alert("Mine is " + i + "|" + item + "|" + item);
        });

    } else {
        alertMessage(this, 'red', '', 'Failed to read the routes.ini!');
    }
    return true;


}

*/
/* =====================================================
 * edit function. for read all row
 * =====================================================*/

 function edit_input_form_route_info(obj, data) {
 var dataArray = [];
 var table = document.getElementById('dataTables_route_info');
 var index = obj.parentNode.parentNode.rowIndex;
 var i = 0;
 for (i = 0; i < 8; i++)
 dataArray[i] = table.rows[index].cells[i].innerHTML;

   display_content_custom("1706", "#modalData");
 $('#action').val("update");
 $('#submit').html("Update");

 $('#action_id').val(dataArray[0]);
 $('#source_ip').val(dataArray[1]);
 $('#source_port').val(dataArray[2]);
 $("#source_protocol option[value='" + dataArray[3] + "']").attr('selected', true);
 $('#destination_ip').val(dataArray[4]);
 $('#destination_port').val(dataArray[5]);
 $("#destination_protocol option[value='" + dataArray[6] + "']").attr('selected', true);
 $("#route_type option[value='" + dataArray[7] + "']").attr('selected', true);
 $("#context_name option[value='" + dataArray[8] + "']").attr('selected', true);

 dropdown_chosen_style();

 }
 




/////////////////////////////////////////////for add/////////////////////////////////////


/*

function softswitch_ippbx_routes_controller() {
    form_id = "softswitch_ippbx_route";
    var action = $('#action').val();

    var source_ip = $('#source_ip').val();
    var destination_ip = $('#destination_ip').val();
    var flag = true;
    flag = flag && IPAddressOnly(source_ip) && IPAddressOnly(destination_ip);

    if (flag) {
        var add_route_info = connectServerWithForm(cms_url['add_route_info'], form_id);
        response = JSON.parse(add_route_info);
        //alert(response);
        
         if (response.status) {
         alertMessage(this, 'green', 'Successful', response.message);
         if (action == 'insert') {
         showUserMenu('softswitch_route_add');
         } else {
         showUserMenu('softswitch_route_view');
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

 function delete_route_info(obj, action_id) {

 confirmMessage(this, 'route_info_yes', 'Delete Confirmation', 'Do you want to delete ?');
 var arrayInput = new Array(obj, action_id);
 $('#route_info_yes').click({id: arrayInput}, delete_confirm_route_info);

 }

 function delete_confirm_route_info(event) {
 var arrayInput = event.data.id;
 var dataInfo = {}
 dataInfo['action'] = 'delete';
 dataInfo['action_id'] = arrayInput[1];

 var response = connectServer(cms_url['add_route_info'], dataInfo);
 response = JSON.parse(response);
 if (response.status) {
 showUserMenu('softswitch_route_view');
 alertMessage(this, 'green', 'Successful', response.message);
 } else {
 alertMessage(this, 'red', '', 'Failed.');
 }
showUserMenu('softswitch_route_view')
 }

 
