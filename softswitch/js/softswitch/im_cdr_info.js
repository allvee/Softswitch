



function table_initialize_im_cdr() {

   $('#tbl_view_table').html('<table class="table table-striped table-bordered table-hover responsive" id="dataTables_im_cdr" width="100%"><tr><td  align="center"><img src="softswitch/img/31.gif"></td></tr></table>');

}


function report_menu_start_im_cdr() {

    var dataSet = [[]];
    var dataInfo = {};

    dataInfo['slno'] = $("#slno").val();
    dataInfo['callId'] = $("#callId").val();
    dataInfo['ano'] = $("#ano").val();
    dataInfo['bno'] = $("#bno").val();
    dataInfo['call_start_time'] = $("#call_start_time").val();
    dataInfo['call_end_time'] = $("#call_end_time").val();
    dataInfo['machine_id'] = $("#machine_id").val();
    dataInfo['isConnected'] = $("#isConnected").val();
    dataInfo['cause_val'] = $("#cause_val").val();
    dataInfo['cost'] = $("#cost").val();

try {
    var response = connectServer(cms_url['show_im_cdr'], dataInfo);
    if(response) {
        dataSet = JSON.parse(response);
    }
}catch(exception){
    alert("JSON Data could not be parsed !");
}
    table_data_im_cdr(dataSet);

    //data_table_responsive();
                //return false;
}



function table_data_im_cdr(dataSet) {
    // "bFilter": false,
    //alert(dataSet);
    $('#dataTables_im_cdr').dataTable({
        "data": dataSet,
        "columns": [
            {"title": "Serial No", "class": "center"},
            {"title": "Call ID", "class": "center"},
			{"title": "ANO", "class": "center"},
            {"title": "BNO", "class": "center"},
            {"title": "Call Start Time", "class": "center"},
            {"title": "Call End Time", "class": "center"},
            {"title": "Machine ID", "class": "center"},
            {"title": "Is Connected", "class": "center"},
            {"title": "Cause Value", "class": "center"},
            {"title": "Cost", "class": "center"},
            

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

function softswitch_cdr_onsbmt(){

                table_initialize_im_cdr();
                report_menu_start_im_cdr();
                //return false;
                
}