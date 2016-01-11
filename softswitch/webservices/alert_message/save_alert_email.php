<?php
/**
 * Created by PhpStorm.
 * User: Nazibul
 * Date: 5/14/2015
 * Time: 4:37 PM
 */

require_once "../lib/common.php";
//require_once "../../Lib/rcportalLib.php";
require_once "../lib/filewriter.php";

$cn = connectDB();

$tbl = "tbl_alert_config";

$is_error = 0;
$last_updated = date('Y-m-d H:i:s');
$last_updated_by = $_SESSION["UserID"];

$data = array();

$email = mysql_real_escape_string(htmlspecialchars($_REQUEST['email_address']));
$password = mysql_real_escape_string(htmlspecialchars($_REQUEST['password']));
$smtp_account = mysql_real_escape_string(htmlspecialchars($_REQUEST['smtp_account']));
$smtp_port = mysql_real_escape_string(htmlspecialchars($_REQUEST['smtp_port']));

$data['email'] = $email;
$data['password'] = $password;
$data['smtp_account'] = $smtp_account;
$data['smtp_port'] = $smtp_port;

$json_data=json_encode($data);

$qry = "update $tbl set `config`='$json_data', last_updated='$last_updated', last_updated_by='$last_updated_by' where id=1";

try {
    $res = Sql_exec($cn, $qry);
	
			$options['page_name'] = "Alert Managrment: Email Configuration";
			$options['action_type'] = 'update';
			$options['table'] = "tbl_alert_config";
			$options['id_value'] = '1';
			setHistory($options);
} catch (Exception $e) {
    $is_error = 1;
}

ClosedDBConnection($cn);

echo $is_error . "";

?>