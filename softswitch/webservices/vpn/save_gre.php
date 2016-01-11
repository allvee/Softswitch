<?php
/**
 *
 * Edited by Talemul Islam on 5/23/2015
 */
require_once  "../lib/common.php";
//require_once "../../Lib/rcportalLib.php";
require_once "../lib/filewriter.php";

$cn = connectDB();

	$action = mysql_real_escape_string(htmlspecialchars($_REQUEST['action']));
 $data_info = isset($_REQUEST['info']) ? $_REQUEST['info'] : 'action';
if ($data_info != 'action') {
    $action = $data_info['action'];
    $deleted_id = $data_info['action_id'];
}
	$local_ip = "";
	$remote_ip = "";
	$tbl = "tbl_gre";
	$gre_name = mysql_real_escape_string(htmlspecialchars($_REQUEST['gre_name']));
	$peer_outer = mysql_real_escape_string(htmlspecialchars($_REQUEST['peer_outer']));
	$peer_inner = mysql_real_escape_string(htmlspecialchars($_REQUEST['peer_inner']));
	$my_inner = mysql_real_escape_string(htmlspecialchars($_REQUEST['my_inner']));

	$is_error = 0;
	$last_updated = date('Y-m-d H:i:s');
	$last_updated_by = $_SESSION["UserID"];
	
	if($action == "update"){
		$action_id = mysql_real_escape_string(htmlspecialchars($_REQUEST['action_id']));
		$qry = "update $tbl set gre_name='$gre_name', peer_outer='$peer_outer', peer_inner='$peer_inner', my_inner='$my_inner', last_updated='$last_updated', last_updated_by='$last_updated_by'";
		$qry .= " where id='$action_id'";
	} elseif($action == "delete"){
		 $action_id = $deleted_id;
		$qry = "update $tbl set is_active='inactive',last_updated='$last_updated', last_updated_by='$last_updated_by'";
		$qry .= " where id='$action_id'";
	} else {
		$qry = "insert into $tbl (gre_name,peer_outer,peer_inner,my_inner,last_updated,last_updated_by)";
		$qry .= " values ('$gre_name','$peer_outer','$peer_inner','$my_inner','$last_updated','$last_updated_by')";
	}
                         
    
    
	try {
		$res = Sql_exec($cn,$qry);
			if($action!="delete"){
	if($action == "update"){
			$options['page_name'] = "VPN GRE";
			$options['action_type'] = $action;
			$options['table'] = "tbl_gre";
			$options['id_value'] = $action_id;
			setHistory($options);
		}else{
			
			$action_id = Sql_insert_id($cn);
         		$action = 'add';
			$options['page_name'] = "VPN GRE";
			$options['action_type'] = $action;
			$options['table'] = "tbl_gre";
			$options['id_value'] = $action_id;
			setHistory($options);
			}
	}
	} catch (Exception $e){
		$is_error = 1;
	}
	
	ClosedDBConnection($cn);


	
	if($is_error == 0){
		if($action == "insert" || $action == "update"){
			$file_name = "ifcfg-". $gre_name;
			$file = $dir . $file_name;	
			
			if($handle = fopen($file,"w")) {
				$data_string = "";
				$data_string .= "DEVICE=".$gre_name."\n";
				$data_string .= "BOOTPROTO=none"."\n";
				$data_string .= "ONBOOT=yes"."\n";
				$data_string .= "TYPE=GRE"."\n";
				$data_string .= "PEER_OUTER_IPADDR=".$peer_outer."\n";
				$data_string .= "PEER_INNER_IPADDR=".$peer_inner."\n";
				$data_string .= "MY_INNER_IPADDR=".$my_inner."\n";			

				file_put_contents($file,$data_string,true);
				fclose($handle);
			}
		} else if($action == "delete"){
			$down_cmd = "sudo ip link set ".$gre_name." down";
			$del_cmd = "sudo ip tunnel del ".$gre_name;
			
			try {
				system($down_cmd);
				system($del_cmd);
			} catch(Exception $e){

			}
			
			$file_name = "ifcfg-". $gre_name;
			$file = $dir . $file_name;	
			unlink($file);
		}
	}

	echo  $is_error;
	
?>