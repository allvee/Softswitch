/**
 * Created by Shiam on 5/18/2015.
 */
//cms_url['call_handler_config']

function parse_vsdp_data(){
    var response_of_user_info = connectServerWithForm(cms_url['call_handler_parse_vsdp'], 'call_handler_vsdp_config');
    var response = JSON.parse(response_of_user_info);
    if(response.status){
        var data=response.map;
        $.each(data, function(i, item){
            $("#"+i).val(item);
            //alert("Mine is " + i + "|" + item + "|" + item);
        });

    }else{
        alertMessage(this, 'red', '', 'fail to read the vsdp.ini !');
    }
    return true;
}


/**
 * IP address, Net Mask
 * And Gateway Validation
 */
function IPAddressOnly_ch(val,type) {
    val = typeof val !== 'undefined' ? val : "";
    type = typeof type !== 'undefined' ? type : "ip";
    var val_arr = val.split(".");
    if( val_arr.length != 4 ||
        (parseInt(val_arr[0])< 1 || parseInt(val_arr[0]) > 255) ||
        (parseInt(val_arr[1])< 0 || parseInt(val_arr[1]) > 255) ||
        (parseInt(val_arr[2])< 0 || parseInt(val_arr[2]) > 255) ||
        (type == "g" && (parseInt(val_arr[3]) < 1 || parseInt(val_arr[3]) > 254)) ||
        (type == "ip" && (parseInt(val_arr[3]) < 0 || parseInt(val_arr[3]) > 255))
    ){
        alertMessage(this,'yellow','',"Wrong IP address " + val);
        return false;
    }
    return true;
}

function call_handler_vsdp(){

    var response_of_user_info = connectServerWithForm(cms_url['call_handler_vsdp_config'], 'call_handler_vsdp_config');

    /*if (response_of_user_info == 1) {
        alertMessage(this, 'red', '', 'fail !');
    } else {
        alertMessage(this, 'green', '', 'Success');
    }
    return true;*/

    if($('#SIGNALING_PROTOCOL').val().trim()=="") {
        alert("Enter the signaling protocol.");

    } else if( $('#MACHINEID').val().trim()=="" ) {
        alert("Enter the Machine ID.");

    } else if( $('#START_CHANNEL').val().trim()=="" ) {
        alert("Enter the start channel.");

    } else if( $('#END_CHANNEL').val().trim()=="" ) {
        alert("Enter the END channel.");

    } else if( $('#BROD_START_CHANNEL').val().trim()=="" ) {
            alert("Enter the broad START channel.");

    } else if( $('#BROD_END_CHANNEL').val().trim()=="" ) {
        alert("Enter the broad END channel.");

    }  else if( $('#NO_SIGNAL_CHANNEL').val().trim()=="" ) {
        alert("Enter the NO SIGNAL channel.");

    } else if( $('#VM_ENABLED').val().trim()=="" ) {
        alert("VM_ENABLED is empty.");

    } else if( $('#LOG_ENABLED').val().trim()=="" ) {
        alert("LOG_ENABLED is empty.");

    } else if( $('#FILETRACK_ENABLED').val().trim()=="" ) {
        alert("FILETRACK_ENABLED is empty.");

    } else if( $('#ENABLE_REL_CALL').val().trim()=="" ) {
        alert("Enter the Enable REL Call.");

    } else if( $('#COT_ENABLED').val().trim()=="" ) {
        alert("COT_ENABLED empty.");

    } else if( $('#ADDR_COMP_PATCH').val().trim()=="" ) {
        alert("ADDR_COMP_PATCH empty.");

    } else if( $('#PATCH_SELF').val().trim()=="" ) {
        alert("PATCH_SELF is empty.");

    } else if( $('#CRBT_SERVICE_NO').val().trim()=="" ) {
        alert("Enter the CRBT service NO");

    } else if( $('#VM_SERVICE_NO').val().trim()=="" ) {
        alert("Enter the VM service NO");

    } else if( $('#RECORD_BIT_RATE').val().trim()=="" ) {
        alert("Enter the record bit RATE");

    } else if( $('#SKIP_ENABLE').val().trim()=="" ) {
        alert("SKIP ENABLE empty.");

    } else if( $('#SKIP_KEY').val().trim()=="" ) {
        alert("Enter the SKIP_KEY.");

    } else if( $('#BACK_KEY').val().trim()=="" ) {
        alert("Enter the BACK_KEY.");

    } else if( $('#NO_VOICE_TIME').val().trim()=="" ) {
        alert("Enter the NO VOICE TIME.");

    } else if( $('#MAX_REC_TIME').val().trim()=="" ) {
        alert("Enter MAX REL TIME.");

    } else if( $('#PLACECALL_EXTEN_ENABLED').val().trim()=="" ) {
        alert("PlacecCall exten enable  empty.");

    } else if( $('#CDRPATH').val().trim()=="" ) {
        alert("Enter the CDR path.");

    } else if( $('#FILETRACK').val().trim()=="" ) {
        alert("Enter file track");

    } else if( $('#LOG_DIRNAME').val().trim()=="" ) {
        alert("Enter LOG DIRNAME.");

    } else if( $('#NODELOG_DIRNAME').val().trim()=="" ) {
        alert("Enter NODELOG_DIRNAME.");

    } else if( $('#PATCH_DIRNAME').val().trim()=="" ) {
        alert("Enter PATCH_DIRNAME.");

    } else if( $('#HTTP_HOST_IP').val().trim()=="" ) {
        alert("Enter HOST IP");

    } else if( $('#CALLHANDLER_HTTP_PORT').val().trim()=="" ) {
        alert("Enter Call Handler HTTP PORT");

    } else if( $('#DebugGetContent').val().trim()=="" ) {
        alert("DebugGEtContent empty.");

    } else if( $('#INIT_URL').val().trim()=="" ) {
        alert("Enter INIT_URL.");

    } else if( $('#OUT_DIAL_URL').val().trim()=="" ) {
        alert("Enter OUT DIAL URL.");

    } else if( $('#REL_URL').val().trim()=="" ) {
        alert("Enter REL URL.");

    } else if( $('#MAVM_URL').val().trim()=="" ) {
        alert("Enter MAVM URL");

    } else if( $('#SERVICE_URL').val().trim()=="" ) {
        alert("Enter service URL");

    } else if( $('#LOGNO1').val().trim()=="" ) {
        alert("LOGNO1 empty.");

    } else if( $('#LOGNO2').val().trim()=="" ) {
        alert("LOGNO2 empty.");

    } else if( $('#LOGNO3').val().trim()=="" ) {
        alert("LOGNO3 empty.");

    } else if( $('#Listen_port').val().trim()=="" ) {
        alert("Listen Port empty.");

    } else if( $('#CGW_HOST_IP').val().trim()=="" ) {
        alert("Enter the CGW HOST IP");

    } else if( $('#CGW_PORT').val().trim()=="" ) {
        alert("Enter the CGW port.");

    } else if( $('#channelutilize').val().trim()=="" ) {
        alert("Enter the channel utilize.");

    } else if( $('#RATECODE_ENABLED').val().trim()=="" ) {
        alert("Enter the RATECODE ENABLE value.");

    } else if( $('#CGW_ENABLED').val().trim()=="" ) {
        alert("Enter the CGW Enable value.");

    }else if( $('#PARALLEL_CHARGING_REQUEST_ENABLED').val().trim()=="" ) {
        alert("Enter the parallel charging request.");

    } else if( $('#MAXSESSIONDURATION_ENABLED').val().trim()=="" ) {
        alert("MAXSESSIONDURATION ENABLED empty.");

    } else if( $('#MAXSESSIONDURATION_URL').val().trim()=="" ) {
        alert("MAXSESSIONDURATION URL empty.");

    } else if( $('#CHARGING_TIMEOUT').val().trim()=="" ) {
        alert("Enter charging Timeout.");

    } else if( $('#CDRWRITE_INTERVAL').val().trim()=="" ) {
        alert("Enter CDR interval.");

    } else if( $('#CDRWRITE_SLEEP').val().trim()=="" ) {
        alert("Enter CDRWRITE Sleep.");

    } else if( $('#MEDIA_SERVER').val().trim()=="" ) {
        alert("Enter media server.");

    } else if( $('#SIP_SERVER_IP').val().trim()=="" ) {
        alert("Enter SIP server IP");

    } else if( $('#MEDIA_SERVER_IP').val().trim()=="" ) {
        alert("Enter Media server IP.");

    } else if( $('#RTP_PORT_START').val().trim()=="" ) {
        alert("Enter RTP PORT START.");

    } else if( $('#WAV_FILE_LAW').val().trim()=="" ) {
        alert("");

    } else if( $('#SIP_SERVER_DOMAIN').val().trim()=="" ) {
        alert("Enter SIP Server Domain");

    } else if( $('#LOG_LEVEL').val().trim()=="" ) {
        alert("Enter LOG level.");

    } else if( $('#LOG_DESTINATION').val().trim()=="" ) {
        alert("Enter LOG Destination.");

    } else if( $('#RTP_PLAYFILE_SLEEP').val().trim()=="" ) {
        alert("Enter playfile sleep.");

    } else if( $('#SIGNALLING_SERVER_PORT').val().trim()=="" ) {
        alert("Enter SIGNALLING SERVER PORT.");

    } else if( $('#PTHREAD_STACK_SIZE_NETWORK_KB').val().trim()=="" ) {
        alert("Enter PTHREAD STACK SIZE NETWORK KB.");

    } else if( $('#PTHREAD_STACK_SIZE_KB').val().trim()=="" ) {
        alert("Enter PTHREAD STACK SIZE KB.");

    } else if( $('#DEFAULT_PAYLOAD_TYPE_VOICE').val().trim()=="" ) {
        alert("Enter DEFAULT PAYLOAD TYPE VOICE.");

    } else if( $('#DEFAULT_PAYLOAD_TYPE_DTMF').val().trim()=="" ) {
        alert("Enter DEFAULT PAYLOAD TYPE DTMF.");

    } else if( $('#SNMP_INSTANCE_NAME').val().trim()=="" ) {
        alert("Enter SNMP INSTANCE NAME.");

    } else if( $('#SNMP_ENABLED').val().trim()=="" ) {
        alert("SNMP ENABLE empty.");

    } else if( $('#SNMP_MANAGER_HOST_IP').val().trim()=="" ) {
        alert("Enter SNMP MANAGER HOST IP");

    } else if( $('#SNMP_MANAGER_PORT_NO').val().trim()=="" ) {
        alert("Enter SNMP MANAGER PORT NO");

    } else if( $('#SNMP_LOCAL_IP').val().trim()=="" ) {
        alert("Enter SNMP LOCAL IP");

    } else if( $('#SNMP_LOCAL_PORT').val().trim()=="" ) {
        alert("Enter SNMP LOCAL PORT");

    } else if( $('#SNMP_AGENT_IP').val().trim()=="" ) {
        alert("Enter SNMP AGENT IP");

    } else if( $('#WEBSERVER_TIMEOUT').val().trim()=="" ) {
        alert("WEBSERVER TIMEOUT empty.");

    } else if( $('#NODELOG_ENABLED').val().trim()=="" ) {
        alert("Enter NODELOG ENABLED");

    } else if( $('#RTP_MAX_GAP').val().trim()=="" ) {
        alert("Enter RTP MAX GAP");

    } else if( $('#RELEASE_ON_RTP_MAX_GAP').val().trim()=="" ) {
        alert("Enter RELEASE ON RTP MAX GAP");

    } else if( $('#RTP_GAP_FILLUP_ENABLE').val().trim()=="" ) {
        alert("Enter RTP GAP FILLUP ENABLE");

    } else if( $('#SERIAL_NUM').val().trim()=="" ) {
        alert("Enter SERIAL NUM");

    } else if( $('#acuStream').val().trim()=="" ) {
        alert("Enter acuStream");

    } else if( $('#NUM_OF_CHANNELS_TO_ALLOCATE_PER_MODULE').val().trim()=="" ) {
        alert("Enter NUM OF CHANNELS TO ALLOCATE PER MODULE");

    } else if( $('#SEND_200OK_WITHOUT_IUFP').val().trim()=="" ) {
        alert("Enter SEND_200OK_WITHOUT_IUFP");

    } else if( $('#BoardIPAddr').val().trim()=="" ) {
        alert("Enter BoardIPAddr");

    } else if( $('#TPNCPServerIPAddr').val().trim()=="" ) {
        alert("Enter TPNCP Server IP Addr");

    } else if( $('#ERROR_PLAYFILELOG').val().trim()=="" ) {
        alert("Enter ERROR PLAYFILE LOG");

    } else if( $('#ANSWERED_OBD_ENABLE').val().trim()=="" ) {
        alert("Enter answered OBD Enable.");

    } else if( $('#onlyPatch').val().trim()=="" ) {
        alert("Enter only patch value.");

    } else if( $('#maintainSeq').val().trim()=="" ) {
        alert("Enter Maintain Seq.");

    } else if( $('#VIDEO_BROD_START_CHANNEL').val().trim()=="" ) {
        alert("Enter VIDEO BROD START CHANNEL.");

    } else if( $('#VIDEO_BROD_END_CHANNEL').val().trim()=="" ) {
        alert("Enter VIDEO BROD END CHANNEL.");

    } else if( $('#patchedDigitEnable').val().trim()=="" ) {
        alert("patchedDigitEnable empty.");

    } else if( $('#reportPacketEnable').val().trim()=="" ) {
        alert("Enter reportPakcetEnable.");

    } else if( $('#PARSE_IUFP_INIT').val().trim()=="" ) {
        alert("Enter PARSE IUFP INIT");

    } else if( $('#STATIC_FOR_OBD').val().trim()=="" ) {
        alert("Enter STATIC FOR OBD.");
    } else  {
        var response_of_user_info = connectServerWithForm(cms_url['call_handler_config'], "call_handler_vsdp_config");

        if (response_of_user_info == 1) {
            alertMessage(this, 'red', '', 'fail !');
        } else {
            alertMessage(this, 'green', '', 'Success');
        }
        return true;
    }
    return false;
}

function parse_chMap_data(){
    var response_of_user_info = connectServerWithForm(cms_url['call_hander_parse_chMap'], 'call_handler_chMap_config');
    var response = JSON.parse(response_of_user_info);
    if(response.status){
        var data = response.map;
        $.each(data, function(i, item){
            $("#"+i).val(item);
            //alert("Mine is " + i + "|" + item + "|" + item);
        });

    } else {
        alertMessage(this, 'red', '', 'fail to read the chMap.ini!');
    }
    return true;
}

function call_handler_chMap() {

    if($("#chMap_start_Channel").val().trim()=='') {
        alert("Enter start Channel");
    } else if($("#chMap_End_Channel").val().trim()==''){
        alert("Enter End channel");
    } else if($("#chMap_Corrosponding_Sip_Server_IP").val().trim()==''){
        alert("Enter corresponding SIP server IP");
    } else if($("#chMap_Corrosponding_Sip_Server_Port").val().trim()==''){
        alert("Enter Corresponding SIP server  port.");
    } else if($("#chMap_IUFP").val().trim()==''){
        alert("Enter iufp.");
    } else if($("#chMap_IBCP").val().trim()==''){
        alert("Enter IBCP");
    } else if($("#chMap_start_Channel2").val().trim()==''){
        alert("Enter Start channel");
    } else if($("#chMap_End_Channel2").val().trim()==''){
        alert("Enter END channel");
    } else if($("#chMap_Corrosponding_Sip_Server_IP2").val().trim()==''){
        alert("Enter Corresponding SIP server IP");
    } else if($("#chMap_Corrosponding_Sip_Server_Port2").val().trim()==''){
        alert("Enter corresponding SIP server port.");
    } else if($("#chMap_IUFP2").val().trim()==''){
        alert("Enter iufp");
    } else if($("#chMap_IBCP2").val().trim()==''){
        alert("Enter IBCP");
    } else {
        var response_of_user_info = connectServerWithForm(cms_url['call_handler_chMap_config'], 'call_handler_chMap_config');

        if (response_of_user_info == 1) {
            alertMessage(this, 'red', '', 'fail !');
        } else {
            alertMessage(this, 'green', '', 'Success');
        }
        return true;
    }
    return false;
}

function parse_iufp_data(){
    //alert("iufp parse hit");
    var response_of_user_info = connectServerWithForm(cms_url['call_handler_parse_iufp'], 'call_handler_iufp_config');
    var response = JSON.parse(response_of_user_info);
    if(response.status){
        var data = response.map;
        $.each(data, function(i, item){
            $("#"+i).val(item);
            //alert("Mine is " + i + "|" + item + "|" + item);
        });

    } else {
        alertMessage(this, 'red', '', 'fail to read the chMap.ini!');
    }
    return true;
}

function call_handler_iufp() {
    //alert("iufp hit");
    if($("#iufp_InitMasterInfo_BYTE").val().trim()==''){
        alert("Enter init master BYTE");

    } else if($("#iufp_RFCI_BYTE").val().trim()=='') {
        alert("Enter RFCI BYTE");

    } else if($("#iufp_IPTI_BYTE").val().trim()=='') {
        alert("Enter IPTI BYTE");

    } else if($("#iufp_IUModeSupport_short").val().trim()=='') {
        alert("Enter UI mode support Short");

    } else if($("#iufp_DataPDUType").val().trim()=='') {
        alert("Enter Data PDUType");

    } else {
        var response_of_user_info = connectServerWithForm(cms_url['call_handler_iufp_config'], 'call_handler_iufp_config');

        if (response_of_user_info == 1) {
            alertMessage(this, 'red', '', 'fail !');
        } else {
            alertMessage(this, 'green', '', 'Success');
        }
        return true;
    }
    return false;
}

