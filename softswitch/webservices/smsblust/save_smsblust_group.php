<?php

require_once "../lib/common.php";

$action = "";

$group  = "";
$cn = connectDB();

$info = $_POST['info'];

if( isset($info['action']) ){
	$action = mysql_real_escape_string(htmlspecialchars($info['action']));
}
if( isset($info['group'])){
	$group = mysql_real_escape_string(htmlspecialchars($info['group']));
}
if( $action == "update" || $action == "delete" ){
    $action_id =  mysql_real_escape_string(htmlspecialchars($info['action_id']));
}
//tbl_smsgw_template

$is_error = 0;	

$qry = "";

if(	$action == "insert"	){
		$qry = "INSERT INTO `tbl_smsgw_contact_group` (`group_name`,`last_updated`)VALUES('$group',NOW())";	
} elseif( $action == "update" ){
		$qry = "UPDATE `tbl_smsgw_contact_group` SET `group_name`='$group' WHERE `id`='$action_id'";		
} elseif( $action == "delete" ){
		$qry = "UPDATE `tbl_smsgw_contact_group` SET `is_active` = 'inactive' WHERE `is_active`='active' AND `id`='$action_id'";
}

	
    
	try{
		$rs = Sql_exec($cn, $qry);
		
			if($action!="delete"){
				if($action == "update"){
					$options['page_name'] = "Bulk SMS Group";
					$options['action_type'] = $action;
					$options['table'] = "tbl_smsgw_contact_group";
					$options['id_value'] = $action_id;
					setHistory($options);
				}else{
					
					$action_id = Sql_insert_id($cn);
					$action = 'add';
					$options['page_name'] = "Bulk SMS Group";
					$options['action_type'] = $action;
					$options['table'] = "tbl_smsgw_contact_group";
					$options['id_value'] = $action_id;
					setHistory($options);
					}
			}
		//$is_error = 0;
	}catch(Exception $e){
		$is_error = 1;
	}
	
ClosedDBConnection($cn);

echo $is_error;


?>