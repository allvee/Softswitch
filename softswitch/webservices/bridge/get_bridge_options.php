<?php
/**
 * Created by PhpStorm.
 * User: Danial
 * Date: 5/10/2015
 * Time: 3:02 PM
 */

require_once  "../lib/common.php";

$cn = connectDB();


$qry = "SELECT `id`,`interface_name` 
		FROM `tbl_interface` 
		WHERE `bridge`='no' AND `is_active`='active' 
		ORDER BY `interface_name` ASC";
$res = Sql_exec($cn,$qry);

$interface_options = "";						
while($dt = Sql_fetch_array($res)){
	$full_name = "";$name_parts = "";$interface_name = "";
	
	$full_name = trim($dt['interface_name']);
	$name_parts = explode("-",$full_name);
	$interface_name = $name_parts[1];
	$interface_options  .= '<option value="'.$full_name.'">'.$interface_name.'</option>';
}

ClosedDBConnection($cn);
echo $interface_options;


