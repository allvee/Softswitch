



function table_initialize_log_management() {

   $('#tbl_view_table').html('<table class="table table-striped table-bordered table-hover responsive" id="dataTables_log_management" width="100%"><tr><td  align="center"><img src="softswitch/img/31.gif"></td></tr></table>');

}


function report_menu_start_log_management() {

    var dataSet = [[]];
    var dataInfo = {};

    dataInfo['log_server_time_from'] = $("#log_server_time_from").val();
    dataInfo['log_server_time_to'] = $("#log_server_time_to").val();
    dataInfo['source'] = $("#source").val();
    dataInfo['type'] = $("#type").val();
    dataInfo['source_timestamp_from'] = $("#source_timestamp_from").val();
    dataInfo['source_timestamp_to'] = $("#source_timestamp_to").val();
    dataInfo['from_user'] = $("#from_user").val();
    dataInfo['to_user'] = $("#to_user").val();
    dataInfo['call_id'] = $("#call_id").val();
    dataInfo['caller_callee'] = $("#caller_callee").val();
    dataInfo['source_ip'] = $("#source_ip").val();
    dataInfo['source_port'] = $("#source_port").val();
    dataInfo['functionName'] = $("#functionName").val();
    dataInfo['audio_ip'] = $("#audio_ip").val();
    dataInfo['audio_port'] = $("#audio_port").val();
    dataInfo['video_ip'] = $("#video_ip").val();
    dataInfo['video_port'] = $("#video_port").val();
    dataInfo['function_point'] = $("#function_point").val();
    dataInfo['comment'] = $("#comment").val();
    dataInfo['sip'] = $("#sip").val();
    try {
        dataSet = connectServer(cms_url['show_log_management'], dataInfo);
        dataSet = JSON.parse(dataSet);


    }catch(exception){


    }


    //alert(dataSet);
    table_data_log_management(dataSet);

    data_table_responsive();  // datatable responsive ot defined
                //return false;
}



function table_data_log_management(dataSet) {
    // "bFilter": false,
    //alert(dataSet[0][0]);
    $('#dataTables_log_management').dataTable({
        "data": dataSet,
        "columns": [
            {"title": "Log Server Time", "class": "center"},
            {"title": "Source", "class": "center"},
			{"title": "Type", "class": "center"},
            {"title": "Source Timestamp", "class": "center"},
            {"title": "From User", "class": "center"},
			{"title": "To user", "class": "center"},
            {"title": "Call id", "class": "center"},
			{"title": "Caller Callee", "class": "center"},
            {"title": "Source IP", "class": "center"},
            {"title": "Source port", "class": "center"},
			{"title": "Function name", "class": "center"},
            {"title": "Audio IP", "class": "center"},
			{"title": "Audio port", "class": "center"},
            {"title": "Video Ip", "class": "center"},
            {"title": "Video port", "class": "center"},
			{"title": "Function point", "class": "center"},
			{"title": "Comment", "class": "center"},
            {"title": "SIP", "class": "center"},
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

function softswitch_log_onsbmt(){

                table_initialize_log_management();
                report_menu_start_log_management();

                
}