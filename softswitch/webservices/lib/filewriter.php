<?php
	
function getFieldName($file,$name,$postfix=NULL){
     $lines = file($file);
     foreach (array_values($lines) AS $line){
          list($key, $val) = explode('=', trim($line) );

          if (trim($key) == $name){
                return $val;
          }
     }
     return false;
} 

	function replaceFieldVal($file,$name, $postfix=NULL, $replaceWith,$alter_prefix = NULL, $alter_postfix = NULL)
	{
		$lines = file($file);
	
		foreach (array_values($lines) AS $line)
		{
			list($key, $val) = explode('=', trim($line) );		
			if (trim($key) == $name)
			{
				$key_update = strrev(strtok(strrev($key),"#"));			   
				if($replaceWith == "")
				{				   
					$key_update = "#" . $key_update;
				}				
				$current = file_get_contents($file);				
				$data = str_replace($key."=".$val, $key."=".$replaceWith, $current); 				
				file_put_contents($file, $data);
				return true;
			}
		}
		return false;
	}
	
	function insertNewLine($file,$data,$afterLine="*nat",$beforeLine="COMMIT"){
		$start_status = 0;
		$lines = file($file);
		
		foreach (array_values($lines) AS $index => $line){
			if(trim($line) == $afterLine && $start_status == 0){
				$start_status = 1;
				$position_start = $index;
			}
			
			if($start_status == 1){
				if(trim($line) == $beforeLine){
					$start_status = 0;
					$position = $index;
				}
			}
		}
		
		array_splice($lines,$position,0,array($data."\n"));
		// reindex array
		$lines = array_values($lines);
		
		file_put_contents($file,$lines);
		return true;
	}

	function cleanLines($file,$afterLine="*nat",$beforeLine="COMMIT",$passIndex=0){
		$start_status = 0;
		$before_position = 0;
		$lines = file($file);
		
		foreach (array_values($lines) AS $index => $line){
			if(trim($line) == $afterLine){
				$start_status = 1;
				$after_position = intval($index)+$passIndex;
			}
			
			if($start_status == 1){
				if(trim($line) == $beforeLine){
					$start_status = 0;
					$before_position = $index;
				}
			}
		}
		
		foreach (array_values($lines) AS $index => $line){
			if($index > $after_position && $index<$before_position){
				unset($lines[$index]);
			}
		}
		
		// reindex array
		$lines = array_values($lines);
		
		file_put_contents($file,$lines);
		return true;
	}

/**
 * General Settings HOST
 */
		
function file_writer_gs_host($cn){	
	global $dir_hosts;
	$is_error = 0;
	log_generator("General Settings HOST File Writing START",__FILE__,__FUNCTION__,__LINE__,NULL);
			
	$file_dir = $dir_hosts;
	//$file_dir = "../../etc/hosts/hosts.log";
	$qry = "select host_name,IP from tbl_hosts";
	$res = Sql_exec($cn,$qry);
	$lines = file($file_dir);
	$data = "";
	
	while($dt = Sql_fetch_array($res)){
		$host_name = $dt['host_name'];
		$ip = $dt['IP'];
		$host_name_del = $host_name;

		foreach (array_values($lines) AS $index => $line){
			$arr = explode(' ', $line );
			if (trim($arr[1]) == $host_name_del || trim($arr[0]) == ""){
				unset($lines[$index]);
			} 
		}
		$data .= "\n" . $ip . " " . $host_name;;
	}
	// reindex array
	$lines = array_values($lines);
	file_put_contents($file_dir,$lines);
	
	$data_string = file_get_contents($file_dir,true);
	$data_string .= $data;
	
	try {
		file_put_contents($file_dir,$data_string);
		log_generator("General Settings Host Successfully Written",__FILE__,__FUNCTION__,__LINE__,NULL);
	} catch (Exception $e){
		$is_error = 2;
		log_generator("General Settings Host Writting Failed",__FILE__,__FUNCTION__,__LINE__,NULL);
	}
	return $is_error;
	
}

/**
 * Network Settings DNS Servers
 */

function file_writer_gs_dns_server($cn){
	global $dir_dns_servers;
	global $dir_network_host;
	$is_error=0;
	$qry = "select host_name,server1,server2 from tbl_dns_servers";
	$res = Sql_exec($cn,$qry);
	$file_dir = $dir_dns_servers;
	$lines = file($file_dir);
	$data = "";
	
	while($dt = Sql_fetch_array($res)){
		$host_name = $dt['host_name'];
		$server1 = $dt['server1'];
		$server2 = $dt['server2'];
		
		$data_string = "search\n";
		$data_string .= "nameserver ".$server1."\n";
		$data_string .= "nameserver ".$server2;
		
		log_generator("General Settings DNS Server File Writing Start",__FILE__,__FUNCTION__,__LINE__,NULL);
		
		//$file_dir = "dns_servers.txt";
		try {
			file_put_contents($file_dir,$data_string);
			log_generator("General Settings DNS Successfully Written",__FILE__,__FUNCTION__,__LINE__,NULL);
		} catch (Exception $o){
			$is_error = 2;
			log_generator("General Settings DNS Writting Failed",__FILE__,__FUNCTION__,__LINE__,NULL);
		}
		
		
		log_generator("General Settings Host Name File Writing Start",__FILE__,__FUNCTION__,__LINE__,NULL);
		
		$file_dir = $dir_network_host;
		try {
			replaceFieldVal($file_dir,"HOSTNAME","",$host_name);
			log_generator("General Settings Host Name Successfully Written",__FILE__,__FUNCTION__,__LINE__,NULL);
		} catch (Exception $oe){
			$is_error = 3;
			log_generator("General Settings Host Name Writting Failed",__FILE__,__FUNCTION__,__LINE__,NULL);
		}
		
	}
	
	return $is_error;
}

/**
 * Network Settings Interface
 */	
 /*
 function file_writer_ns_interface($cn){	
	global $dir;
	$is_error = 0;
	log_generator("Network Settings Interface File Writing Start",__FILE__,__FUNCTION__,__LINE__,NULL); 
	$file_dir = $dir;
	
	$select_qry = "select id,interface_name,ip,netmask,gateway,vlan,bridge from tbl_interface where is_active='active'";
	$rs = Sql_exec($cn,$select_qry);
		
	while($dt = Sql_fetch_array($rs)){
		$interface_name  = $dt['interface_name'];
		$ip = $dt['ip'];
		$ipv4_net_mask = $dt['netmask'];
		$ipv4_gateway = $dt['gateway'];
		$vlan = $dt['vlan'];	
		
		$updated_interface_name = $interface_name;
		if(strpos($interface_name,":")){
			$updated_interface_name = str_replace(":",".",$interface_name);
		}
		$file = $file_dir . $updated_interface_name;
		
		$sub_ip_name = "IPADDR";
		$sub_netmask_name = "NETMASK";	
		
		if($handle = fopen($file,"w")) {
			$data_string = "";
			$data_string .= "DEVICE=".$updated_device_name."\n";
			$data_string .= $sub_ip_name."=".$sub_ip."\n";
			$data_string .= $sub_netmask_name."=".$sub_netmask."\n";
			$data_string .= "ONBOOT=yes\n";
			if($sub_ip == ""){
				$data_string .= "BOOTPROTO=none";
			} else {
				$data_string .= "BOOTPROTO=static";
			}
			$data_string .= "\nTYPE=Ethernet";
			
			$data_string .= "\nVLAN=".$vlan_v;
			
			file_put_contents($file,$data_string,true);
			fclose($handle);
		}		
			
	}
	log_generator("Interface Successfully Written",__FILE__,__FUNCTION__,__LINE__,NULL);
	
	return $is_error;
}

 */
function file_writer_ns_interface_bak($cn){	
	global $dir;
	$is_error = 0;
	log_generator("Network Settings Interface File Writing Start",__FILE__,__FUNCTION__,__LINE__,NULL); 
	$file_dir = $dir;
	
	$select_qry = "select id,interface_name,ip,netmask,gateway,vlan,bridge from tbl_interface where is_active='active'";
	log_generator("Interface Query # ".$select_qry,__FILE__,__FUNCTION__,__LINE__,NULL);	
	$rs = Sql_exec($cn,$select_qry);
		
	while($dt = Sql_fetch_array($rs)){
		$interface_name  = $dt['interface_name'];
		$ip = $dt['ip'];
		$ipv4_net_mask = $dt['netmask'];
		$ipv4_gateway = $dt['gateway'];
		$vlan = $dt['vlan'];
		
		$file = $file_dir . $interface_name;
		
		$data = replaceFieldVal($file, "IPADDR", "NETMASK", $ip);
		
		if(!$data && $ip != "")
		{
			$content = file_get_contents($file);
			$content =$content."\nIPADDR=".$ip;
			file_put_contents($file, $content);			
		}
		if($ip != "")
			$data = replaceFieldVal($file, "BOOTPROTO", "", "static");
		$data = replaceFieldVal($file, "NETMASK", $check_gateway=NULL, $ipv4_net_mask,NULL,NULL);
		if(!$data && $ipv4_net_mask != "")
		{
			$content = file_get_contents($file);
			$content =$content."\nNETMASK=".$ipv4_net_mask;
			file_put_contents($file, $content);			
		}
		if(!(replaceFieldVal($file, "#GATEWAY", "STP", $ipv4_gateway,"NETWORK","ONBOOT")))
		{
			if(!(replaceFieldVal($file, "GATEWAY", "STP", $ipv4_gateway,"NETWORK","ONBOOT")))
			{
				$data = replaceFieldVal($file, "NETWORK", "STP", $ipv4_gateway,"NETWORK","ONBOOT");
				if(!$data && $ipv4_gateway != "")
				{
					$content = file_get_contents($file);
					$content =$content."\nGATEWAY=".$ipv4_gateway;
					file_put_contents($file, $content);			
				}
			}
		}		
		
		log_generator("Interface Name # ".$file,__FILE__,__FUNCTION__,__LINE__,NULL);	
		$vlan_u = "none";
		if(strpos($interface_name,":") != false){
			replaceFieldVal($file,"vlan","",$vlan);
			$vlan_u = $vlan;
		}
	}
	log_generator("Interface Successfully Written",__FILE__,__FUNCTION__,__LINE__,NULL);
	
	return $is_error;
}

	
/**
 * Network Settings Bridge
 */	
function file_writer_ns_bridge($cn){ 
	global $dir;
	$is_error = 0;
	$file_dir = $dir;
	log_generator("Network Settings Bridge File Writing Start",__FILE__,__FUNCTION__,__LINE__,NULL);
	
	function file_modify($file,$bridgeTag){
		$data = file_get_contents($file);
		$data = trim($data);
		$file_data = $data.$bridgeTag;
		file_put_contents($file, $file_data);
	}		
	
	$select_qry = "select id,bridge_name,interface1,interface2,interface3,interface4, ip, net_mask, gateway from tbl_bridge where is_active='active'";
		
	$rs = Sql_exec($cn,$select_qry);
		
	while($dt = Sql_fetch_array($rs)){
		$bridge  = $dt['bridge_name'];
		$ip_addr = $dt['ip'];
		$net_mask = $dt['net_mask'];
		$gateway = $dt['gateway'];
		$interface1 = $dt['interface1'];
		$interface2 = $dt['interface2'];
		$interface3 = $dt['interface3'];
		$interface4 = $dt['interface4'];
		
		$file = $file_dir . "ifcfg-br" . $bridge;
		if($handle = fopen($file, 'w')){ //or die('Cannot create file:  ' . $file);
			$writingString = "# Broadcom Corporation NetXtreme II BCM5716 Gigabit Ethernet\n";
			$writingString .= "DEVICE=br" . $bridge . "\n";
			$writingString .= "BOOTPROTO=static\n";
			$writingString .= "ONBOOT=yes\n";
			$writingString .= "TYPE=Bridge\n";
			if(trim($ip_addr) !=""){
				$writingString .= "IPADDR=".$ip_addr."\n";
			}
			if(trim($net_mask) !=""){
				$writingString .= "NETMASK=".$net_mask."\n";
			}
			if(trim($gateway) !=""){
				$writingString .= "GATEWAY=".$gateway."\n";
			}
			$writingString .= "STP=yes\n";
			$writingString .= "DELAY=15\n";
	
			fwrite($handle, $writingString);
			fclose($handle);
		}	
		
		$bridgeTag = "\n" ."BRIDGE=br" . $bridge;
		
		//bridge 1
		$b1 = $interface1;
		
		if ($b1 != "") {
			$b1_u = $b1;
			if(strpos($b1,":")){
				$b1_u = str_replace(":",".",$b1);
			}	
			$file = $dir . $b1_u;
			file_modify($file,$bridgeTag);
			
		}
		
		// bridge 2
		$b2 = $interface2;
		
		if ($b2 != "") {
			$b2_u = $b2;
			if(strpos($b2,":")){
				$b2_u = str_replace(":",".",$b2);
			}	
			$file = $dir . $b2_u;
			file_modify($file,$bridgeTag);
		}
		
		// bridge 3
		$b3 = $interface3;
		
		if ($b3 != "") {
			$b3_u = $b3;
			if(strpos($b3,":")){
				$b3_u = str_replace(":",".",$b3);
			}	
			$file = $dir . $b3_u;
			file_modify($file,$bridgeTag);
		}
		
		// bridge 4
		$b4 = $interface4;
	
		if ($b4 != "") {
			$b4_u = $b4;
			if(strpos($b4,":")){
				$b4_u = str_replace(":",".",$b4);
			}	
			$file = $dir . $b4_u;
			file_modify($file,$bridgeTag);
		}
	}
	log_generator("Bridge Successfully Written",__FILE__,__FUNCTION__,__LINE__,NULL);
	
	return $is_error;
}

/**
 * Network Settings DHCP
 */	
function file_writer_ns_dhcp($cn){	
	global $dir_dhcp;
	$is_error = 0;
	$file_dir = $dir_dhcp;
	log_generator("Network Settings DHCP File Writing Start",__FILE__,__FUNCTION__,__LINE__,NULL);
	
	$select_qry = "select id,subnet,net_mask,gateway,domain_name,domain_name_server1,domain_name_server2,netbios_name_server,default_lease_time,max_lease_time,is_active from tbl_dhcp where is_active='active'";
		
	$data_string = "ddns-update-style interim;\nignore client-updates;\n"; 
	
	$rs = Sql_exec($cn,$select_qry);
	
	while($dt = Sql_fetch_array($rs)){
		$data_string .= "subnet " . $dt['subnet'] . " netmask " . $dt['net_mask'] . " {\n";
		
		if($dt['gateway'] != ""){ 
			$data_string .= "option routers                   " . $dt['gateway'] . ";\n"; 
		}
		$data_string .= "option subnet-mask              " . $dt['net_mask'] . ";\n";
		
		if($dt['domain_name'] != ""){ 
			$data_string .= 'option domain-name                  "' . $dt['domain_name'] . '";';
			$data_string .= "\n"; 
		}
		if($dt['domain_name_server1'] != ""){ 
			$data_string .= "option domain-name-servers              " . $dt['domain_name_server1'] . ";\n"; 
		}
		if($dt['domain_name_server2'] != ""){ 
			$data_string .= "option domain-name-servers              " . $dt['domain_name_server2'] . ";\n"; 
		}
		if($dt['netbios_name_server'] != ""){ 
			$data_string .= "option netbios-name-servers              " . $dt['netbios_name_server'] . ";\n"; 
		}
		
		$range_rs = Sql_exec($cn,"select * from tbl_dhcp_range where is_active = 'active' and dhcp_id = '".$dt['id']."'");
		while($dt_rs = Sql_fetch_array($range_rs)){
			$data_string .= "range dynamic-bootp " . $dt_rs['range_start'] . " " . $dt_rs['range_end'] . ";\n";
		}
		
		if($dt['default_lease_time'] != ""){ 
			$data_string .= "default-lease-time " . $dt['default_lease_time'] . ";\n"; 
		}
		if($dt['max_lease_time'] != ""){ 
			$data_string .= "max-lease-time " . $dt['max_lease_time'] . ";\n"; 
		}
		
		$host_rs = Sql_exec($cn,"select * from tbl_dhcp_host where is_active = 'active' and dhcp_id = '".$dt['id']."'");
		while($dt_host = Sql_fetch_array($host_rs)){
			$data_string .= "host " . $dt_host['host_user'] . " {\n";
				$data_string .= 'option host-name "' . $dt_host['host_name'] . '";';
				$data_string .= "\n";
				$data_string .= "hardware ethernet " . $dt_host['hd_ethernet'] . ";\n";
				$data_string .= "fixed-address " . $dt_host['fixed_address'] . ";\n";
			$data_string .= "}\n";
		}
		
		$data_string .= "}\n";
	}
	try {
		file_put_contents($file_dir,$data_string);
	} catch (Exception $o){
		$is_error = 4;
	}
	
	global $dir_dhcp_interface;
	$file = $dir_dhcp_interface;
	
	$select_qry = "select id,interface from tbl_dhcp where is_active='active'";	
	$rs = Sql_exec($cn,$select_qry);
		
	$interface = "";	
	while($dt = Sql_fetch_array($rs)){
		$interface .= $dt['interface']." ";
	}
	
	try {
		replaceFieldVal($file, "DHCPDARGS", "","\"". trim($interface) ."\";");
		} catch (Exception $oe){
			$is_error = 2;
	}
	
	log_generator("DHCP Successfully Written",__FILE__,__FUNCTION__,__LINE__,NULL);
	
	return $is_error;
}

function file_writer_dhcp_interface($cn){	
	global $dir_dhcp_interface;
	$is_error = 0;
	log_generator("DHCP Interface File Writing Start",__FILE__,__FUNCTION__,__LINE__,NULL); 
	$file_dir = $dir_dhcp_interface;
	
	$select_qry = "select id,name from tbl_dhcp_interface where is_active='active'";	
	$rs = Sql_exec($cn,$select_qry);
		
	$interface = "";	
	while($dt = Sql_fetch_array($rs)){
		$interface .= $dt['name']." ";
	}
	
	try {
		replaceFieldVal($file_dir, "DHCPDARGS", "","\"". trim($interface) ."\";");
		log_generator("DHCP Interface Successfully Written",__FILE__,__FUNCTION__,__LINE__,NULL);
		} catch (Exception $oe){
			$is_error = 2;
	}
	
	return $is_error;
}


/**
 * Network Settings Routing
 */	
function fw_static_routing($cn){
	global $p_of_static_routing;
	$is_error = 0;
	log_generator("Static Routing File Writing Start",__FILE__,__FUNCTION__,__LINE__,NULL);
	$data_string = "";
	$select_qry = "select id, pname, ip_addr, gateway, metric"; 
	$select_qry .= " from tbl_static_routing where is_active='active'";
	
	$rs = Sql_exec($cn,$select_qry);
	while($dt = Sql_fetch_array($rs)){
		if($data_string != "") $data_string .= "\n";
		$data_string .= "ip route " . $dt['ip_addr'] . " " . $dt['gateway'] . " " . $dt['metric'] ;
	}
	
	//log_generator($data_string);
	
	try {
		cleanLines($p_of_static_routing,"interface lo","!");
		insertNewLine($p_of_static_routing,$data_string,"interface lo","!");
	} catch (Exception $o){
		$is_error = 2;
	}
	log_generator("Static Routing Successfully Written",__FILE__,__FUNCTION__,__LINE__,NULL);
	
	return $is_error;
}

/**
 * OSPF Routing
 */
function fw_ospf_routing($cn){
	global $p_of_dynamic_ospf_routing;
	$is_error = 0;
	log_generator("OSPF Routing File Writing Start",__FILE__,__FUNCTION__,__LINE__,NULL);
	
	$data_string = "router ospf\n";
	$count=0;
	$select_qry = "select distinct router_id"; 
	$select_qry .= " from tbl_ospf_routing where is_active='active'";
	
	$rs = Sql_exec($cn,$select_qry);
	while($dt = Sql_fetch_array($rs)){
		if($count>0) $data_string .= "\n";
		$router_id = $dt['router_id'];
		$data_string .= "ospf router-id ".$router_id;
		$qry = "select ospf_ip_addr, area"; 
		$qry .= " from tbl_ospf_routing where is_active='active' and router_id='$router_id'";
		
		$rs_data = Sql_exec($cn,$qry);
		while($dt_data = Sql_fetch_array($rs_data)){
			$data_string .= "\n";
			$data_string .= "network " . $dt_data['ospf_ip_addr'] . " area " . $dt_data['area'] . " "  ;
		}
		$count++;
	}
	//log_generator($p_of_dynamic_ospf_routing);
	
	try {
		cleanLines($p_of_dynamic_ospf_routing,"interface lo","!");
		insertNewLine($p_of_dynamic_ospf_routing,$data_string,"interface lo","!");
	} catch (Exception $o){
		$is_error = 2;
	}
	
	log_generator("OSPF Routing Successfully Written",__FILE__,__FUNCTION__,__LINE__,NULL);
	return $is_error;
}

/**
 * RIP Routing
 */
function fw_rip_routing($cn){
	global $p_of_dynamic_rip_routing;
	$is_error = 0;
	
	log_generator("RIP Routing File Writing Start",__FILE__,__FUNCTION__,__LINE__,NULL);
	
	$data_string = "router rip\n";
	
	$select_qry = "select version"; 
	$select_qry .= " from tbl_rip_routing where is_active='active'";
	
	$rs = Sql_exec($cn,$select_qry);
	while($dt = Sql_fetch_array($rs)){
		$version = $dt['version'];
		if($version == "2") $data_string .= "version 2";
		$qry = "select rip_ip_addr"; 
		$qry .= " from tbl_rip_routing_ip where is_active='active'";
		
		$rs_data = Sql_exec($cn,$qry);
		while($dt_data = Sql_fetch_array($rs_data)){
			$data_string .= "\n";
			$data_string .= "network " . $dt_data['rip_ip_addr'];
		}
		
	}
	
	try {
		cleanLines($p_of_dynamic_rip_routing,"log stdout","!");
		insertNewLine($p_of_dynamic_rip_routing,$data_string,"log stdout","!");
	} catch (Exception $o){
		$is_error = 2;
	}
	
	log_generator("RIP Routing File Successfully Written",__FILE__,__FUNCTION__,__LINE__,NULL);
	return $is_error;
}


function file_write_bgp($cn){
	global $dir_bgp;
	$file_dir = $dir_bgp;
	$is_error = 0;
	$bgp_id = "";
	
	log_generator("BGP File Writing Start",__FILE__,__FUNCTION__,__LINE__,NULL);
	
	$data_string = "";
	$data_tmp_string = "";
	$select_router = "select id,as_number,router_id,auto_summary from tbl_bgp_routing where is_active='active'"; 
	$res_router = Sql_exec($cn,$select_router);
	while($dt = Sql_fetch_array($res_router)){
		global $bgp_id;
		$bgp_id = $dt['id'];
		$as_number = $dt['as_number'];
		$router_id = $dt['router_id'];
		$auto_summary = $dt['auto_summary'];
		
		$data_tmp_string =  "router bgp ".$as_number;
		$data_tmp_string .= "\n"."bgp router-id ".$router_id; 
		
		$data_string .= "router bgp ".$as_number."\n";
		$data_string .= "no synchronization\n";
		$data_string .= "bgp router-id ".$router_id."\n";
		
		$select_network = "select network from tbl_bgp_routing_network where bgp_id='$bgp_id' and is_active='active'";
		$rs_network = Sql_exec($cn,$select_network);
		while($dt_nt=Sql_fetch_array($rs_network)){
			$network = $dt_nt['network'];
			$data_tmp_string .= "\n"."network ".$network;
			$data_string .= "network ".$network."\n";
		}
		
		$select_neighbor = "select neighbor,pname,pvalue from tbl_bgp_routing_neighbor where bgp_id='$bgp_id' and is_active='active'";
		$rs_neighbor = Sql_exec($cn,$select_neighbor);
		while($dt_nb=Sql_fetch_array($rs_neighbor)){
			$neighbor = $dt_nb['neighbor'];
			$pname = $dt_nb['pname'];
			$pvalue = $dt_nb['pvalue'];
			$data_tmp_string .= "\n"."neighbor ".$neighbor." ".$pname." ".$pvalue;
			$data_string .= "neighbor ".$neighbor." ".$pname." ".$pvalue."\n";
		}
		
		$data_string .= $auto_summary." auto-summary\n";
		$data_string .= "!\n";
		
		
	}
	
	global $bgp_current_config_path;
	if($handle = fopen($bgp_current_config_path, 'w')){
		fwrite($handle,$data_tmp_string);
		fclose($handle);
			
              global $running_bgp_path;
		$cmd = escapeshellcmd("expect $running_bgp_path $bgp_current_config_path");
		shell_exec($cmd);
	}
	
	try {
		//cleanLines($file_dir,"log stdout","line vty");
		//insertNewLine($file_dir,$data_string,"log stdout","line vty");
	} catch (Exception $o){
		$is_error = 2;
	}
	
	log_generator("BGP File Successfully Written",__FILE__,__FUNCTION__,__LINE__,NULL);
	return $is_error;	
	
}		
/**
 * Security ACL
 */	
 function file_writer_acl($cn){
	 global $dir_firewall;
	 //log_generator($dir_firewall);
	 $is_error = 0;
	log_generator("Security ACL File Writing Start",__FILE__,__FUNCTION__,__LINE__,NULL); 
	$file_dir = $dir_firewall;
	
	$select_qry = "select * from tbl_acl_group where is_active='active'";
	$data_string = ":FORWARD ACCEPT [0:0]\n"; 
	$ip_data = "";
	
	$rs = Sql_exec($cn,$select_qry);
	
	while($dt = Sql_fetch_array($rs)){
		$data_string .= ":" . $dt['group_name'] . " - [0:0]\n";
		$ip_data .= "\n-A FORWARD -j ".$dt['group_name'];
		
		$range_rs = Sql_exec($cn,"select * from tbl_acl_group_ip where is_active = 'active' and acl_group_id = '".$dt['acl_group_id']."' and type='s'");
		while($dt_rs = Sql_fetch_array($range_rs)){
			$range_rs_dest = Sql_exec($cn,"select ip_address from tbl_acl_group_ip where is_active = 'active' and acl_group_id = '".$dt['acl_group_id']."' and type='d'");
			$dest_count = 0;
			while($dt_rs_dest = Sql_fetch_array($range_rs_dest)){
				$ip_data .= "\n-A " . $dt['group_name'];
				$ip_data .= " -s ".$dt_rs['ip_address'];
				$ip_data .= " -d ".$dt_rs_dest['ip_address'];
				$ip_data .= " -j " . $dt['action'];
				$dest_count++;
			}
			if($dest_count == 0){
				$ip_data .= "\n-A " . $dt['group_name'];
				$ip_data .= " -s ".$dt_rs['ip_address'];
				$ip_data .= " -j " . $dt['action'];
			}
		}
	}
	
	$data_string .= ":INPUT ACCEPT [0:0]\n:OUTPUT ACCEPT [0:0]\n:PREROUTING ACCEPT [0:0]\n:POSTROUTING ACCEPT [0:0]" . $ip_data;
	cleanLines($file_dir,"*mangle","COMMIT");
	insertNewLine($file_dir,$data_string,"*mangle","COMMIT");
	
	log_generator("ACL Successfully Written",__FILE__,__FUNCTION__,__LINE__,NULL);
	
	return $is_error;
 }
/**
 * Security Firewall
 */	
 function file_writer_firewall($cn){
	 global $dir_firewall;
	 $is_error = 0;
	log_generator("Security Firewall File Writing Start",__FILE__,__FUNCTION__,__LINE__,NULL); 
	$file_dir = $dir_firewall;
	
	cleanLines($file_dir,"*filter","COMMIT",3);
	
	$select_query = "SELECT * FROM tbl_firewall";
	$rows = Sql_exec($cn, $select_query);
	$result = array();
	
	while($row = Sql_fetch_array($rows,MYSQLI_ASSOC)){
		array_push($result,$row);
	}
	$len = sizeof($result);
	if($len> 0){
		for($i=0;$i<$len;$i++){
			//$type = $result[$i]['type'];
			$chain = $result[$i]['chain'];
			$source = $result[$i]['source'];
			$destination = $result[$i]['destination'];
			$in_interface = $result[$i]['in_interface'];
			$out_interface = $result[$i]['out_interface'];
			$network_protocol = $result[$i]['network_protocol'];
			//$portFrom = $_REQUEST['portFrom'];
			$destination_port = $result[$i]['destination_port'];
			$target = $result[$i]['target'];
			
			$data = "";
			$data .= "-A " . $chain;
			if($source != ""){
				$data .= " -s " . $source;
			}
			if($destination != ""){
				$data .= " -d " . $destination;
			}
			if($in_interface != ""){
				$data .= " -i " . $in_interface;
			}
			if($out_interface != ""){
				$data .= " -o " .$out_interface;
			}
			if($network_protocol != ""){
				$data .= " -p " . $network_protocol;
			}
			if($destination_port != ""){
				$data .= " --dport " . $destination_port;
			}
			
			$data .= " -j " . $target; 
			insertNewLine($file_dir,$data,"*filter","COMMIT");
		}
	} else {
		$data = "";
		insertNewLine($file_dir,$data,"*filter","COMMIT");
	}
	log_generator("Firewall Successfully Written",__FILE__,__FUNCTION__,__LINE__,NULL);
	
	return $is_error;
 }
		
/**
 * Security NAT
 */	
 function file_writer_nat($cn){
	 global $dir_firewall;
	 $iptables_nat_append_cmd = "sudo iptables -t nat ";
	 $is_error = 0;
	log_generator("Security NAT File Writing Start",__FILE__,__FUNCTION__,__LINE__,NULL); 
	$file_dir = $dir_firewall;
	
	cleanLines($file_dir,"*nat","COMMIT",3);
	$clear_loaded_chain_rules_from_system = escapeshellcmd($iptables_nat_append_cmd." -F");
	system($clear_loaded_chain_rules_from_system);
	
	// for static nat
	
	$select_query = "select * from tbl_nat_static where is_active='active'";
	$rows = Sql_exec($cn, $select_query);
	$result = array();

	while($row = Sql_fetch_array($rows,MYSQLI_ASSOC)){
		array_push($result,$row);
	}
	
	$len = sizeof($result);
	if($len > 0){
		for($i=0;$i<$len;$i++){
			
			$destination = ""; $direction = "";$chain = "";$destination_ip = "";$destination_port = "";$forward_ip = "";$forward_port = "";$interface = "";$data = "";
			
			$direction = $result[$i]['direction'];
			$chain = $result[$i]['chain'];
			$destination_ip = $result[$i]['destination_ip'];
			$destination_port = $result[$i]['destination_port'];
			$forward_ip = $result[$i]['forward_ip'];
			$forward_port = $result[$i]['forward_port'];
			$interface = $result[$i]['interface'];
			
			$data = "-A " . $chain . " ";
			$target = "DNAT";
			
				
			if($direction == "incoming"){
				$dir_syn = "i";
			} else {
				$dir_syn = "o";
			}
				
			if( $destination_ip != "" ){
				$source = " -d " . $destination_ip;
			}
			
			if( $destination_port != "" ){
				if( preg_match("/^[,:]+/",$destination_port )){
					
					   $source_port = "--match multiport --dports " . $destination_port;
				}else{
				       $source_port = " --dport " . $destination_port;
				}
			}
			
			if(	$forward_ip != "" ){
				
				$destination = " --to-destination " . $forward_ip;
			}
			
			$destination_port = "";
			if( $forward_port != "" ){
				$destination_port = ":" . $forward_port;
			}
			
			$network_protocol = $result[$i]['network_protocol'];	
			if($interface != "") $interface = " -i " . $interface;
			if( $network_protocol != "" && $network_protocol == 'all' ){
				    
					$protocol = "-p tcp". " -m tcp";
					$data = "-A " . $chain . " ". $protocol  . $interface . $source . $source_port . " -j " . $target;
					$data .= "" . $destination . "" . $destination_port;
					insertNewLine($file_dir,$data,"*nat","COMMIT");
					$full_cmd =  escapeshellcmd($iptables_nat_append_cmd.$data);
					system($full_cmd);
				
				$protocol = "-p icmp". " -m icmp";
					$data = "-A " . $chain . " ". $protocol  . $interface . " -j " . $target;
					$data .= "" . $destination;
					insertNewLine($file_dir,$data,"*nat","COMMIT");
					$full_cmd =  escapeshellcmd($iptables_nat_append_cmd.$data);
					system($full_cmd);
				$protocol = "-p udp". " -m udp";
					$data = "-A " . $chain . " ". $protocol  . $interface . $source . $source_port . " -j " . $target;
					$data .= "" . $destination . "" . $destination_port;
					insertNewLine($file_dir,$data,"*nat","COMMIT");
					$full_cmd =  escapeshellcmd($iptables_nat_append_cmd.$data);
					system($full_cmd);
			}else{
				
				$protocol = "-p ". $network_protocol . " -m ". $network_protocol;
				if( $network_protocol == "icmp" ){
				     $data .= $protocol . $interface . " -j " . $target."" . $destination . "";
				}else{
				      $data .= $protocol . $interface . $source . $source_port . " -j " . $target;
				      $data .= "" . $destination . "" . $destination_port;
				}
				insertNewLine($file_dir,$data,"*nat","COMMIT");
				$full_cmd = escapeshellcmd($iptables_nat_append_cmd.$data);
				system($full_cmd);
			}
			
			
		}
				
	}
		
	// for dynamic nat 
		 
	$select_query = "select * from tbl_nat_dynamic where is_active='active'";
	$rows = Sql_exec($cn, $select_query);
	$result = array();

	while($row = Sql_fetch_array($rows,MYSQLI_ASSOC)){
		array_push($result,$row);
	}
	$len = sizeof($result);
	if($len > 0){
		for($i=0;$i<$len;$i++){
			
			$direction = "";$chain="";$source_ip="";$explore_src_ip="";$destination_ip="";$explore_dest_ip="";$interface="";
			$data= "";
			
			$direction = $result[$i]['direction'];
			$chain = $result[$i]['chain'];
			$source_ip = $result[$i]['source_ip'];
			$explore_src_ip = $result[$i]['exclude_src_ip'];
			$destination_ip = $result[$i]['destination_ip'];
			$explore_dest_ip = $result[$i]['exclude_dest_ip'];
			$interface = $result[$i]['interface'];
			
			$data = "-A " . $chain . " ";
			if($source_ip != ""){
				$source_ip = " -s " . $source_ip;
			}
			
			if( $source_ip == "" && $explore_src_ip != "" && !empty($explore_src_ip) ){
				$explore_src_ip = " ! -s " . $explore_src_ip;
			}else{
				$explore_src_ip = "";
			}
			
			if($destination_ip != ""){
				$destination_ip = " -d " . $destination_ip;
			}else{
				$destination_ip = "";
			}
			
			if( $destination_ip == "" && $explore_dest_ip != "" && !empty($explore_dest_ip) ){
				$explore_dest_ip = " ! -d " . $explore_dest_ip;
			}else{
				$explore_dest_ip = "";
			}
			
			$target = "MASQUERADE";
			$data .=  " -o " . $interface . $source_ip . $explore_src_ip . $destination_ip . $explore_dest_ip . " -j " . $target;
			$direction = "outgoing";
			//echo $data;
                    // exit;
			insertNewLine($file_dir,$data,"*nat","COMMIT");
			$full_cmd = escapeshellcmd($iptables_nat_append_cmd.$data);
			system($full_cmd);
			
			}
	} else {
		$data = "";
		insertNewLine($file_dir,$data,"*nat","COMMIT");
	}
	
	log_generator("NAT Successfully Written",__FILE__,__FUNCTION__,__LINE__,NULL);
	
	return $is_error;
 }
		
/**
 * Security Web Gateway
 */	
 function file_writer_web_gateway($cn){
	 global $dir_proxy;
	 $is_error = 0;
	log_generator("Security Web Gateway File Writing Start",__FILE__,__FUNCTION__,__LINE__,NULL);  
	$dir = $dir_proxy;
	
	$select_qry = "select acl_name,acl_type,acl_content from tbl_proxy where is_active='active'";
	
	$data_string = ""; 
	
	$rs = Sql_exec($cn,$select_qry);
	
	while($dt = Sql_fetch_array($rs)){
		$data_string .= "acl " . $dt['acl_name'] . " " . $dt['acl_type'] . " " . $dt['acl_content'] . "\n";
	}
	
	$select_qry2 = "select acl_in,acl_not_in,restriction from tbl_proxy_acl_restriction where is_active='active' order by serial asc";
	$rs = Sql_exec($cn,$select_qry2);
	
	while($dt = Sql_fetch_array($rs)){
		$acl_in = str_replace(","," ",$dt['acl_in']);
		$acl_not_in = str_replace(","," !",$dt['acl_not_in']);
		$data_string .= "http_access " . $dt['restriction'] . " " . $acl_in;
		
		if($acl_not_in != "") $data_string .= " !" . $acl_not_in;
		
		$data_string .= "\n";
	}
	/*Load all data END*/
                              
	try {
		cleanLines($dir,"acl CONNECT method CONNECT","# Squid normally listens to port 3128");
		insertNewLine($dir,$data_string,"acl CONNECT method CONNECT","# Squid normally listens to port 3128");
	} catch (Exception $o){
		$is_error = 2;
	}
	
	log_generator("Proxy Successfully Written",__FILE__,__FUNCTION__,__LINE__,NULL);
	
	return $is_error;
 }
		
/**
 * Security VPN
 */	
		// IPSEC
function file_writer_vpn_ipsec($cn){	
	global $dir_vpn_ipsec;
	global $dir_vpn_ipsec_secret;
	$is_error = 0;
	log_generator("Security VPN IPSEC File Writing Start",__FILE__,__FUNCTION__,__LINE__,NULL);  	
	$dir = $dir_vpn_ipsec;
	$dir_secret = $dir_vpn_ipsec_secret;
	
	$select_qry = "select * from tbl_vpn_ipsec where is_active='active'";
	
	$data_string = ""; 
	$secret_string = ""; 
	
	$rs = Sql_exec($cn,$select_qry);
	
	while($dt = Sql_fetch_array($rs)){
		/*if($dt['left_v'] == "" || $dt['left_v'] == NULL){
			$left_data = "%defaultroute";
		} else {*/
			$left_data = $dt['left_v'];
		//}
		
		if($dt['leftnexthop'] == "" || $dt['leftnexthop'] == NULL){
			$leftnexthop_data = "%defaultroute";
		} else {
			$leftnexthop_data = $dt['leftnexthop'];
		}
		
		$data_string .= "conn ".$dt['ipsec_name']."\n";
		$data_string .= "\ttype=".$dt['type']."\n";
		$data_string .= "\tauthby=".$dt['authby']."\n";
        $data_string .= "\tleft=".$left_data."\n";
        $data_string .= "\tleftnexthop=".$leftnexthop_data."\n";
        $data_string .= "\tleftsubnets=".$dt['leftsubnet']."\n";
        $data_string .= "\tright=".$dt['right_v']."\n";
        $data_string .= "\trightsubnets=".$dt['rightsubnet']."\n";
        $data_string .= "\tkeyexchange=ike\n";
        $data_string .= "\tike=".$dt['ike']."-".$dt['group_v']."\n";
        $data_string .= "\tphase2=esp\n";
        $data_string .= "\tphase2alg=".$dt['esp']."\n";
        $data_string .= "\tpfs=".$dt['pfs']."\n";
        $data_string .= "\tikelifetime=".$dt['ikelifetime']."s\n";
        $data_string .= "\tkeylife=".$dt['keylife']."s\n";
        $data_string .= "\tauto=".$dt['auto']."\n";
        
		$secret_string .= $left_data." ".$dt['right_v']." : PSK \"".$dt['psk']."\"\n";
	}
	
	/*Load all data END*/
                            
	try {
		file_put_contents($dir,$data_string);
		file_put_contents($dir_secret,$secret_string);
	} catch (Exception $o){
		$is_error = 2;
	}
	
	log_generator("VPN IPSEC Successfully Written",__FILE__,__FUNCTION__,__LINE__,NULL);
	
	return $is_error;
}
		// PPTP Server
function file_writer_vpn_pptp_server($cn){		
	global $dir_vpn_pptp_server;
	$is_error = 0;
	log_generator("Security VPN PPTP Server File Writing Start",__FILE__,__FUNCTION__,__LINE__,NULL);
	$dir = $dir_vpn_pptp_server;
	
	$select_qry = "select * from tbl_pptp_server where is_active='active'";
	
	$data_string = ""; 
	$after_line = "# (Recommended)";
	$before_line = "# or";
	
	$rs = Sql_exec($cn,$select_qry);
	
	while($dt = Sql_fetch_array($rs)){
		$data_string .= "localip ".$dt['local_ip']."\n";
		$data_string .= "remoteip ".$dt['remote_ip']."\n";
		
	}
	
	/*Load all data END*/
                            
	try {
		cleanLines($dir,$after_line,$before_line);
		insertNewLine($dir,$data_string,$after_line,$before_line);
	} catch (Exception $o){
		$is_error = 2;
	}
	
	log_generator("VPN PPTP Successfully Written",__FILE__,__FUNCTION__,__LINE__,NULL);
	
	return $is_error;
}
		// PPTP Client
function file_writer_vpn_pptp_client($cn){
	global $dir_vpn_pptp_client;
	$is_error = 0;		
	log_generator("Security VPN PPTP Client File Writing Start",__FILE__,__FUNCTION__,__LINE__,NULL);
	$dir = $dir_vpn_pptp_client;
	
	$select_qry = "select * from tbl_vpn_pptp_client where is_active='active'";
	
	$data_string = ""; 
	$after_line = "# Apache Use overwrite from here";
	$before_line = "# Apache Use overwrite to here";
	
	$rs = Sql_exec($cn,$select_qry);
	
	while($dt = Sql_fetch_array($rs)){
		$data_string .= "".$dt['user_name']." * ";
		$data_string .= "".$dt['password']." " .$dt['ip']. "\n";
		
	}
	
	/*Load all data END*/
                            
	try {
		cleanLines($dir,$after_line,$before_line);
		insertNewLine($dir,$data_string,$after_line,$before_line);
	} catch (Exception $o){
		$is_error = 2;
	}
	log_generator("VPN PPTP Client Successfully Written",__FILE__,__FUNCTION__,__LINE__,NULL);
	
	return $is_error;
}
		
/**
 * IP PBX
 */	
 function file_writer_ip_pbx($cn){
	 global $dir_ippbx_sip;
	 global $dir_ippbx_extension;
	 $is_error = 0;
	log_generator("IP-PBX File Writing START",__FILE__,__FUNCTION__,__LINE__,NULL);
	
	$select_qry = "select * from tbl_ippbx_extensions where is_active='active'";
	$select_qry_gw = "select * from tbl_ippbx_gw where is_active='active'";
	$data_sip = ""; 
	$data_extern = ""; 
	$context_arr = array();
	
	$rs = Sql_exec($cn,$select_qry);
	
	while($dt = Sql_fetch_array($rs)){
		$e_number = $dt['e_number'];
		$e_secret = $dt['e_secret'];
		$e_nat = $dt['e_nat'];
		$e_context = $dt['e_context'];
		
		$data_sip  .= "[".$e_number."]\ntype=friend\nhost=dynamic\n";
		if($e_secret != "") $data_sip  .= "secret=".$e_secret."\n";
		if($e_context != "") $data_sip  .= "context=".$e_context."\n";
		$data_sip  .= "nat=".$e_nat."\n\n";
		
		if(!in_array($e_context,$context_arr)) array_push($context_arr,$e_context);
	}
	
	$rs = Sql_exec($cn,$select_qry_gw);
	
	while($dt = Sql_fetch_array($rs)){
		$gw_name = $dt['gw_name'];
		$gw_ip = $dt['gw_ip'];
		$gw_port = $dt['gw_port'];
		$gw_direction = $dt['gw_direction'];
		$gw_context = $dt['gw_context'];
		$gw_nat = $dt['gw_nat'];
		
		$data_sip  .= "[".$gw_name."]\ntype=friend\nhost=".$gw_ip."\n";
		if($gw_port != "") $data_sip  .= "port=".$gw_port."\n";
		if($gw_context != "") $data_sip  .= "context=".$gw_context."\n";
		$data_sip  .= "nat=".$gw_nat."\n\n";
		
		if(!in_array($gw_context,$context_arr)) array_push($context_arr,$gw_context);
	}
	
	foreach($context_arr as $context_name){
		$exten_qry = "select e_number from tbl_ippbx_extensions where is_active='active' and e_context='$context_name'";
		$dialplan_qry = "select type,prefix,gw_name from tbl_ippbx_dialplan where is_active='active' and dp_context='$context_name'";
		$data_extern .= "[".$context_name."]\n";
		
		$rs = Sql_exec($cn,$exten_qry);
		while($dt = Sql_fetch_array($rs)){
			$e_number = $dt['e_number'];
			$data_extern .= "exten => ".$e_number.",1,Dial(SIP/".$e_number.")\n";
		}
		
		$rs = Sql_exec($cn,$dialplan_qry);
		while($dt = Sql_fetch_array($rs)){
			$type = $dt['type'];
			$prefix = $dt['prefix'];
			$gw_name = $dt['gw_name'];
			
			if($type == "prefix"){
				$data_extern .= 'exten => _'.$prefix.'X.,1,Dial(SIP/'.$gw_name.'/${EXTEN})';
			} else {
				$data_extern .= 'exten => '.$prefix.',1,Dial(SIP/'.$gw_name.'/${EXTEN})';
			}
			$data_extern .= "\n";
		}
		$data_extern .= "\n";
	}
	
	/*Load all data END*/
    
	try {
		file_put_contents($dir_ippbx_sip,$data_sip);
		file_put_contents($dir_ippbx_extension,$data_extern);
	} catch (Exception $o){
		$is_error = 2;
	}
	
	log_generator("IP-PBX File Writing END",__FILE__,__FUNCTION__,__LINE__,NULL);
 }
 
 
/**
 * Bandwidth Manager
 */	 
 
 
 function bwmFile($cn,$interface,$bridge_trigger = "off")
{
	global $dir_bwm;
	
	log_generator("Bandwidth Manager File Writing Start",__FILE__,__FUNCTION__,__LINE__,NULL); 
	
	$file=$dir_bwm.$interface."-qos.xml";
	$qry="SELECT id,group_name,bandwidth,bw_limit,laninterface,waninterface,g_priority FROM tbl_bwm_group WHERE laninterface='$interface' OR waninterface LIKE '%$interface%'";
	$rs=Sql_exec($cn,$qry);
	$data="<?xml version='1.0' encoding='UTF-8'?>\r\n<root rate='1024000' ceil='1024000' quantum='6000'>";
	$count=0;
	while($dt=Sql_fetch_array($rs)) 
	{
		$count++;
		$data=$data."\r\n<class>";
		$group_id=$dt['id'];
		$group_name=$dt['group_name'];
		$bandwidth=$dt['bandwidth'];
		$bw_limit=$dt['bw_limit'];
		$grp_laninterface=$dt['laninterface'];
		$grp_waninterface=$dt['waninterface'];
		$g_priority=$dt['g_priority'];
		
		if($g_priority == "") $g_priority=0;
		
		$data=$data."\r\n\t<name>$group_name</name>";
		$data=$data."\r\n\t<id>$group_id</id>";
		$data=$data."\r\n\t<bandwidth>$bandwidth</bandwidth>";
		$data=$data."\r\n\t<limit>$bw_limit</limit>";
		$data=$data."\r\n\t<burst>0</burst>";
		$data=$data."\r\n\t<priority>$g_priority</priority>";
		$data=$data."\r\n\t<que>sfq</que>";
		
		/** Multiple IP
		*/
		
		$qry="SELECT id,client_name,download,upload,min_download,min_upload,c_priority,mac,mac_status FROM tbl_bwm_client WHERE group_id=$group_id and status='enable'";
		$rs_client=Sql_exec($cn,$qry);
		
		while($dt_client=Sql_fetch_array($rs_client))
		{			
			if($bridge_trigger == "on"){ //for bridge
				
				$client_id=$dt_client['id'];
				$client_name=$dt_client['client_name'];
				//$ip=$dt_client['ip'];
				$download=$dt_client['download'];
				$upload=$dt_client['upload'];
				$min_download=$dt_client['min_download'];
				$min_upload=$dt_client['min_upload'];
				$c_priority = $dt_client['c_priority'];
				$mac = $dt_client['mac'];
				$mac_status = $dt_client['mac_status'];
				
				if($c_priority == "") $c_priority=0;
				
				$client_speed = $min_download;
				$client_limit = $download;
					
				$data=$data."\r\n\t<client>";
				$data=$data."\r\n\t\t<name>$client_name</name>";
				$data=$data."\r\n\t\t<id>$client_id</id>";
				$data=$data."\r\n\t\t<bandwidth>$client_speed</bandwidth>";
				$data=$data."\r\n\t\t<limit>$client_limit</limit>";
				$data=$data."\r\n\t\t<burst>0</burst>";
				$data=$data."\r\n\t\t<priority>$c_priority</priority>";
				if(($mac_status == "enable") && (trim($mac) != "")) $data=$data."\r\n\t\t<mac>$mac</mac>";
				
				
				
				$qry_ip = "SELECT src_ip,src_port,dst_ip,dst_port FROM tbl_bwm_client_ip WHERE client_id=$client_id";
				$rs_client_ip = Sql_exec($cn,$qry_ip);
				
				while($dt_client_ip=Sql_fetch_array($rs_client_ip))
				{
					$src_ip = $dt_client_ip['src_ip'];
					$src_port = $dt_client_ip['src_port'];
					$dst_ip = $dt_client_ip['dst_ip'];
					$dst_port = $dt_client_ip['dst_port'];
					
					if(trim($src_ip)==""){
						$src_ip = "0.0.0.0";
					}
					if(trim($dst_ip)==""){
						$dst_ip = "0.0.0.0";
					}
					
					$source_ip = $dst_ip;
					$source_port = $dst_port;
					$destination_ip = $src_ip;
					$destination_port = $src_port;
					
					$data=$data."\r\n\t\t<rule>";
					$data=$data."\r\n\t\t\t<src>";
					$data=$data."\r\n\t\t\t\t<ip>$source_ip</ip>";
					if(trim($source_port) != "")$data=$data."\r\n\t\t\t\t<port>$source_port</port>";
					$data=$data."\r\n\t\t\t</src>";
					$data=$data."\r\n\t\t\t<dst>";
					$data=$data."\r\n\t\t\t\t<ip>$destination_ip</ip>";
					if(trim($destination_port) != "")$data=$data."\r\n\t\t\t\t<port>$destination_port</port>";
					$data=$data."\r\n\t\t\t</dst>";
					$data=$data."\r\n\t\t</rule>";
					
					$source_ip = $src_ip;
					$source_port = $src_port;
					$destination_ip = $dst_ip;
					$destination_port = $dst_port;
					
					$data=$data."\r\n\t\t<rule>";
					$data=$data."\r\n\t\t\t<src>";
					$data=$data."\r\n\t\t\t\t<ip>$source_ip</ip>";
					if(trim($source_port) != "")$data=$data."\r\n\t\t\t\t<port>$source_port</port>";
					$data=$data."\r\n\t\t\t</src>";
					$data=$data."\r\n\t\t\t<dst>";
					$data=$data."\r\n\t\t\t\t<ip>$destination_ip</ip>";
					if(trim($destination_port) != "")$data=$data."\r\n\t\t\t\t<port>$destination_port</port>";
					$data=$data."\r\n\t\t\t</dst>";
					$data=$data."\r\n\t\t</rule>";
				}
				$data=$data."\r\n\t</client>";
			} else {
				$data=$data."\r\n\t<client>";
				$client_id=$dt_client['id'];
				$client_name=$dt_client['client_name'];
				//$ip=$dt_client['ip'];
				$download=$dt_client['download'];
				$upload=$dt_client['upload'];
				$min_download=$dt_client['min_download'];
				$min_upload=$dt_client['min_upload'];
				$c_priority = $dt_client['c_priority'];
				$mac = $dt_client['mac'];
				$mac_status = $dt_client['mac_status'];
				
				if($c_priority == "") $c_priority=0;
				
				if($grp_laninterface == $interface){
					$client_speed = $min_download;
					$client_limit = $download;
				} else {
					$client_speed = $min_upload;
					$client_limit = $upload;
				}
				
				$data=$data."\r\n\t\t<name>$client_name</name>";
				$data=$data."\r\n\t\t<id>$client_id</id>";
				$data=$data."\r\n\t\t<bandwidth>$client_speed</bandwidth>";
				$data=$data."\r\n\t\t<limit>$client_limit</limit>";
				$data=$data."\r\n\t\t<burst>0</burst>";
				$data=$data."\r\n\t\t<priority>$c_priority</priority>";
				if(($mac_status == "enable") && (trim($mac) != "")) $data=$data."\r\n\t\t<mac>$mac</mac>";
				
				
				$qry_ip = "SELECT src_ip,src_port,dst_ip,dst_port FROM tbl_bwm_client_ip WHERE client_id=$client_id";
				$rs_client_ip = Sql_exec($cn,$qry_ip);
				while($dt_client_ip=Sql_fetch_array($rs_client_ip))
				{
					$src_ip = $dt_client_ip['src_ip'];
					$src_port = $dt_client_ip['src_port'];
					$dst_ip = $dt_client_ip['dst_ip'];
					$dst_port = $dt_client_ip['dst_port'];
						
					if(trim($src_ip)==""){
						$src_ip = "0.0.0.0";
					}
					if(trim($dst_ip)==""){
						$dst_ip = "0.0.0.0";
					}
						
					if($grp_laninterface == $interface){ 		// download
						$source_ip = $dst_ip;
						$source_port = $dst_port;
						$destination_ip = $src_ip;
						$destination_port = $src_port;
					} else { 									//upload
						$source_ip = $src_ip;
						$source_port = $src_port;
						$destination_ip = $dst_ip;
						$destination_port = $dst_port;
					}
						$data=$data."\r\n\t\t<rule>";
						$data=$data."\r\n\t\t\t<src>";
						$data=$data."\r\n\t\t\t\t<ip>$source_ip</ip>";
						if(trim($source_port) != "")$data=$data."\r\n\t\t\t\t<port>$source_port</port>";
						$data=$data."\r\n\t\t\t</src>";
						$data=$data."\r\n\t\t\t<dst>";
						$data=$data."\r\n\t\t\t\t<ip>$destination_ip</ip>";
						if(trim($destination_port) != "")$data=$data."\r\n\t\t\t\t<port>$destination_port</port>";
						$data=$data."\r\n\t\t\t</dst>";
						$data=$data."\r\n\t\t</rule>";			
				} 									
				$data=$data."\r\n\t</client>";
			}
		}
		
		$data=$data."\r\n</class>";				
	}
	$qry="SELECT default_limit FROM tbl_bwm_default_limit limit 1";
	$rs_d=Sql_fetch_array(Sql_exec($cn,$qry));
	$d_limit = $rs_d['default_limit'];
	$data=$data."\r\n<class>\r\n\t<name>default</name>\r\n\t<limit>$d_limit</limit>\r\n</class>";
	$data=$data."\r\n</root>";
	if($count==0)
	{	
		if(file_exists($file))
			unlink($file);
	} else {
		file_put_contents($file,$data);
	}
	log_generator("Bandwidth Manager File Successfully Written",__FILE__,__FUNCTION__,__LINE__,NULL); 
}

/** File write for VRRP
*/
function file_writer_vrrp($cn){
	global $dir_vrrp;
	$is_error = 0;
	$track_interfaces = array();
	log_generator("Network Setting VRRP File Write Start",__FILE__,__FUNCTION__,__LINE__,NULL);
	
	$select_qry = "SELECT id, instance_name, interface, virtual_router_id, priority, advert_int,auth_pass, track_port, track_priority, virtual_ipaddress 
				   FROM tbl_vrrp_instance 
				   WHERE is_active='active'";
	
	$rs=Sql_exec($cn,$select_qry);
	
	$data_string = "";
	
	while($dt=Sql_fetch_array($rs)){
		$instance_name = $dt['instance_name'];
		$interface = $dt['interface'];
		$virtual_router_id = $dt['virtual_router_id'];
		$priority = $dt['priority'];
		$advert_int = $dt['advert_int'];
		$auth_pass = $dt['auth_pass'];
		$track_port = $dt['track_port'];
		$track_priority = $dt['track_priority'];
		$virtual_ipaddress = $dt['virtual_ipaddress'];
	
		$track_interfaces = explode(",",$track_port);

		$data_string .= "vrrp_instance ".$instance_name." {"."\n";
		$data_string .= "\t"."state MASTER"."\n";
		$data_string .= "\t"."interface ".$interface."\n";
		if(trim($track_port) !=""){
			$data_string .= "\t"."track_interface {"."\n";
			foreach($track_interfaces as $key=>$value){
				$data_string .= "\t\t".$value."\n";
			}
			$data_string .= "\t"."}"."\n";
		}
		$data_string .= "\t"."virtual_router_id ".$virtual_router_id."\n";
		$data_string .= "\t"."priority ".$priority."\n";
		$data_string .= "\t"."advert_int ".$advert_int."\n";
		$data_string .= "\t"."authentication {"."\n";
		$data_string .= "\t\t"."auth_type PASS"."\n";
		$data_string .= "\t\t"."auth_pass ".$auth_pass."\n";
		$data_string .= "\t"."}"."\n";
		$data_string .= "\t"."virtual_ipaddress {"."\n";
		$data_string .= "\t\t".trim($virtual_ipaddress)."\n";
		$data_string .= "\t"."}"."\n";
		if(trim($track_port) !=""){
		$data_string .= "\t"."preempt"."\n";		
		}
		$data_string .= "}"."\n\n";
	}
	
	$after_line = "! SSD-TECH Space Start";
	$before_line = "! SSD-TECH Space End";
	try {
		cleanLines($dir_vrrp,$after_line,$before_line);
		insertNewLine($dir_vrrp,$data_string,$after_line,$before_line);
	} catch (Exception $o){
	 	$is_error = 2;
	}
			 
	log_generator("Network Setting VRRP File Successfully Written",__FILE__,__FUNCTION__,__LINE__,NULL);
	 
	return $is_error;
}

function file_writer_xl2tp($cn){
	
	global $dir_vpn_xl2tp,$dir_vpn_ms_dns;
	$is_error = 0;		
	log_generator("Security VPN L2TP File Writing Start",__FILE__,__FUNCTION__,__LINE__,NULL);
	$dir1 = $dir_vpn_xl2tp;
	$dir2 = $dir_vpn_ms_dns;
	
	$select_qry = "SELECT 
						listen_address, 
						ip_range, 
						local_ip,
				        ms_dns 
				   FROM tbl_vpn_l2tp";
	
	$l2tp_string = ""; 
	$ms_dns_string = "";
	$after_line = "#START";
	$before_line = "#END";
	
	$rs = Sql_exec($cn,$select_qry);
	
	while($dt = Sql_fetch_array($rs)){
		if( $l2tp_string == "" ){
			$l2tp_string = "listen-addr = ".$dt['listen_address']."\n"."ip range = ".$dt['ip_range']."\n"."local ip = ".$dt['local_ip'];
		}else{
			$l2tp_string .= "\n\n"."listen-addr = ".$dt['listen_address']."\n"."ip range = ".$dt['ip_range']."\n"."local ip = ".$dt['local_ip'];
		}
		
		if( $ms_dns_string == "" ){
		   $ms_dns_string = "ms-dns ".$dt['ms_dns'];
		}else{
		   	$ms_dns_string .="\n"."ms-dns ".$dt['ms_dns'];
		}
	}
	
	/*Load all data END*/
                            
	try {
		cleanLines($dir1,$after_line,$before_line);
		insertNewLine($dir1,$l2tp_string,$after_line,$before_line);
		cleanLines($dir2,$after_line,$before_line);
		insertNewLine($dir2,$ms_dns_string,$after_line,$before_line);
	} catch (Exception $o){
		$is_error = 2;
	}
	log_generator("VPN L2TP Successfully Written",__FILE__,__FUNCTION__,__LINE__,NULL);
	
	return $is_error;
}

function file_writer_xl2tp_client($cn){
	
	global $dir_vpn_xl2tp_client;
	$is_error = 0;		
	log_generator("Security VPN L2TP Client File Writing Start",__FILE__,__FUNCTION__,__LINE__,NULL);
	$dir = $dir_vpn_xl2tp_client;

	
	$select_qry = "SELECT user, 
						  password, 
						  ip
				   FROM tbl_vpn_l2tp_client";
	
	$l2tp_client_string = ""; 

	$after_line = "#START";
	$before_line = "#END";
	
	$rs = Sql_exec($cn,$select_qry);
	
	while($dt = Sql_fetch_array($rs)){
		if( $l2tp_client_string  == "" ){
			$l2tp_client_string  = $dt['user']." * ".$dt['password']." ".$dt['ip'];
		}else{
			$l2tp_client_string .= "\n".$dt['user']." * ".$dt['password']." ".$dt['ip'];
		}
	}
	
	/*Load all data END*/
                            
	try {
		cleanLines($dir,$after_line,$before_line);
		insertNewLine($dir,$l2tp_client_string,$after_line,$before_line);
	} catch (Exception $o){
		$is_error = 2;
	}
	log_generator("VPN L2TP Client Successfully Written",__FILE__,__FUNCTION__,__LINE__,NULL);
	
	return $is_error;
}


function file_writer_firewall_group($cn) {
    global $dir_firewall_test;
    global $dir_firewall_production;
    global $dir_bwp_test;
    global $dir_bwp_production;

    $is_error = 0;
    log_generator("Filewall Group File Writing Start", __FILE__, __FUNCTION__, __LINE__, NULL);

    $firewall_test = $dir_firewall_test;
    $firewall_production = $dir_firewall_production;
    $bwp_test = $dir_bwp_test;
    $bwp_production = $dir_bwp_production;

    $select_qry = "select * from tbl_firewall_group where is_active='active'";


    $rs = Sql_exec($cn, $select_qry);

    while ($dt = Sql_fetch_array($rs)) {
        $group_name = $dt['group_name'];
        $data_string = $dt['group_content'];
        $file_name = $firewall_test . "/firewallRules/" . $group_name . ".txt";
        file_put_contents($file_name, $data_string);

        $file_name = $firewall_production . "/firewallRules/" . $group_name . ".txt";
        file_put_contents($file_name, $data_string);

        $file_name = $bwp_test . "/firewallRules/" . $group_name . ".txt";
        file_put_contents($file_name, $data_string);

        $file_name = $bwp_production . "/firewallRules/" . $group_name . ".txt";
        file_put_contents($file_name, $data_string);
    }

    log_generator("Filewall Group File Successfully Written", __FILE__, __FUNCTION__, __LINE__, NULL);

    return $is_error;
}

function file_writer_firewall_rule($cn) {
    global $dir_firewall_test;
    global $dir_firewall_production;
    global $dir_bwp_test;
    global $dir_bwp_production;
    $is_error = 0;
    log_generator("Filewall Rule File Writing Start", __FILE__, __FUNCTION__, __LINE__, NULL);

    $firewall_test = $dir_firewall_test;
    $firewall_production = $dir_firewall_production;
    $bwp_test = $dir_bwp_test;
    $bwp_production = $dir_bwp_production;

    $select_qry = "select * from tbl_firewall_rule where is_active='active'";

    $rs = Sql_exec($cn, $select_qry);
    $data_string = "";
    while ($dt = Sql_fetch_array($rs)) {
        $select_group_type = "select * from tbl_firewall_group where group_name='" . $dt['destination_address'] . "'";
        $rs_group_type = Sql_exec($cn, $select_group_type);
        $dest = '';
        $host = '';
        if (Sql_Num_Rows($rs_group_type) > 0) {
            while ($dt_group_type = Sql_fetch_array($rs_group_type)) {
                if ($dt_group_type == "ip") {
                    $dest = $dt['destination_address'];
                    $host = 'all';
                } else {
                    $dest = 'all';
                    $host = $dt['destination_address'];
                }
            }
        } else {
            $dest_array = explode('.', $dt['destination_address']);
            if (sizeof($dest_array) > 2) {
                $dest = $dt['destination_address'];
                $host = 'all';
            } else {
                $dest = 'all';
                $host = $dt['destination_address'];
            }
        }

        $data_string .= $dt['source_address'] . "|" . $dest . "|" . $dt['port'] . "|" . $dt['protocol'] . "|" . $host . "|" . $dt['start_time'] . "|" . $dt['end_time'] . "|" . $dt['action'] . "\n";
    }

    $file_name = $firewall_test . "/firewallRules/rules.txt";
    file_put_contents($file_name, $data_string);

    $file_name = $firewall_production . "/firewallRules/rules.txt";
    file_put_contents($file_name, $data_string);

    $file_name = $bwp_test . "/firewallRules/rules.txt";
    file_put_contents($file_name, $data_string);

    $file_name = $bwp_production . "/firewallRules/rules.txt";
    file_put_contents($file_name, $data_string);

    log_generator("Filewall Rule File Successfully Written", __FILE__, __FUNCTION__, __LINE__, NULL);

    return $is_error;
}
// Log Generate [ Updated- 19/10/2014 ]

function log_generator($msg,$file,$function,$line,$cn=NULL){
    global $LOG_TYPE;
    global $LOG_HOLDER;

    if($LOG_TYPE == "FILE"){
        $log_file_name = $LOG_HOLDER . date("Y-m-d-H",strtotime("now")) . ".log";
        $current_datetime = date("Y-m-d H:i:s",strtotime("now"));
        if(!file_exists($log_file_name)){
            $ourFileName = $log_file_name;
            $ourFileHandle = fopen($ourFileName, 'w');
            $Data = "START AT ".$current_datetime."\n";
            fwrite($ourFileHandle, $Data);
            fclose($ourFileHandle);
        }

        $data = file_get_contents($log_file_name);
        $data .= "[".$current_datetime."]  USER:: " . $_SESSION["LoggedInUserID"] . "(" . $_SESSION["USER_ID"] .")";
        $data .= " :: " . $msg . " :: " . $file . " :: " . $function . " :: " . $line . "\n";
        file_put_contents($log_file_name,$data);
    } elseif($LOG_TYPE == "DB"){
        $user = $_SESSION["LoggedInUserID"] . "(" . $_SESSION["USER_ID"] .")";
        $message = $msg . " :: " . $file . " :: " . $function . " :: " . $line;
        $qry = "insert into $LOG_HOLDER (user_info,message,date_time) values ('$user','$message',now())";
        Sql_exec($cn,$qry);
    }
}
function file_writer_bwp($cn){
    global $dir_bwp;
    $file_name = $dir_bwp."bwp".".ini";
    $is_error = 0;
    log_generator("BWP File Writing Start",__FILE__,__FUNCTION__,__LINE__,NULL);
    $select_qry = "select * from tbl_bwp_config limit 1";
    $data_string = "";
    $rs = Sql_exec($cn,$select_qry);
    while($row = Sql_fetch_array($rs)){
        $data_string .= "[Device Related Configuration]"."\r\n";
        $data_string .="DEVICE_ID->".$row["device_id"]."\r\n";
        $data_string .="DEVICE_IP->".$row["device_ip"]."\r\n";
        $data_string .= "[User Related Configuration]"."\r\n";
        $data_string .="IDLE_USER_TIME->".  $row["idle_user_time"]."\r\n";
        $data_string .="DATA_LOG_DIRECTORY->".  $row["data_log_directory"]."\r\n";
        $data_string .="USER_LOG_DIRECTORY->".  $row["user_log_directory"]."\r\n";
        $data_string .= "[NFQUEUE Related Configuration]"."\r\n";
        $data_string .="QUEUE_NUMBER->".  $row["nfqueue_num"]."\r\n";
        $data_string .= "[BWP Configuration]"."\r\n";
        $data_string .="BWP_ENABLE->".  $row["bwp_enable"]."\r\n";
        $data_string .="SUBNET_MASK->".  $row["subnet_mask"]."\r\n";
        $data_string .="CDR_INTERVAL->".  $row["cdr_interval"]."\r\n";
        $data_string .="CDR_LOG_DIRECTORY->".  $row["cdr_log_directory"]."\r\n";
        $data_string .= "[Log Activity Configuration]"."\r\n";
        $data_string .="LOG_LEVEL->".  $row["log_level"]."\r\n";
        $data_string .= "[CGW Configuration]"."\r\n";
        $data_string .="CGW_ENABLE->".  $row["cgw_enable"]."\r\n";
        $data_string .="CGW_DATA_LIMIT->".  $row["cgw_data_limit"]."\r\n";
        $data_string .="CGW_LOG_DIRECTORY->".  $row["cgw_log_directory"]."\r\n";
        $data_string .="CGW_REQ_DIRECTORY->".  $row["cgw_req_directory"]."\r\n";
        $data_string .="APP_ID->".  $row["app_id"]."\r\n";
        $data_string .="APP_PWD->".  $row["app_password"]."\r\n";
        $data_string .="CGW_IP->".  $row["cgw_ip"]."\r\n";
        $data_string .="CGW_PORT->".  $row["cgw_port"]."\r\n";
        $data_string .="CGW_URI->".  $row["cgw_uri"]."\r\n";
        $data_string .="CGW_HOST_NAME->".  $row["cgw_host_name"]."\r\n";
        $data_string .="SELF_CARE_IP->".  $row["self_care_ip"]."\r\n";
        $data_string .="ACCEPT_PORT->".  $row["accept_port"]."\r\n";
    }
    file_put_contents($file_name, $data_string);
    log_generator("BWP Successfully Written", __FILE__, __FUNCTION__, __LINE__, NULL);
    return $is_error;
}
function file_writer_firewall_config($cn){
    global $dir_firewall_config;
    $file_name = $dir_firewall_config."firewall".".ini";
    $is_error = 0;
    log_generator("Firewall File Writing Start",__FILE__,__FUNCTION__,__LINE__,NULL);
    $select_qry = "select * from tbl_firewall_config limit 1";
    $data_string = "";
    $rs = Sql_exec($cn,$select_qry);
    while($row = Sql_fetch_array($rs)){
        $data_string .= "[Device Related Configuration]"."\r\n";
        $data_string .="DEVICE_ID->".$row["device_id"]."\r\n";
        $data_string .="DEVICE_IP->".$row["device_ip"]."\r\n";
        $data_string .= "[NFQUEUE Related Configuration]"."\r\n";
        $data_string .="QUEUE_NUMBER->".  $row["nfqueue_num"]."\r\n";
        $data_string .= "[USER Information Configuration]"."\r\n";
        $data_string .="SUBNET_MASK->".  $row["subnet_mask"]."\r\n";
        $data_string .= "[Log Activity Configuration]"."\r\n";
        $data_string .="LOG_LEVEL->".  $row["log_level"]."\r\n";
        $data_string .= "[FIREWALL Configuration]"."\r\n";
        $data_string .="FIREWALL_ENABLE->".  $row["firewall_enable"]."\r\n";
        $data_string .="FIREWALL_DIRECTORY->".  $row["firewall_directory"]."\r\n";
        $data_string .="FIREWALL_RULE_FILE->".  $row["firewall_rule_file"]."\r\n";
        $data_string .="APP_ID->".  $row["app_id"]."\r\n";
        $data_string .="APP_PWD->".  $row["app_password"]."\r\n";
    }
    file_put_contents($file_name, $data_string);
    log_generator("Firewall Successfully Written", __FILE__, __FUNCTION__, __LINE__, NULL);
    return $is_error;
}

// smsgw configuration file write

function file_writer_smsgw_configuration($assoc_array){
  	global $path_of_smsgw_configuration;
      
	if($handle = fopen($path_of_smsgw_configuration,"w")){
	        
				$string = "";
				$string .= "[Address of SMSC (SMSS)]"."\n";
				$string .= "SMSC_IP->".$assoc_array['SMSC_IP']."\n";
				$string .= "SMSC_PORT->".$assoc_array['SMSC_PORT']."\n\n";
				
				$string .= "[username and password for SMPP client (silverstreet)]"."\n";
				$string .= "SMSC_USERNAME->".$assoc_array['SMSC_USERNAME']."\n";
				$string .= "SMSC_PASSWORD->".$assoc_array['SMSC_PASSWORD']."\n";
				$string .= "MODE->".$assoc_array['MODE']."\n\n";
				
				$string .= "[Number specification]"."\n";
				$string .= "TON->".$assoc_array['TON']."\n";
				$string .= "NPI->".$assoc_array['NPI']."\n";
				$string .= "SRCTON->".$assoc_array['SRCTON']."\n";
				$string .= "SRCNPI->".$assoc_array['SRCNPI']."\n";
				$string .= "DESTTON->".$assoc_array['DESTTON']."\n";
				$string .= "DESTNPI->".$assoc_array['DESTNPI']."\n\n";
				
				$string .= "[Address and Url of webservice]"."\n";
				$string .= "CDE_FAILED_SMS->".$assoc_array['CDE_FAILED_SMS']."\n";
				$string .= "CDE_URL->".$assoc_array['CDE_URL']."\n";
				$string .= "NO-REPLY-STRING->".$assoc_array['NO-REPLY-STRING']."\n\n";
				
				$string .= "[Channel Configuration]"."\n";
				$string .= "SMPP->".$assoc_array['SMPP']."\n";
				$string .= "HTTP->".$assoc_array['HTTP']."\n\n";
				
				$string .= "[Database related information]"."\n";
				$string .= "DATABASE_HOST->".$assoc_array['DATABASE_HOST']."\n";
				$string .= "DATABASE_USERNAME->".$assoc_array['DATABASE_USERNAME']."\n";
				$string .= "DATABASE_PASSWROD->".$assoc_array['DATABASE_PASSWROD']."\n";
				$string .= "DATABASE_NAME->".$assoc_array['DATABASE_NAME']."\n\n";
				
				$string .= "[SUBMIT_SM_DELAY->205]"."\n";
				$string .= "TPS->".$assoc_array['TPS']."\n\n";
				
				$string .= "[Configuration for SMS Cient Id]"."\n";
				$string .= "SMS_CLIENT_ID->".$assoc_array['SMS_CLIENT_ID']."\n";
				$string .= "TPS_URL->".$assoc_array['TPS_URL']."\n\n";
				
				$string .= "[MakeQueOrFail thread enable configuration]"."\n";
				$string .= "IS_REQUE_ENABLE->".$assoc_array['IS_REQUE_ENABLE']."\n\n";
				
				$string .= "[TPS_RECORD_TIME->10m means keep track of TPS for 10 minutes. s can represent second]"."\n";
				$string .= "TPS_LOG_ENABLE->".$assoc_array['TPS_LOG_ENABLE']."\n";
				$string .= "TPS_RECORD_TIME->".$assoc_array['TPS_RECORD_TIME']."m"."\n\n";
				
				$string .= "[SMS Sender Thread Config]"."\n";
				$string .= "RETRYCOUNT->".$assoc_array['RETRYCOUNT']."\n";
				$string .= "RETRY_DELAY->".$assoc_array['RETRY_DELAY']." SECOND"."\n";
				$string .= "MAX_NUMBER_OF_ROW_FETCH->".$assoc_array['MAX_NUMBER_OF_ROW_FETCH']."\n";
				$string .= "CONTENT_THREAD_COUNT->".$assoc_array['CONTENT_THREAD_COUNT']."\n";
				$string .= "OUTBOX_THREAD_COUNT->".$assoc_array['OUTBOX_THREAD_COUNT']."\n";
				$string .= "SUBMISSION_RETRY_GAP->".$assoc_array['SUBMISSION_RETRY_GAP']." SECOND"."\n";
				$string .= "USE_DEFAULT_STATUS->".$assoc_array['USE_DEFAULT_STATUS']."\n";
				$string .= "INTERIM_STATUS->".$assoc_array['INTERIM_STATUS']."\n\n";
				
				$string .= "[Delivery time specification]"."\n";
				$string .= "DELIVERY_RECEIVED_ENNABLE->".$assoc_array['DELIVERY_RECEIVED_ENNABLE']."\n\n";
				
				$string .= "[keep alive]"."\n";
				$string .= "HEART_BEAT_DELAY->".$assoc_array['HEART_BEAT_DELAY']." SECOND"."\n\n";
				
				$string .= "[Information of SNMP]"."\n";
				$string .= "SNMP_ENABLED->".$assoc_array['SNMP_ENABLED']."\n";
				$string .= "SNMP_MANAGER_HOST_IP->".$assoc_array['SNMP_MANAGER_HOST_IP']."\n";
				$string .= "SNMP_MANAGER_PORT_NO->".$assoc_array['SNMP_MANAGER_PORT_NO']."\n";
				$string .= "SNMP_LOCAL_IP->".$assoc_array['SNMP_LOCAL_IP']."\n";
				$string .= "SNMP_LOCAL_PORT->".$assoc_array['SNMP_LOCAL_PORT']."\n";
				$string .= "SNMP_AGENT_IP->".$assoc_array['SNMP_AGENT_IP']."\n";
				$string .= "SNMP_INSTANCE_NAME->".$assoc_array['SNMP_INSTANCE_NAME']."\n\n";
				
				$string .= "[SMPP Charging Configuration]"."\n";
				$string .= "SMPP_CHARGING_ENABLE->".$assoc_array['SMPP_CHARGING_ENABLE']."\n";
				$string .= "SMPP_CHARGING_URL->".$assoc_array['SMPP_CHARGING_URL']."\n";
				$string .= "SMPP_CHARGING_TYPE->".$assoc_array['SMPP_CHARGING_TYPE']."\n\n";
				
				$string .= "[Log writing specification]"."\n";
				$string .= "SMSLOG_ENABLED->".$assoc_array['SMSLOG_ENABLED']."\n";
				$string .= "LOG_DIRECTORY_NAME->".$assoc_array['LOG_DIRECTORY_NAME']."\n";
				$string .= "; Log Levels: 4: E_INFO, 8: E_ERROR, 32: E_DEBUG_MAJOR, 255: E_ALL"."\n";
				$string .= "LOG_LEVEL->".$assoc_array['LOG_LEVEL']."\n";
				$string .= "; Log Destinations: 2:LOG_TO_FILE, 4: LOG_TO_SERVER, 8: LOG_TO_SCREEN, 10: ALL"."\n";
				$string .= "LOG_DESTINATION->".$assoc_array['LOG_DESTINATION']."\n";
				$string .= "LOG_HOST->".$assoc_array['LOG_HOST']."\n";
				$string .= "LOG_PORT->".$assoc_array['LOG_PORT']."\n";
				$string .= "LOG_COMPONENT->".$assoc_array['LOG_COMPONENT']."\n\n";
				
				$string .= "[Configuration for unicode/ binary]"."\n";
				$string .= "BINARYSMS->".$assoc_array['BINARYSMS']."\n";
				$string .= "BIN_SEGMENT_SIZE->".$assoc_array['BIN_SEGMENT_SIZE']."\n\n";
				
				$string .= "[Number specific log]"."\n";
				$string .= "NUMBER_SPECIFIC_LOG_ENABLE->".$assoc_array['NUMBER_SPECIFIC_LOG_ENABLE']."\n";
				$string .= "NUMBER1->".$assoc_array['NUMBER1']."\n";
				$string .= "NUMBER2->".$assoc_array['NUMBER2']."\n\n";
				
				$string .= "[Command process]"."\n";
				$string .= "COMMAND_PROCESS_PORT->".$assoc_array['COMMAND_PROCESS_PORT']."\n\n";
				
				fwrite($handle,$string);
				fclose($handle);
				return 0;
			
		}else{
		       //echo "Cann't Open File";	
			   return 1;
		}

             
              

}

?>
