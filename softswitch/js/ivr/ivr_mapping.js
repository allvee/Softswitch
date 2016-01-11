
function getIVRServerName() {
    createDropDown('serverid', cms_url['ivr_server_name'], null, '--Select--', '');
	dropdown_chosen_style();
}

function search_ivr_mapping(){
	
	//display_content_custom('150', '#modalData');
	table_initialize_ivr_mapping_second()
	//getIVRServerName();
	//$("#serverid").val(serverid);
	report_menu_start_ivr_mapping();
}

    ////////////////////////////////////delete update, view///////////////////////////////
function table_initialize_ivr_mapping() {
	$("#table_title").html("IVR Mapping");
    $("#tbl_view_table").css("overflow", "visible");
    $("#tbl_view_table").html('<div class="frmLblNameAcc col-md-3">*Server:</div><div class="frmFldAcc col-md-3" id="server_info"><select id="serverid" class="chosen-select" name="serverid" style="width: 100%"></select></div><div class="frmFldAcc col-md-3"><button onclick="search_ivr_mapping(); return false;"  type="button"> Load </button></div>');
}

function table_initialize_ivr_mapping_second(){
	$('#second_tbl_view_table').css("overflow","auto");
    $('#second_tbl_view_table').html('<table class="table table-striped table-bordered table-hover responsive" id="dataTables_ivr_mapping" width="100%"><tr><td  align="center"></td></tr></table>');
}

function report_menu_start_ivr_mapping() {

    var dataSet = [[]];
    var dataInfo = {};
    dataInfo['serverid'] = $("#serverid").val();
    dataSet = connectServer(cms_url['rcportal_ivr_mapping_view'], dataInfo);
    //  alert(dataSet);
    dataSet = JSON.parse(dataSet);
    //alert(dataSet);
    table_ivr_mapping(dataSet);
}





function table_ivr_mapping(dataSet) {
        // "bFilter": false,
        //alert(dataSet);
        $('#dataTables_ivr_mapping').dataTable({
            "data": dataSet,
            "columns": [{
                "title": "ano",
                "class": "center"
            }, {
                "title": "bno",
                "class": "center"
            }, {
                "title": "url",
                "class": "center"
            }, {
                "title": "Status",
                "class": "center"
            }, {
                "title": "ProvisionEndDate",
                "class": "center"
            }, {
                "title": "Action",
                "class": "center"
            }],
            "order": [
                [0, "asc"]
            ],
            dom: 'T<"clear">lfrtip',
            tableTools: {
                "sSwfPath": "rcportal/img/datatable/swf/copy_csv_xls_pdf.swf",
                "sRowSelect": "multi",
                "aButtons": [
                    "select_all", "select_none", "copy", "csv", {
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


function edit_input_form_ivr_mapping(obj, data) {
    //read table data.
	//alert(data);
    data_array = data.split("|");
    var dataArray = [];
    var table = document.getElementById('dataTables_ivr_mapping');
    var index = obj.parentNode.parentNode.rowIndex;
    var i = 0;
    for (i = 0; i < 5; i++)
        dataArray[i] = table.rows[index].cells[i].innerHTML;
    // show api edit form.
       display_content_custom("121", "#modalData");
	   getIVRServerName();
	   rcportal_DateTimePicker('provision_end_date');
   
    // set default value which is read from table
    $('#action').val("update");
    $('#action_id').val(data_array[1]);
    $("#serverid").val(data_array[0]);
	

    $('#ano').val(dataArray[0]);
    $('#bno').val(dataArray[1]);
    $('#url').val(dataArray[2]);
    $("#status option[value='" + dataArray[3] + "']").attr('selected', true);
    $('#provision_end_date').val(dataArray[4]);
	$("#save_ivr_mapping").html("Update");
    
    dropdown_chosen_style();

}



/*============== delete operation===========================
 * delete
 * =========================================================*/

function delete_ivr_mapping(obj, action_id) {
    //getIVRServerName();
    //alert(action_id);
    data_array = action_id.split("|");
    var dataInfo = {}
    dataInfo['action'] = 'delete';
    dataInfo['action_id'] = data_array[1];
    dataInfo['serverid'] = data_array[0];

    //alert(dataInfo['serverid']);
    var response = JSON.parse(connectServer(cms_url['save_ivr_mapping'], dataInfo));

    if (response.status) {
        alertMessage(this, 'green', 'Successful', response.message);
        //alert("Deleted Successfully");
        showUserMenu('ivr_ivr_mapping_view');
        $("#serverid").val(data_array[0]);
        report_menu_start_ivr_mapping();
    }

}

function ivr_mapping_add() {
     
	//alert("asdsaas");
	 
	  
	    form_id = "ivr_mapping_config";
        // call connectServerWithForm with a php url and for id
        var ivr_mapping_config = connectServerWithForm(cms_url['save_ivr_mapping'], form_id);

        response = JSON.parse(ivr_mapping_config);

        if (response.status) {
            alertMessage(this, 'green', 'Successful', response.message);
			
			if($("#action").val() == "update"){
				var serverid = $("#serverid").val();
				showUserMenu('ivr_ivr_mapping_view');
				//$("#serverid").val(serverid);
				 $("#serverid option[value='" + serverid + "']").attr('selected', true);
				//alert(serverid);
				search_ivr_mapping();
				dropdown_chosen_style();
			}
        } else {
            alertMessage(this, 'red', 'Unsuccessful', response.message);
        }
		
		
		
		//alert(ivr_mapping_config);
    }
