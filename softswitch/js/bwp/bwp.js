/**
 * Created by Rakibul on 5/13/2015.
 */

function show_bwp(){
    var dataArray = Array();
    var data = '';
    var dataInfo ={};

    data = connectServer(cms_url['bwp_show_action'], dataInfo);
  //  alert(data);
    dataArray = data.split("|");

    //showUserMenu('bwp_config_add');

    $('#bwp_info_DeviceId').val(dataArray[0]);
    $('#bwp_info_DeviceIp').val(dataArray[1]);
    $('#bwp_info_IdleuserTime').val(dataArray[2]);
    $('#bwp_info_DataLogDirectory').val(dataArray[3]);
    $('#bwp_info_UserLogDirectory').val(dataArray[4]);
    $('#bwp_info__NfqueueNumber').val(dataArray[5]);
    $("#bwp_info_BwpEnable option[value='" + dataArray[6] + "']").attr('selected', true);
    $('#bwp_info_SubnetMask').val(dataArray[7]);
    $('#bwp_info_CdrInterval').val(dataArray[8]);
    $('#bwp_info__CdrLogDirectory').val(dataArray[9]);
    $("#bwp_info_LogLevel option[value='" + dataArray[10] + "']").attr('selected', true);
    $("#bwp_info_CgwEnable option[value='" + dataArray[11] + "']").attr('selected', true);
    $('#bwp_info__CgwDataLimit').val(dataArray[12]);
    $('#bwp_info_CgwLogDirectory').val(dataArray[13]);
    $('#bwp_info_CgwReqDirectory').val(dataArray[14]);
    $('#bwp_info__AppId').val(dataArray[15]);
    $('#bwp_info__AppPassword').val(dataArray[16]);
    //$('#bwp_info_DeviceIp').val(dataArray[17]);
    $('#bwp_info_CgwServerIp').val(dataArray[17]);
    $('#bwp_info_CgwServerPort').val(dataArray[18]);
    $('#bwp_info__Uri').val(dataArray[19]);
    $('#bwp_info__CgwHostname').val(dataArray[20]);
    $('#bwp_info__SelfCareIp').val(dataArray[21]);
    $('#bwp_info_AcceptPort').val(dataArray[22]);

    $('#submit').html('Update');
    //dropdown_chosen_style();
}


function save_bwp(){

    var action = $("#action").val();
    var form_id = "bwp";
    var action_id = "";
    if (action == 'insert') {
        var response = connectServerWithForm(cms_url['bwp_save_action'], form_id);
       // alert(response);
        if (parseInt(response) == 0) {
            alertMessage(this, 'green', '', 'Successfully Submitted.');
           // showUserMenu('bwc_client_add');
        } else {
            alertMessage(this, 'red', '', 'Failed.');
        }
    }

}


function table_initialize_bwp_host(){
	    
		$('#command_output_box').html('<table class="table table-striped table-bordered table-hover responsive" id="bwp_host" width="100%"><tr><td  align="center"><img src="rcportal/img/31.gif"></td></tr></table>');
}
function table_bwp_host_dataset(dataSet){
	
    $('#bwp_host').dataTable({

        "data": dataSet,
        "columns": [
             {"title": "ID", "class": "center"},
            {"title": "Host Name", "class": "center"}
        
           
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


function table_initialize_bwp_all(){
	    
		$('#command_output_box').html('<table class="table table-striped table-bordered table-hover responsive" id="bwp_all" width="100%"><tr><td  align="center"><img src="rcportal/img/31.gif"></td></tr></table>');
}
function table_bwp_dataset(dataSet){
	
    $('#bwp_all').dataTable({

        "data": dataSet,
        "columns": [
            
            {"title": "Mac Address", "class": "center"},
            {"title": "IP Address", "class": "center"},
	     {"title": "Active Session", "class": "center"},
           
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

function get_bwp_command_output(){
	var data = {};
    var cmd = $("#command").val();
	var php_cmd = "";
	var ip = "";
	if( cmd == "status" || cmd == "mac" || cmd == "host" || cmd == "active-session" ){
	    ip = $("#ip_address").val();  
		if(!IPAddressOnly(ip)){
		    return;	
		}
		
		data['ip'] = ip;	
	}
	
	data['cmd'] = cmd;
	
       var res = connectServer(cms_url['get_bwp_command_output'], data,false);
       if(cmd == "status"){
		//alertMessage(this, 'green', '', 'Staus->'+res);
		$("#command_output_box").html(res);

	}else if(cmd == "mac"){
		//alertMessage(this, 'green', '', 'Mac Addres of IP('+ip+') is->'+res);
		$("#command_output_box").html(res);

	}else if(cmd == "host"){
              res = JSON.parse(res);
              table_initialize_bwp_host();
		table_bwp_host_dataset(res);
	      // alertMessage(this, 'green', '', 'Host of IP('+ip+') is->'+res);

	}else if(cmd == "active-session"){
	
		//alertMessage(this, 'green', '', 'Number of Active Session of IP('+ip+') is->'+res);
		$("#command_output_box").html(res);

	}else if(cmd == "active-user"){
		//alertMessage(this, 'green', '', 'Number of Active User is->'+res);
              $("#command_output_box").html(res);


	}else if(cmd == "all"){
           res = JSON.parse(res);
           table_initialize_bwp_all();
	    table_bwp_dataset(res);
		
	}
	
	//$("#command_output_box").html(res);
   
}

function onchange_bwp_command(){

	var cmd = $("#command").val();
       
	if(cmd == "active-user" || cmd == "all"){
		$("#ip_temp1,#ip_temp2").hide();
	}else{
		$("#ip_temp1,#ip_temp2").show();
	}
}


