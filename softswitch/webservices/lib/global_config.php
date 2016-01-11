<?php
/**
 * Created by PhpStorm.
 * User: Talemul
 * Date: 5/5/2015
 * Time: 2:05 PM
 */


 /*
  * for check session just call
  * checkSession();
  *
  * */
$TBL_USER='tbl_user'; //SQL Server [User]
$TBL_ROLE = 'roleinfo'; // role table


// HOSTING
//$host_drive = "http://".$_SERVER['HTTP_HOST']."/rcportal/";
$CURRENT_FILE_HOSTING_PATH = "/var/www/html/ocmportal/";

// Upgrade Source & Destination File Directory
//$UPGRADE_VERSION_SEARCH_URL = "http://ssd-tech.com/unifiedgw/ugw/check_upgraded_version.php";
//$UPGRADE_SOURCE_FILE_PATH = "http://ssd-tech.com/unifiedgw/ugw/download/";
//$UPGRADE_DESTINATION_FILE_PATH = "/home/download_files/rcportal.zip";

// UGW RollBack Default VERSION BACKUP Directory
//$LATEST_FILES_BACKUP_PATH = "/home/ROLLBACK_VERSION/";
//$DEFAULT_SOURCE_FILES = "/home/UGW_BACKUP/";
//$SHELL_FILE_URL = $CURRENT_FILE_HOSTING_PATH."ssh/file_write.sh";

// Log File
//$LOG_FILE = "/home/LOG/ugw.log";
$LOG_TYPE = "FILE";  // FOR file writing >> "FILE", FOR Database >> "DB"
$LOG_HOLDER = "/home/LOG/";  // FOR file writing >> FILE_DIR_PATH, FOR Database >> Table_Name (or, DB_NAME.TABLE_NAME)



$dir = "/etc/sysconfig/network-scripts/";
$dir_dhcp = "/etc/dhcpd.conf";
$dir_dhcp_lease = "/var/lib/dhcpd/dhcpd.leases";
$dir_dhcp_interface = "/etc/sysconfig/dhcpd";
$dir_firewall = "/etc/sysconfig/iptables";
$dir_hosts = "/etc/hosts";
$dir_dns_servers = "/etc/resolv.conf";
$dir_bwm = "/var/www/html/bw/xml/";
$dir_network_host = "/etc/sysconfig/network";
$dir_proxy = "/etc/squid/squid.conf";
$dir_proxy_browsing_history = "/var/log/squid/access.log";
$dir_vpn_ipsec = "/etc/ipsec.d/ugw.conf";
$dir_vpn_ipsec_secret = "/etc/ipsec.d/ugw.secrets";
$dir_vpn_pptp_server = "/etc/pptpd.conf";
$dir_vpn_pptp_client = "/etc/ppp/chap-secrets";
$dir_ippbx_extension = "/etc/asterisk/extensions_additional.conf";
$dir_ippbx_sip = "/etc/asterisk/sip_additional.conf";
$p_of_static_routing = "/etc/quagga/zebra.conf";
$zebra_shell_path = "/var/tmp/zebra.sh";
$p_of_dynamic_rip_routing = "/etc/quagga/ripd.conf";
$rip_shell_path = "/var/tmp/rip.sh";
$p_of_dynamic_ospf_routing = "/etc/quagga/ospfd.conf";
$ospf_shell_path = "/var/tmp/ospf.sh";
$dir_bgp = "/etc/quagga/bgpd.conf";
$stop_bgp_path = "/var/tmp/stop_bgp.sh";
$bgp_current_config_path ="/var/tmp/bgp.txt";
$running_bgp_path = "/var/tmp/bgp.sh";
$dir_vrrp = "/etc/keepalived/keepalived.conf";
$dir_vpn_xl2tp = "/etc/xl2tpd/xl2tpd.conf";
$dir_vpn_ms_dns = "/etc/ppp/options.xl2tpd";
$dir_vpn_xl2tp_client = "/etc/ppp/chap-secrets";
$dir_firewall_group = "/ocmp/test/bwp/firewallRules/";
$remove_lease = ">/var/lib/dhcpd/dhcpd.leases";
$tcp_dump_path = "/var/tmp/tcpdump/";
$pageTitle = "Onubha Gateway";
$page_title_value = "";
$hostPath = "http://". $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$dir_bwp="/bwp/"; 
$dir_firewall_config="/firewall/"; 
$path_of_smsgw_configuration = "/var/www/html/ocmportal_new/rcportal/webservices/smsgw/smsgw.ini";

/***
 * configuration file location 
 */

// Call Handler

$dir_call_handler_test = "/ocmp/test/callhandler/";
$dir_call_handler_production = "/ocmp/production/callhandler/";

// Signaling Gateway

$dir_sgw_test = "/ocmp/test/sgw/";
$dir_sgw_production = "/ocmp/production/sgw/";

// BWP

$dir_bwp_test = "/ocmp/test/bwp/";
$dir_bwp_production = "/ocmp/production/bwp/";

// Firewall

$dir_firewall_test = "/ocmp/test/fw/";
$dir_firewall_production = "/ocmp/production/fw/";

//softswitch Maintenance
$dir_softswitch_stop = "sudo /Softswitch1/Softswitch/stop.sh";
$dir_softswitch_start = "sudo -u root /Softswitch1/Softswitch/start.sh 2>&1";
$dir_softswitch_restart="sudo -u root /Softswitch1/Softswitch/restart.sh";

//$dir_softswitch_ippbx_config = "/var/www/html/softswitch/softswitch/webservices/softswitch/";
$dir_softswitch_ippbx_config="/Softswitch1/Softswitch/";