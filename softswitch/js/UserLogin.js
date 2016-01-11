/**
 * Created by Mazhar on 3/10/2015.
 */

function UserLoginAction() {

    var returnValue = connectServerWithForm(cms_url['UserLogin'], 'UserLoginForm');


    returnValue = JSON.parse(returnValue);

    if (returnValue.status) {
        //alertMessage(this, 'green', 'Congratulation', returnValue.msg);
        var auth_session_data = JSON.stringify(returnValue.read);
        setSession(auth_session_data, 'cms_auth');

        //create_recharge_history_table();
        setTimeout(function () {
            redirect_to(site_host)
        }, 1000);
    } else {
        message_alert(returnValue.msg,'error');
        //alertMessage(this, 'red', 'Failed', returnValue.msg);
    }
}

/*function create_recharge_history_table(){

 table_initialize_recharge_history("tbl_view_resellers","dataTablesRechargeHistory");
 recharge_history_create("Partner", "dataTablesRechargeHistory");
 }*/

function table_initialize_recharge_history(div_id, table_id) {
    var div_name = "#" + div_id;
    $(div_name).html('<table class="table table-striped table-bordered table-hover responsive" id="' + table_id + '" width="100%"><tr><td  align="center"><img src="dhakagate/img/31.gif"></td></tr></table>');
}

function recharge_history_create(type, table_id) {

    var dataSet = [[]];
    var dataInfo = {};
    dataInfo['type'] = type;
    dataSet = connectServer(cms_url['dhakagate_recharge_history'], dataInfo);
    //  alert(dataSet);
    dataSet = JSON.parse(dataSet);
    //alert(dataSet);
    table_data_recharge_history(dataSet, table_id);
    $(".nowrap2").css("width", "20%");
    $(".nowrap3").css("width", "25%");

}

function table_data_recharge_history(dataSet, table_id) {
    var table_name = "#" + table_id;
    $(table_name).dataTable({

        "data": dataSet,
        "columns": [
            {"title": "Serial No.", "class": "center"},
            {"title": "Sent By", "class": "center"},
            {"title": "Cell Number", "class": "center"},
            {"title": "Amount", "class": "center"},
            {"title": "Type", "class": "center"},
            {"title": "Transaction ID", "class": "center"},

        ],
        "order": [[0, "asc"]],
        dom: 'T<"clear">lfrtip',
        tableTools: {
            "sSwfPath": "dhakagate/img/datatable/swf/copy_csv_xls_pdf.swf",
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


function showDashboardInfo() {

    var auth_session_data = checkSession('cms_auth');
    var auth_data = JSON.parse(auth_session_data);

    var login_date_time = return_local_time();

    $('#login_date_time').html(login_date_time);
    $('#login_user_name').html(auth_data.name);
    $('#login_user_amount').html(auth_data.fund);
    $('#login_user_id').html(auth_data.uid);
    //getBalance();
}


function updateDashboardInfo(balance) {

    var auth_session_data = checkSession('cms_auth');
    var auth_data = JSON.parse(auth_session_data);

    auth_data.fund = parseInt(balance);

    auth_session_data = JSON.stringify(auth_data);
    setSession(auth_session_data, 'cms_auth');

    showDashboardInfo();
}