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

    $package_name = mysql_real_escape_string(htmlspecialchars($_REQUEST['time_package_Name']));
    $upload = mysql_real_escape_string(htmlspecialchars($_REQUEST['package_upload_Bandwidth']));
    $download = mysql_real_escape_string(htmlspecialchars($_REQUEST['package_download_Bandwidth']));

    $package_day = '';
    $track_count = sizeof($_REQUEST['bwc_timepackage']);
    $flag = 0;
    foreach ($_REQUEST['bwc_timepackage'] as $value) {
        $flag++;
        if ($flag == $track_count) {
            $package_day .= $value;
        } else {
            $package_day .= $value . ',';
        }
    }


}

if ($action == "update") {
    $qry = "update tbl_bwc_timepackage
		set packageName='$package_name', upload = '$upload', download = '$download', days = '$package_day',last_updated='$last_updated'
		where id='$action_id'";
} else if ($action == "delete") {
    $qry = "update tbl_bwc_timepackage set last_updated='$last_updated', is_active='inactive'
		where id='$action_id'";
} else {
    $qry = "insert into tbl_bwc_timepackage (packageName,upload,download,days,last_updated, is_active) ";
    $qry .= " values ('$package_name','$upload','$download','$package_day', '$last_updated', 'active')";
}
//echo $qry;

try {
    $res = Sql_exec($cn, $qry);
    
    if($action!="delete"){
				if($action == "update"){
                                    $options['cn'] = $cn;
						$options['page_name'] = "Bandiwth Time Package Information";
						$options['action_type'] = $action;
						$options['table'] = "tbl_bwc_timepackage";
						$options['id_value'] = $action_id;
						setHistory($options);
					}else{
						
						$action_id = Sql_insert_id($cn);
						$action = 'add';
                                                $options['cn'] = $cn;
						$options['page_name'] = "Bandiwth Time Package Information";
						$options['action_type'] = $action;
						$options['table'] = "tbl_bwc_timepackage";
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