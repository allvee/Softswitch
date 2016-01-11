/**
 * Created by Rakibul on 5/13/2015.
 */

function table_initialize_bwc_client_rules() {

    $('#tbl_view_table').html('<table class="table table-striped table-bordered table-hover responsive" id="dataTables_bwc_client_rules" width="100%"><tr><td  align="center"><img src="rcportal/img/31.gif"></td></tr></table>');

}

function table_bwc_client_rules_dataset(dataSet) {
     //alert(dataSet);
    $('#dataTables_bwc_client_rules').dataTable({

        "data": dataSet,
        "columns": [
            {"title": "RuleId", "class": "center"},
            {"title": "Src Address", "class": "center"},
            {"title": "Dst Address", "class": "center"},
            {"title": "Dst Port", "class": "center"},
            {"title": "Mac", "class": "center"},
            {"title": "Percentage", "class": "center"},
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

function view_client_bwc_rules(obj,action_id) {
    //alert();
    var dataSet = [[]];
    var cid = action_id;
    //alert(cid);
    //dataInfo['uid'] = 'test@test.com';

    dataSet = connectServer(cms_url['bwc_client_rules_table_view'], cid);
     //alert(dataSet);
    dataSet = JSON.parse(dataSet);
    //alert(dataSet);
    table_initialize_bwc_client_rules();
    table_bwc_client_rules_dataset(dataSet);

    //console.log("dana");
}



