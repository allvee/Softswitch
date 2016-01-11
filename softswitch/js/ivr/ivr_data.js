
function getIVRdataServerName() {
    createDropDown('dataserverid', cms_url['ivr_data_server_name'], null, '--Select--', '');
	//alert("sdasdsasa");
}


function getIVRdataServiceName() {
	//alert("service");


	createDropDown('service_id', cms_url['ivr_data_service_name'], ["dataserverid"], '--Select--', '');
//	alert("service 2");
	dropdown_chosen_style();
}



//////////////////////////////////////for view////////////////////////////////



function getIVRdataPageName() {
	//alert("service");

   //  alert("service 3");
	createDropDown('page_id', cms_url['ivr_data_page_name'], ["dataserverid","service_id"], '--Select--', '');
	
	dropdown_chosen_style();
}

function search_ivr_data(){
	table_initialize_ivr_data();
	report_menu_start_ivr_data();
}

function table_initialize_ivr_data() {

    $('#tbl_view_table').html('<table class="table table-striped table-bordered table-hover responsive" id="dataTables_ivr_data_info" width="100%"><tr><td  align="center"><img src="rcportal/img/31.gif"></td></tr></table>');
}




function report_menu_start_ivr_data() {

    var dataSet = [[]];
    var dataInfo = {};
	dataInfo['serverid'] = $("#dataserverid").val();
	dataInfo['service_id'] = $("#service_id").val();
	dataInfo['page_id'] = $("#page_id").val();
	 
    dataSet = connectServer(cms_url['rcportal_ivr_data_view'], dataInfo);
     // alert(dataSet);
    dataSet = JSON.parse(dataSet);
    table_ivr_data(dataSet);
}


function table_ivr_data(dataSet) {
        // "bFilter": false,
        //alert(dataSet);
        $('#dataTables_ivr_data_info').dataTable({
            "data": dataSet,
            "columns": [{
                "title": "Current State",
                "class": "center"
            }, {
                "title": "Keypress",
                "class": "center"
            }, {
                "title": "Short Code",
                "class": "center"
            }, {
                "title": "Next State",
                "class": "center"
            }, {
                "title": "Next Key",
                "class": "center"
            },{
                "title": "Action Command",
                "class": "center"
            },{
                "title": "URL",
                "class": "center"
            },{
                "title": "Play File",
                "class": "center"
            }
			],
            "order": [[0, "asc"]],
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

