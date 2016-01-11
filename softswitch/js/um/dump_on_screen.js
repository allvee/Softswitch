

function edit_controller_screen_dump(){
 
	var data = {};
	var src_ip = $("#src_ip").val();
	var dest_ip = $("#dest_ip").val();
	var port = $("#port").val();
	var capture_size = $("#capture_size").val();
	var tcpdump_interface = $("#tcpdump_interface").val();
	
	data['src'] = src_ip;
	data['dest'] = dest_ip;
	data['port'] = port;
	data['cap'] = capture_size;
	data['interface'] = tcpdump_interface;
	data['type'] = 'screen';
       var res = connectServer(cms_url['rcportal_get_tcpdump_exec'], data,false);
       $("#command_output_box").html(res).scrollTop($("#command_output_box")[0].scrollHeight);
        
   // response = JSON.parse(response);


}

function tcpdump_on_file(){
	var data = {};
	var src_ip = $("#src_ip").val();
	var dest_ip = $("#dest_ip").val();
	var port = $("#port").val();
	var capture_size = $("#capture_size").val();
	var tcpdump_interface = $("#tcpdump_interface").val();
	var file_name = $("#file_name").val();
	data['src'] = src_ip;
	data['dest'] = dest_ip;
	data['port'] = port;
	data['cap'] = capture_size;
	data['interface'] = tcpdump_interface;
       data['file_name'] = file_name; 
	data['type'] = 'filewrite';
       
       if( src_ip !="" || src_ip != null ){
       	if(!IPAddressOnly(src_ip)){
           		return;
       	}
	}
       
	if( dest_ip != "" || dest_ip != null){
       	if(!IPAddressOnly(dest_ip)){
           		return;
       	}
	}
       
       var res = connectServer(cms_url['rcportal_get_tcpdump_exec'], data,false);
       
       if(res == 0){
		alertMessage(this, 'green', '', 'File Dump Successful');
		showUserMenu('diagnosis_dump_file');
	}else{
		alertMessage(this, 'red', '', 'File Dump Failed!');
	}
	
}

function delete_selected_file(){
	var data = {};
       var tcpdump_file = $("#tcpdump_file").val();
	data['file_name'] = tcpdump_file;
	data['type'] = 'file_del';
       var res = connectServer(cms_url['rcportal_get_tcpdump_exec'], data,false);
       
	if(res == 0){
		alertMessage(this, 'green', '', 'File Deletion Successful');
		showUserMenu('diagnosis_dump_file');
	}else{
		alertMessage(this, 'red', '', 'File Deletion Failed!');
	}

       
}

function show_tcpdump_from_file(){
	var data = {};

	var tcpdump_file = $("#tcpdump_file").val();
	
	data['file_name'] = tcpdump_file;
	
	data['type'] = 'fileread';
       var res = connectServer(cms_url['rcportal_get_tcpdump_exec'], data,false);
       $("#command_output_box").html(res).scrollTop($("#command_output_box")[0].scrollHeight);
}

/* ==========  show   dump stats ===================================*/
function get_dump_stats(){
       
       var data = {};

	var tcpdump_file = $("#choose_file").val();
       var chart_type  = $("#chart_type").val();
	
	data['file_name'] = tcpdump_file;
	
       var res = connectServer(cms_url['rcportal_get_dump_stats'], data,false);
       
       var datalist =  jQuery.parseJSON(res);
	
	if(chart_type == 'pie'){
		RenderPieChartForPacket('command_output_box',datalist,'Packet Stats','Number of Packet Vs Protocol','Packet');//elementId, dataList, title,subtitle
	}else if(chart_type == 'bar'){
		var category_arr=[];
		$.each(datalist,function(i,val){
								
						category_arr.push(val[0]);
		});
							
	       RenderBarChartForPacket('command_output_box',datalist,category_arr, 'Packet Stats','Number of Packet Vs Protocol','Number of Packets','Packets');
	}


}