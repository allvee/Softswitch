/**
 * Created by Monir Hossain on 5/06/2015.
 */

function show_softswitch_ippbx_client() {
    var dataArray = Array();
    var clint_setting_info = connectServer(cms_url['show_client_setting_info']);
    dataArray = clint_setting_info.split("|");

    //showUserMenu('softswitch_client_setting');
    if (dataArray.length > 1) {
        $('#action').val("update");
        
        $('#server_ip_cs').val(dataArray[0]);
        $('#udp_server_port').val(dataArray[1]);
        $('#udp_rtp_port').val(dataArray[2]);
        $('#tcp_server_port').val(dataArray[3]);
        $('#tcp_rtp_port').val(dataArray[4]);
        $('#log_server_ip').val(dataArray[5]);
        $('#log_server_port').val(dataArray[6]);
        $('#im_server_ip').val(dataArray[7]);
        $('#im_server_port').val(dataArray[8]);
        $('#contact_server_ip').val(dataArray[9]);
        $('#contact_server_port').val(dataArray[10]);
        $("#connection_type option[value='" + dataArray[11] + "']").attr('selected', true);
        $("#audio_codec option[value='" + dataArray[12] + "']").attr('selected', true);
        $("#rtp_connection_type option[value='" + dataArray[13] + "']").attr('selected', true);
    }

}

function softswitch_ippbx_client_controller() {
    form_id = "softswitch_ippbx_client";

    // call connectServerWithForm with a php url and for id
    var clint_setting_info = connectServerWithForm(cms_url['save_client_setting_info'], form_id);

    response = JSON.parse(clint_setting_info);

    if (response.status) {
        alertMessage(this, 'green', 'Successful', response.message);
    } else {
        alertMessage(this, 'red', 'Unsuccessful', response.message);
    }

}