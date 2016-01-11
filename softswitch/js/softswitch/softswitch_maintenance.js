
function softswitch_main_start() {
    var data = {};
    var rs = confirm("Are you sure you want to start?");
    data['command'] = "start";
    if (rs) {

        var returnValue = connectServer(cms_url['softswitch_maintenance'], data, false);
        alert(returnValue);
        var result = returnValue.replace("ospfd", "ospf");
       // $("#command_output_box").append(result).scrollTop($("#command_output_box")[0].scrollHeight);

    }
}

function softswitch_main_stop() {
    var data = {};
    var rs = confirm("Are you sure you want to stop?");
    data['command'] = "stop";
    if (rs) {

        var returnValue = connectServer(cms_url['softswitch_maintenance'], data, false);
        var result = returnValue.replace("ospfd", "ospf");
       // $("#command_output_box").append(result).scrollTop($("#command_output_box")[0].scrollHeight);
 
    }
}