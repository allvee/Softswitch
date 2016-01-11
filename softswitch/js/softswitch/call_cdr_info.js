



function table_initialize_call_cdr() {

   $('#tbl_view_table').html('<table class="table table-striped table-bordered table-hover responsive" id="dataTables_call_cdr" width="100%"><tr><td  align="center"><img src="softswitch/img/31.gif"></td></tr></table>');

}


function report_menu_start_call_cdr() {

    var dataSet = [[]];
    var dataInfo = {};

    dataSet = connectServer(cms_url['show_call_cdr'], dataInfo);
    //  alert(dataSet);
  // dataSet = JSON.parse(dataSet);
    //alert(dataSet);
    table_data_call_cdr(dataSet);

    data_table_responsive();  // datatable responsive ot defined
                //return false;
}



function table_data_call_cdr(dataSet) {
    // "bFilter": false,
   // alert(dataSet);
    $('#dataTables_call_cdr').dataTable({
        "data": dataSet,
        "columns": [
            {"title": "total_no_of_call", "class": "center"},
            {"title": "minimum_call_duration", "class": "center"},
			{"title": "maximum_call_duration", "class": "center"},
            {"title": "average_call_duration", "class": "center"},
            {"title": "total_established_call", "class": "center"},
        ],
        "order": [[0, "asc"]],
        dom: 'T<"clear">lfrtip',
        tableTools: {
            "sSwfPath": "softswitch/img/datatable/swf/copy_csv_xls_pdf.swf",
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

function softswitch_call_cdr(){
               // var form_id = "obd_dashboard_list";
                
				//var response = JSON.parse(connectServerWithForm(cms_url['show_obd_dashboard'],form_id ));
                
                                
                table_initialize_call_cdr();
                report_menu_start_call_cdr();
                //return false;
                
}