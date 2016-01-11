/**
 * Created by Rakibul on 5/13/2015.
 */

function table_initialize_bwc_client() {

    $('#tbl_view_table').html('<table class="table table-striped table-bordered table-hover responsive" id="dataTables_bwc_client" width="100%"><tr><td  align="center"><img src="rcportal/img/31.gif"></td></tr></table>');

}

function table_bwc_client_dataset(dataSet) {
    // "bFilter": false,
    //alert(dataSet);
    // "bFilter": false,
    //alert(dataSet);
    $('#dataTables_bwc_client').dataTable({

        "data": dataSet,
        "columns": [
            {"title": "Name", "class": "center"},
            {"title": "GroupName", "class": "center"},
            {"title": "PackageID", "class": "center"},
            {"title": "Upload", "class": "center"},
            {"title": "Download", "class": "center"},
            {"title": "Brust", "class": "center"},
            {"title": "Max Upload", "class": "center"},
            {"title": "Max Download", "class": "center"},
            {"title": "Priority", "class": "center"},
            {"title": "View Rules", "class": "center"},
            {"title": "Action", "class": "center"},
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

function report_bwc_client() {
//alert();
    var dataSet = [[]];
    var dataInfo = {};
    //dataInfo['uid'] = 'test@test.com';

    dataSet = connectServer(cms_url['bwc_client_table_view'], dataInfo);
    //  alert(dataSet);
    dataSet = JSON.parse(dataSet);
    //alert(dataSet);
    table_initialize_bwc_client();
    table_bwc_client_dataset(dataSet);

    //console.log("dana");
}

function save_client(){

    var action = $("#action").val();
    var form_id = "bwc_client";
    var action_id = "";
    //alert(cms_url['bwc_client_save_action']);
    if (action == 'insert') {
        var response = connectServerWithForm(cms_url['bwc_client_save_action'], form_id,false);
        if (parseInt(response) == 0) {
            alertMessage(this, 'green', '', 'Successfully Submitted.');
            showUserMenu('bwc_client_add');
        } else {
            alertMessage(this, 'red', '', 'Failed.');
        }
    }
    else {
        var response = connectServerWithForm(cms_url['bwc_client_save_action'], form_id,false);
        if (parseInt(response) == 0) {
            alertMessage(this, 'green', '', 'Successfully Submitted.');
            showUserMenu('bwc_client_view');
        } else {
            alertMessage(this, 'red', '', 'Failed.');
        }

    }

}

function edit_input_form_bwc_client(obj, action_id) {
   var dataArray = [];
    var clientInfo='';
    var dataInfo = {}
    var count='';
   // dataInfo['action'] = 'update';
    dataInfo['action_id'] = action_id;
    clientInfo = connectServer(cms_url['rcportal_bwc_edit_client'], dataInfo);

    Client = $.parseJSON(clientInfo);
    console.log(Client);

    showUserMenu('bwc_client_add');
    $("#bwc_info_Group option[value='" + Client.groupName + "']").attr('selected', true);
    $('#bwc_info_ClientName').val(Client.clientName);
    $("#bwc_info_TimePackage option[value='" + Client.packageId + "']").attr('selected', true);
    $('#bwc_info_Download').val(Client.downLoad);
    $('#bwc_info_Upload').val(Client.upLoad);
    $('#bwc_info_DestinationIp_1').val(dataArray[11]);
    $("#bwc_info_Brust option[value='" + Client.brust + "']").attr('selected', true);
    $("#bwc_info_Priority option[value='" + Client.priority + "']").attr('selected', true);
    $('#bwc_info_MinDownload').val(Client.max_downLoad);
    $('#bwc_info_MinUpload').val(Client.max_upLoad);
    $('#bwc_info_SourceIp').val(Client.rules[0].src);
    $('#bwc_info_DestinationIp_1').val(Client.rules[0].dst);
    $('#bwc_info_DestinationPort_1').val(Client.rules[0].port);
    $('#bwc_info_Mac').val(Client.rules[0].mac);
    $('#destination_ip_value_1').val(Client.rules[0].percentage);
    $('#bwc_info_Mark').val(Client.rules[0].mark);

    for(count =1; count < Client.rules.length; count++)
    {
     //   console.log(Client.rules[count]);
        html_data_nt = '<div class="row formTableRow" >';
        html_data_nt += '<div class="frmLblNameAcc col-md-3"> Destination IP </div>';
        html_data_nt += '<div class="frmFldAcc col-md-2">';
        html_data_nt += '<input type="text" id="bwc_info_DestinationIp_' + count + '"  name="bwc_info_DestinationIp_' + count + '" style="width: 100%" value="'+ Client.rules[count].dst+'" placeholder="" required="required">';
        html_data_nt += '</div>';
        html_data_nt += '<div class="frmLblNameAcc col-md-2"> Destination Port </div>';
        html_data_nt += '<div class="frmFldAcc col-md-1" >';
        html_data_nt += '<input type="text" id="bwc_info_DestinationPort_' + count + '"  name="bwc_info_DestinationPort_' + count + '" style="width: 100%" value="'+ Client.rules[count].port+'" placeholder="" required="required">';
        html_data_nt += '</div>';

        html_data_nt += '<div class="frmFldAcc col-md-2">';
        html_data_nt += '<select id="destination_ip_type_' + count + '" class="chosen-select" required="required"  name="destination_ip_type_' + count + '" style="width: 100%">';
        html_data_nt += '<option value="Bandwidth">Bandwidth</option>';
        html_data_nt += '<option value="Percentage">Percentage</option>';
        html_data_nt += '</select>';
        html_data_nt += '</div>';

        html_data_nt += '<div class="frmFldAcc col-md-1" >';
        html_data_nt += '<input type="text" id="destination_ip_value_' + count + '"  name="destination_ip_value_' + count + '" style="width: 100%" value="'+Client.rules[count].percentage+'" placeholder="" required="required">';
        html_data_nt += '</div>';

        html_data_nt += '<div>';
        html_data_nt += '<input type="hidden" id="test_id"  name="test_id" style="width: 100%" value="' + count + '" placeholder="" required="required">';
        html_data_nt += '</div>';

        html_data_nt += '<div class="col-md-1">';
        html_data_nt += '<button type="button" value="" class="remove_destination_ip btn_minus">';
        html_data_nt += '</button>';
        html_data_nt += '</div>';

        html_data_nt += '<div class="row formTableRow" id="destination_ip' + count + '">';
        html_data_nt += '</div>';
        html_data_nt += '</div>';

        $(html_data_nt).insertAfter('#dest');
    }

    $('#submit').html('Update');

     $("#action").val('update');
    $("#action_id").val(Client.clientId);

    $('input[name^=bwc_info_DestinationIp_]').keyup();

   // dropdown_chosen_style();
}


function delete_bwc_client(obj, action_id) {
    var dataInfo = {}
    dataInfo['action'] = 'delete';
    dataInfo['action_id'] = action_id;
    var response = connectServer(cms_url['bwc_client_save_action'], dataInfo,false);
    if (parseInt(response) == 0) {
        alertMessage(this, 'green', '', 'Successfully Deleted.');
        showUserMenu('bwc_client_view');
    } else {
        alertMessage(this, 'red', '', 'Failed.');
    }

}

//$('input[name^=bwc_info_DestinationIp]').map(function(){return $(this).val()}).get().join('|');

$(document).on('click', '.destination_ip_add_button', function ()
{
    var current_value=$('#test_id').val();
    current_value++;
    //alert(current_value);
    $('#test_id').val(current_value);
    var html_data_nt = '';

    html_data_nt = '<div class="row formTableRow" >';
    html_data_nt += '<div class="frmLblNameAcc col-md-3"> Destination IP </div>';
    html_data_nt += '<div class="frmFldAcc col-md-2">';
    html_data_nt += '<input type="text" id="bwc_info_DestinationIp_'+current_value+'"  name="bwc_info_DestinationIp_'+current_value+'" style="width: 100%" value="" placeholder="" required="required">';
    html_data_nt += '</div>';
    html_data_nt += '<div class="frmLblNameAcc col-md-2"> Destination Port </div>';
    html_data_nt += '<div class="frmFldAcc col-md-1" >';
    html_data_nt += '<input type="text" id="bwc_info_DestinationPort_'+current_value+'"  name="bwc_info_DestinationPort_'+current_value+'" style="width: 100%" value="" placeholder="" required="required">';
    html_data_nt += '</div>';

    html_data_nt += '<div class="frmFldAcc col-md-2">';
    html_data_nt += '<select id="destination_ip_type_'+current_value+'" class="chosen-select" required="required"  name="destination_ip_type_'+current_value+'" style="width: 100%">';
    html_data_nt += '<option value="Bandwidth">Bandwidth</option>';
    html_data_nt += '<option value="Percentage">Percentage</option>';
    html_data_nt += '</select>';
    html_data_nt += '</div>';

     html_data_nt += '<div class="frmFldAcc col-md-1" >';
     html_data_nt += '<input type="text" id="destination_ip_value_'+current_value+'"  name="destination_ip_value_'+current_value+'" style="width: 100%" value="" placeholder="" required="required">';
     html_data_nt += '</div>';

    html_data_nt += '<div>';
    html_data_nt += '<input type="hidden" id="test_id"  name="test_id" style="width: 100%" value="'+current_value+'" placeholder="" required="required">';
    html_data_nt += '</div>';

     html_data_nt += '<div class="col-md-1">';
     html_data_nt += '<button type="button" value="" class="remove_destination_ip btn_minus">';
     html_data_nt += '</button>';
     html_data_nt += '</div>';

    html_data_nt += '<div class="row formTableRow" id="destination_ip'+current_value+'">';
    html_data_nt += '</div>';
    html_data_nt += '</div>';

    $(html_data_nt).insertBefore('#rowdload');
    /*$("#destination_ip1").append(html_data_nt);
    setTimeout(function() {
        dropdown_chosen_style()
    }, 500);*/
   // alert(html_data_nt);

});


$(document).on('click', '.remove_destination_ip', function () {

    $(this).parent().parent().remove();

    var dest_ips =  $('input[name^=bwc_info_DestinationIp_]').map(function(){return $(this).val()}).get().join('|');
    var dest_ports =  $('input[name^=bwc_info_DestinationPort_]').map(function(){return $(this).val()}).get().join('|');
    var dest_values =  $('input[name^=destination_ip_value_]').map(function(){return $(this).val()}).get().join('|');

    $('input[name=bwc_info_DestinationIp]').val(dest_ips);
    $('input[name=bwc_info_DestinationPort]').val(dest_ports);
    $('input[name=destination_ip_value]').val(dest_values);

});

$(document).on('keyup', 'input[name^=bwc_info_DestinationIp_]', function () {

    var dest_ips =  $('input[name^=bwc_info_DestinationIp_]').map(function(){return $(this).val()}).get().join('|');
    var dest_ports =  $('input[name^=bwc_info_DestinationPort_]').map(function(){return $(this).val()}).get().join('|');
    var dest_values =  $('input[name^=destination_ip_value_]').map(function(){return $(this).val()}).get().join('|');

    $('input[name=bwc_info_DestinationIp]').val(dest_ips);
    $('input[name=bwc_info_DestinationPort]').val(dest_ports);
    $('input[name=destination_ip_value]').val(dest_values);

});

$(document).on('keyup', 'input[name^=bwc_info_DestinationPort_]', function () {

    var dest_ips =  $('input[name^=bwc_info_DestinationIp_]').map(function(){return $(this).val()}).get().join('|');
    var dest_ports =  $('input[name^=bwc_info_DestinationPort_]').map(function(){return $(this).val()}).get().join('|');
    var dest_values =  $('input[name^=destination_ip_value_]').map(function(){return $(this).val()}).get().join('|');

    $('input[name=bwc_info_DestinationIp]').val(dest_ips);
    $('input[name=bwc_info_DestinationPort]').val(dest_ports);
    $('input[name=destination_ip_value]').val(dest_values);

});

$(document).on('keyup', 'input[name^=destination_ip_value_]', function () {

    var dest_ips =  $('input[name^=bwc_info_DestinationIp_]').map(function(){return $(this).val()}).get().join('|');
    var dest_ports =  $('input[name^=bwc_info_DestinationPort_]').map(function(){return $(this).val()}).get().join('|');
    var dest_values =  $('input[name^=destination_ip_value_]').map(function(){return $(this).val()}).get().join('|');

    $('input[name=bwc_info_DestinationIp]').val(dest_ips);
    $('input[name=bwc_info_DestinationPort]').val(dest_ports);
    $('input[name=destination_ip_value]').val(dest_values);

});

