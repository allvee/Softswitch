function softswitch_stop(){
  var data = {};
  data['cmd'] = 'stop';
  var res = connectServer(cms_url['softswitch_maintenance'], data,false);
  $("#command_output_box").append(res).scrollTop($("#command_output_box")[0].scrollHeight);
}

function softswitch_start(){
  var data = {};
  data['cmd'] = 'start';
  var res = connectServer(cms_url['softswitch_maintenance'], data,false);
  $("#command_output_box").append(res).scrollTop($("#command_output_box")[0].scrollHeight);
}


function softswitch_reload(){
  var data = {};
  data['cmd'] = 'restart';
  var res = connectServer(cms_url['softswitch_maintenance'], data,false);
  $("#command_output_box").append(res).scrollTop($("#command_output_box")[0].scrollHeight);
}

function softswitch_refresh(){
	
	$("#command_output_box").html("");
}
