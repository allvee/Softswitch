/**
 * Created by Monir
 */


/* =====================================================
 * Table Initialize
 * =====================================================*/

function table_initialize_firewall_log() {

    $('#tbl_view_table').html('<table class="table table-striped table-bordered table-hover responsive bootstrap-datatable datatable" id="dataTables_rcportal_firewall_log" width="100%"><tr><td  align="center"><img src="rcportal/img/31.gif"></td></tr></table>');

}

function report_menu_start_firewall_log() {
//alert();
    var dataSet = [[]];
    var dataInfo = {};
    //dataInfo['uid'] = 'test@test.com';
    dataSet = connectServer(cms_url['rcportal_firewall_log_show'], dataInfo);
    //alert(dataSet);
    dataSet = JSON.parse(dataSet);
    //alert(dataSet);
    table_data_firewall_log(dataSet);
    data_table_responsive();
}


function table_data_firewall_log(dataSet) {
    $('#dataTables_rcportal_firewall_log').dataTable({
        "data": dataSet,
        "columns": [
            {"title": "IP", "class": "center"},
            {"title": "Rule", "class": "center"},
            {"title": "Action", "class": "center"}
        ],
        "order": [[0, "asc"]],
        dom: 'T<"clear">lfrtip',
        tableTools: {
            "sSwfPath": "rcportal/img/datatable/swf/copy_csv_xls_pdf.swf",
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


function enable_log() {
    $.ajax({
        type: 'GET',
        url: "/cmd-log/fw/fw-log.php",
        async: false,
        data: {'cmd': 'enable'},
        success: function (value) {
            alert("Firewall Log has been enabled!");
            showUserMenu('diagnosis_firewall');
        },
        error: function (jqXHR, textStatus, errorThrown) {
            genericError(jqXHR, textStatus, errorThrown);
        }
    });
}


function disable_log() {
    $.ajax({
        type: 'GET',
        url: "/cmd-log/fw/fw-log.php",
        async: false,
        data: {'cmd': 'disable'},
        success: function (value) {
            alert("Firewall Log has been disabled!");
            showUserMenu('diagnosis_firewall');
        },
        error: function (jqXHR, textStatus, errorThrown) {
            genericError(jqXHR, textStatus, errorThrown);
        }
    });
}


function show_firewall_log_rule(obj, ip, rule) {
    var dataSet = '';
    var dataInfo = {};
    dataInfo['rule'] = rule;
    //dataInfo['uid'] = 'test@test.com';
    dataSet = connectServer(cms_url['rcportal_firewall_log_rule_show'], dataInfo);
    alertMessage(this, 'green', 'Rule for: '+ip,dataSet);
    
}