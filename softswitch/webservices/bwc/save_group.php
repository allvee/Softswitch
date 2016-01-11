<?php
header('Access-Control-Allow-Origin: *');
//session_start();
require_once "../lib/common.php";
require_once "../lib/filewriter.php";
//$dir = "../../etc/sysconfig/network-scripts/";

//$info = $_POST["info"];

$cn = connectDB();

$is_error = 0;
$last_updated = date('Y-m-d H:i:s');
$last_updated_by = $_SESSION["USER_ID"];

if (isset($_REQUEST['info'])) {
    $data = $_REQUEST['info'];
    $action = $data['action'];
    $action_id = $data['action_id'];
}else if (isset($_POST) && isset($_POST['action']) && isset($_POST['action_id'])){
    $action = mysql_real_escape_string(htmlspecialchars($_POST['action']));
    $action_id = mysql_real_escape_string(htmlspecialchars($_POST['action_id']));
    $group_name = mysql_real_escape_string(htmlspecialchars($_REQUEST['bwc_info_GroupName']));
    $bwc_bandwidth = mysql_real_escape_string(htmlspecialchars($_REQUEST['bwc_info_Bandwidth']));
    $bwc_limit = mysql_real_escape_string(htmlspecialchars($_REQUEST['bwc_info_Limit']));
    $bwc_priority = mysql_real_escape_string(htmlspecialchars($_REQUEST['bwc_info_Priority']));
    $bwc_que = mysql_real_escape_string(htmlspecialchars($_REQUEST['bwc_info_Que']));
    $bwc_mode = mysql_real_escape_string(htmlspecialchars($_REQUEST['bwc_info_Mode']));

    $bwc_lan = '';
     $track_count = sizeof($_REQUEST['bwc_lan_interface']);
    $flag = 0;
    foreach ($_REQUEST['bwc_lan_interface'] as $value) {
        $flag++;
        if ($flag == $track_count) {
            $bwc_lan .= $value;
            } else {
            $bwc_lan .= $value . ',';
        }
    }
    $bwc_wan = '';
    $track_count = sizeof($_REQUEST['bwc_wan_interface']);
    $flag = 0;
    foreach ($_REQUEST['bwc_wan_interface'] as $value) {
        $flag++;
        if ($flag == $track_count) {
            $bwc_wan .= $value;
        } else {
            $bwc_wan .= $value . ',';
        }
    }
}

if ($action == "update") {
    $qry = "update tbl_bwm_group
		set group_name='$group_name', bandwidth = '$bwc_bandwidth', bw_limit = '$bwc_limit', mode = '$bwc_mode', laninterface= '$bwc_lan', waninterface = '$bwc_wan', g_priority = '$bwc_priority', last_updated='$last_updated', last_updated_by='$last_updated_by'
		where id='$action_id'";
} else if ($action == "delete") {
    $qry = "update tbl_bwm_group set last_updated='$last_updated', last_updated_by='$last_updated_by', is_active='inactive'
		where id='$action_id'";
} else {
    $qry = "insert into tbl_bwm_group (group_name,bandwidth,bw_limit,mode,laninterface,waninterface,g_priority,last_updated, last_updated_by, is_active) ";
    $qry .= " values ('$group_name','$bwc_bandwidth','$bwc_limit','$bwc_mode','$bwc_lan','$bwc_wan','$bwc_priority', '$last_updated', '$last_updated_by', 'active')";
}


try {
    $res = Sql_exec($cn, $qry);
    if($action!="delete"){
        if($action == "update"){
            $options['cn'] = $cn;
			
			$options['page_name'] = "Bandwith Controller Group";
			$options['action_type'] = $action;
			$options['table'] = "tbl_bwm_group";
			$options['id_value'] = $action_id;
			setHistory($options);
		}else{
			
			$action_id = Sql_insert_id($cn);
         	        $action = 'add';
			$options['cn'] = $cn;
			$options['page_name'] = "Bandwith Controller Group";
			$options['action_type'] = $action;
			$options['table'] = "tbl_bwm_group";
			$options['id_value'] = $action_id;
			setHistory($options);
			}
    }
    
    
    
} catch (Exception $e) {
    $is_error = 1;
}
if ($is_error == 0) {
    //$is_error = file_writer_vrrp($cn);
}

ClosedDBConnection($cn);

echo $is_error;

?>