<?php
	include "bafconfig.php";
	require_once "commonlib.php";
	$cn=connectDB();
	
    $file = $dir . "ifcfg-vlan" . mysql_real_escape_string(htmlspecialchars($_REQUEST["interface_name"]));
	//try {
    if($handle = fopen($file, 'w')){
		$writingString = "# Broadcom Corporation NetXtreme II BCM5716 Gigabit Ethernet
DEVICE=vlan" . mysql_real_escape_string(htmlspecialchars($_REQUEST["interface_name"])) . "
BOOTPROTO=static
ONBOOT=yes
TYPE=Bridge
IPADDR=x.x.x.x
NETMASK=y.y.y.y
#GATEWAY=z.z.z.z
STP=yes
DELAY=15
";
		fwrite($handle, $writingString);
		fclose($handle);
	}
    $b1 = mysql_real_escape_string(htmlspecialchars($_REQUEST['bridge1']));
    if ($b1 != "") {
        $file = $dir . mysql_real_escape_string(htmlspecialchars($_REQUEST['bridge1']));
        $data = readMyFile($file);
        if($handle = fopen($file, 'w')){
			$bridgeTag = "BRIDGE=";
			$fIndex = strpos($data, $bridgeTag) + strlen($bridgeTag);
			$data = substr($data, 0, $fIndex) . "vlan" . mysql_real_escape_string(htmlspecialchars($_REQUEST["interface_name"]));
			fwrite($handle, $data);
			fclose($handle);
		}
    }
    $b2 = mysql_real_escape_string(htmlspecialchars($_REQUEST['bridge2']));
    if ($b2 != "") {
        $file = $dir . mysql_real_escape_string(htmlspecialchars($_REQUEST['bridge2']));
        $data = readMyFile($file);
        if($handle = fopen($file, 'w')){
			$bridgeTag = "BRIDGE=";
			$fIndex = strpos($data, $bridgeTag) + strlen($bridgeTag);
			$data = substr($data, 0, $fIndex) . "vlan" . mysql_real_escape_string(htmlspecialchars($_REQUEST["interface_name"]));
			fwrite($handle, $data);
			fclose($handle);
		}
    }
    $b3 = mysql_real_escape_string(htmlspecialchars($_REQUEST['bridge3']));
    if ($b3 != "") {
        $file = $dir . mysql_real_escape_string(htmlspecialchars($_REQUEST['bridge2']));
        $data = readMyFile($file);
        if($handle = fopen($file, 'w')){
			$bridgeTag = "BRIDGE=";
			$fIndex = strpos($data, $bridgeTag) + strlen($bridgeTag);
			$data = substr($data, 0, $fIndex) . "vlan" . mysql_real_escape_string(htmlspecialchars($_REQUEST["interface_name"]));
			fwrite($handle, $data);
			fclose($handle);
		}
    }
    $b4 = mysql_real_escape_string(htmlspecialchars($_REQUEST['bridge4']));
    if ($b4 != "") {
        $file = $dir . mysql_real_escape_string(htmlspecialchars($_REQUEST['bridge2']));
        $data = readMyFile($file);
        if($handle = fopen($file, 'w')){
			$bridgeTag = "BRIDGE=";
			$fIndex = strpos($data, $bridgeTag) + strlen($bridgeTag);
			$data = substr($data, 0, $fIndex) . "vlan" . mysql_real_escape_string(htmlspecialchars($_REQUEST["interface_name"]));
			fwrite($handle, $data);
			fclose($handle);
		}
    }
	
	ClosedDBConnection($cn);
    
    header( 'Location: index.php?FORM=forms/frm/frmInterface.php' ) ;
?>