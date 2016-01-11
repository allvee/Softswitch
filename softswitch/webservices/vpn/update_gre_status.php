<?php

require_once  "../lib/common.php";
//require_once "../../Lib/rcportalLib.php";
require_once "../lib/filewriter.php";

$cn = connectDB();

	$action_id = mysql_real_escape_string(htmlspecialchars($_REQUEST['action_id']));
	$status = mysql_real_escape_string(htmlspecialchars($_REQUEST['status']));
	$updated_status = $status;
	$tbl = "tbl_gre";
	$gre_name = "";

	$is_error = 0;
	$last_updated = date('Y-m-d H:i:s');
	$last_updated_by = $_SESSION["UserID"];
	
	$qry = "update $tbl set status='$updated_status',last_updated='$last_updated', last_updated_by='$last_updated_by'";
		$qry .= " where id='$action_id'";                
    
    
	try {
		$res = Sql_exec($cn,$qry);
	} catch (Exception $e){
		$is_error = 1;
	}
	
	$select_qry = "select gre_name from $tbl where id='$action_id' and is_active='active'";                

	try {
		$res = Sql_exec($cn,$select_qry);
		if($dt=Sql_fetch_array($res)){
			$gre_name =$dt['gre_name'];
		}
	} catch (Exception $e){
		$is_error = 1;
	}
	ClosedDBConnection($cn);
	
	if($updated_status=="enable"){
		$cmd = "sudo ifup ".$gre_name;
	}else if($updated_status=="disable"){
		$cmd = "sudo ifdown ".$gre_name;
	}	

	try {
		system($cmd);
	} catch(Exception $e){
		$is_error = 1;
	}
	echo $is_error;
?>