// JavaScript Document

function Refresh(){
	$("#command_output_box").html("");
}

function show_configuration(){
	var new_window_features = 'directories=no,titlebar=no,toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=no,width=1000, height=600';
    window.open(cms_url['rcportal_um_show_config'], 'UGW Info', new_window_features );
	return false;
}


function show_mac(){
	var dataInfo ={};
	dataInfo['host'] = "arp";
	res = connectServer(cms_url['rcportal_um_show_mac'], dataInfo,false);
	$("#command_output_box").append(res).scrollTop($("#command_output_box")[0].scrollHeight);
	//$("#command_output_box").html(res);
}


function reboot(){
	var dataInfo = {};
	dataInfo["host"] = "reboot";
	
	confirmMessage(this, 'user_info_yes', 'Reboot Confirmation', 'Are you sure you want to reboot?');
    
    $('#user_info_yes').click(function(){
		res = connectServer(cms_url['rcportal_um_show_mac'], dataInfo,false);
		$("#command_output_box").append(res).scrollTop($("#command_output_box")[0].scrollHeight);
		//$("#command_output_box").html(res);
	});
	

}

function Ping(){
	var ping = $("#ping").val();
	var source_interface = $("#source_interface").val();
	var count = $("#count").val();
	var dataInfo ={};
	dataInfo['interface'] = source_interface;
	dataInfo['host'] = ping;
	dataInfo['count'] = count;
	
	if(IPAddressOnly(ping) == false){
	    return;	
	}
	res = connectServer(cms_url['rcportal_um_show_ping'], dataInfo,false);
	$("#command_output_box").append(res).scrollTop($("#command_output_box")[0].scrollHeight);
	//$("#command_output_box").html(res);
}

function shut_down(){
	var dataInfo = {};
	dataInfo["host"] = "poweroff";
	
	confirmMessage(this, 'user_info_yes', 'Shutdown Confirmation', 'Are you sure you want to shutdown?');
    
    $('#user_info_yes').click(function(){
		res = connectServer(cms_url['rcportal_um_show_mac'], dataInfo,false);
		$("#command_output_box").append(res).scrollTop($("#command_output_box")[0].scrollHeight);
		//$("#command_output_box").html(res);
	});
}

function trace_route(){
	var value = $("#trace").val();
	if(IPAddressOnly(value) == false){
	    return;	
	}
	var dataInfo ={};
	dataInfo['host'] = "traceroute "+value;
	res = connectServer(cms_url['rcportal_um_show_mac'], dataInfo,false);
	$("#command_output_box").append(res).scrollTop($("#command_output_box")[0].scrollHeight);
	//$("#command_output_box").html(res);
}

function _blink(){
	var interface = $("#blink_interface").val();
	var time = $("#blink_time").val();
	var dataInfo ={};
	dataInfo['host'] = "ethtool -p "+interface+" "+time;
	res = connectServer(cms_url['rcportal_um_show_mac'], dataInfo,false);
	$("#command_output_box").append(res).scrollTop($("#command_output_box")[0].scrollHeight);
	//$("#command_output_box").html(res);
}