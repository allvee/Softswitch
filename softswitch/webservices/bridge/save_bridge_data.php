<?php
/**
 * Created by PhpStorm.
 * User: Nazibul
 * Date: 5/7/2015
 * Time: 7:45 PM
 */

function file_modify($file,$bridgeTag){
	    chmod($file,0777);
		$data = file_get_contents($file);
		$data = trim($data);
		$file_data = $data.$bridgeTag;
		file_put_contents($file, $file_data);
}			

function delete_bridge_tag($file,$bridge_tag){
	    chmod($file,0777);
		$lines = file($file);
	    foreach (array_values($lines) AS $line)
		{
				
			if ( trim($line) == trim($bridge_tag))
			{
				$current = file_get_contents($file);				
				$data = str_replace($bridge_tag,"",$current); 				
				file_put_contents($file, $data);
			    return true;    
			}
		}
		return false;
}

function bridge_file_write($dir,$bridge_name,$ip,$net_mask){
	    
		$file = $dir . "ifcfg-" . $bridge_name;
		chmod($file,0777);
    	if($handle = fopen($file, 'w')){ //or die('Cannot create file:  ' . $file);
   			$writingString = "# Broadcom Corporation NetXtreme II BCM5716 Gigabit Ethernet\n";
			$writingString .= "DEVICE=".$bridge_name ."\n";
			$writingString .= "BOOTPROTO=static\n";
			$writingString .= "ONBOOT=yes\n";
			$writingString .= "TYPE=Bridge\n";
			
			if(trim($ip) !=""){
				$writingString .= "IPADDR=".$ip."\n";
			}
			if(trim($net_mask) !=""){
				$writingString .= "NETMASK=".$net_mask."\n";
			}
			$writingString .= "STP=yes\n";
			$writingString .= "DELAY=15\n";

			fwrite($handle, $writingString);
			fclose($handle);
		}	
	
}



require_once "../lib/common.php";
//require_once "../../Lib/rcportalLib.php";
require_once "../lib/filewriter.php";

//print_r($_REQUEST['dynamic_nat_interface']);
//exit;

$cn = connectDB();
$interface = array('','','','');

$action = mysql_real_escape_string(htmlspecialchars($_REQUEST['action']));
$action_id = mysql_real_escape_string(htmlspecialchars($_REQUEST['action_id']));

if (isset($_REQUEST['bridge_name']))
	$bridge_name = mysql_real_escape_string(htmlspecialchars($_REQUEST['bridge_name']));
if(isset($_REQUEST['ip_address']))
	$ip = mysql_real_escape_string(htmlspecialchars($_REQUEST['ip_address']));
if(isset($_REQUEST['net_mask']))
	$net_mask = mysql_real_escape_string(htmlspecialchars($_REQUEST['net_mask']));

if(isset($_REQUEST['dynamic_nat_interface'])){
	$i=0;
	foreach ( $_REQUEST['dynamic_nat_interface'] as $name) {
       $interface[$i++] =$name;
    }
}


$is_error = 0;
$last_updated = date('Y-m-d H:i:s');
$last_updated_by = $_SESSION["UserID"];

$previous_interfaces = array('','','','');

if( $action == "update" || $action == "delete" ){
	$qry = "SELECT `bridge_name`,`interface1`,`interface2`,`interface3`,`interface4` 
			FROM `tbl_bridge` 
			WHERE `id`='$action_id' AND `is_active`='active'";
				
	$dt = Sql_fetch_array(Sql_exec($cn,$qry));
	$previous_interfaces[0] = $dt['interface1'];
	$previous_interfaces[1] = $dt['interface2'];
	$previous_interfaces[2] = $dt['interface3'];
	$previous_interfaces[3] = $dt['interface4'];
	if( $action == "delete" ){
		$bridge_name =  trim($dt['bridge_name']);
	}
}


if ($action == "update") {
   
	
    $qry = "update `tbl_bridge` set `bridge_name`='$bridge_name', `interface1`='$interface[0]',`interface2`='$interface[1]',`interface3`='$interface[2]',`interface4`='$interface[3]',`ip`='$ip', `net_mask`='$net_mask', `last_updated`='$last_updated', `last_updated_by`='$last_updated_by'";
    $qry .= " where `id`='$action_id'";
} else if ($action == "delete") {
    
    $qry = "update `tbl_bridge` set `is_active`='inactive',`last_updated`='$last_updated',`last_updated_by`='$last_updated_by'";
    $qry .= " where `id`='$action_id'";
} else {
    $qry = "insert into `tbl_bridge` (`bridge_name`,`interface1`,`interface2`,`interface3`,`interface4`,`ip`,`net_mask`,`last_updated`,`last_updated_by`)";
    $qry .= " values ('$bridge_name','$interface[0]','$interface[1]','$interface[2]','$interface[3]','$ip','$net_mask','$last_updated','$last_updated_by')";
}


try {
    $res = Sql_exec($cn, $qry); // bridge query
	if ( $action == "update" ){
		 
		 $bridge_tag = "BRIDGE=".$bridge_name;
		 foreach($previous_interfaces as $name){
			 if( $name != "" ){
			    if( strpos($name,":")==true ){
					$name = str_replace(":",".",$name);
				}
				delete_bridge_tag($dir.$name,$bridge_tag);	 // empty previous BRIDGE tag from interface config file
			 }
		 }
		 
		
		 
		 $update_qry = "UPDATE `tbl_interface` 
						SET `bridge`='yes' 
						WHERE `is_active`='active' 
								AND (	`interface_name` = '$interface[0]' OR 
										`interface_name` = '$interface[1]' OR 
										`interface_name` = '$interface[2]' OR 
										`interface_name` = '$interface[3]' 
									)";
	     Sql_exec($cn,$update_qry); // interface query: update bridge field = 'yes' for each of the new interface
		 
		 $bridgeTag = "\n" . "BRIDGE=".$bridge_name;
		 $interface_names = array('','','','');
		 $i=0;
		 foreach($interface as $name){
			 if( $name != "" ){
			    if( strpos($name,":")==true ){
					$name = str_replace(":",".",$name);
				}
				file_modify($dir.$name,$bridgeTag);	 //Add BRIDGE tag to newly interface config file
				
				$interface_name_parts = split("-",$name);
				$interface_names[$i++] = $interface_name_parts[1];
			 }
		 }
		 
		 bridge_file_write($dir,$bridge_name,$ip,$net_mask);
		 
		 $cmd2 = "sudo brctl addif ".$bridge_name;
		 if($interface_names[0] != "" ) $cmd2 .=" ".$interface_names[0];
		 if($interface_names[1] != "" ) $cmd2 .=" ".$interface_names[1];
		 if($interface_names[2] != "" ) $cmd2 .=" ".$interface_names[2];
		 if($interface_names[3] != "" ) $cmd2 .=" ".$interface_names[3];
	
		shell_exec(escapeshellcmd("sudo ifdown $bridge_name"));
		shell_exec(escapeshellcmd("sudo brctl delbr $bridge_name"));
        
		shell_exec(escapeshellcmd("sudo ifup $bridge_name"));
		shell_exec(escapeshellcmd($cmd2));
		
	} else if( $action == "delete" ){
		  
		  chmod($dir."ifcfg-".$bridge_name,0777);
		  unlink($dir."ifcfg-".$bridge_name);
		  $bridge_tag = "BRIDGE=".$bridge_name;
		  foreach($previous_interfaces as $name){
			 if( $name != "" ){
			    if( strpos($name,":")==true ){
					$name = str_replace(":",".",$name);
				}
				delete_bridge_tag($dir.$name,$bridge_tag);	 // empty previous BRIDGE tag from interface config file
			 }
		 }
		 
		 $update_qry = "UPDATE tbl_interface 
						SET `bridge`='no' 
						WHERE `is_active`='active' 
								AND (
										`interface_name` = '$previous_interfaces[0]' OR 
										`interface_name` = '$previous_interfaces[1]' OR 
										`interface_name` = '$previous_interfaces[2]' OR 
										`interface_name` = '$previous_interfaces[3]' 
									)";
		 Sql_exec($cn,$update_qry);	
		 
		 $down_command = escapeshellcmd("sudo ifconfig $bridge_name down");
		 $del_command = escapeshellcmd("sudo brctl delbr $bridge_name");
		 shell_exec($down_command);
	     shell_exec($del_command);
		  
	} else {
		 // for insert action
		 $update_qry = "UPDATE `tbl_interface` 
						SET `bridge`='yes' 
						WHERE `is_active`='active' 
								AND (	`interface_name` = '$interface[0]' OR 
										`interface_name` = '$interface[1]' OR 
										`interface_name` = '$interface[2]' OR 
										`interface_name` = '$interface[3]' 
									)";
	     Sql_exec($cn,$update_qry); // interface query: update bridge field = 'yes' for each of the new interface
		 
		 $bridgeTag = "\n" . "BRIDGE=".$bridge_name;
		 $interface_names = array('','','','');
		 $i=0;
		 foreach($interface as $name){
			 
			 if( $name != "" ){
			    if( strpos($name,":")==true ){
					$name = str_replace(":",".",$name);
				}
				file_modify($dir.$name,$bridgeTag);	 //Add BRIDGE tag to newly interface config file
				
				 $interface_name_parts = split("-",$name);
				 $interface_names[$i++] = $interface_name_parts[1];
			 }
		 }
		 
		 bridge_file_write($dir,$bridge_name,$ip,$net_mask);
		 
		    $cmd2 = "sudo brctl addif ".$bridge_name;
			if($interface_names[0] != "" )$cmd2.=" ".$interface_names[0];
			if($interface_names[1] != "" )$cmd2.=" ".$interface_names[1];
			if($interface_names[2] != "" )$cmd2.=" ".$interface_names[2];
			if($interface_names[3] != "" )$cmd2.=" ".$interface_names[3];
			
			shell_exec(escapeshellcmd("sudo ifup $bridge_name"));
			shell_exec(escapeshellcmd($cmd2));
	}
} catch (Exception $e) {
    $is_error = 1;
}

ClosedDBConnection($cn);

echo $is_error;

?>