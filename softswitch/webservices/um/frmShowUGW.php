 <head>
	<link rel="stylesheet" type="text/css" href="../../css/showUGW.css">
     <script src="../../../WebFramework/HTML5/jqry/jquery-1.10.2.min.js"></script>
	<!--  <script src="../../../rcportal/js/config.js"></script> -->
</head>
<body>
<div class="center">
    <table cellpadding="3" width="900" border="0">
        <tbody>
            <tr class="h">
                <td>
                	<a href="#"">
					<img border="0" alt="UGW Logo" src="../../images/logo.png">
                  	</a>
                <h1 class="p">Unified Gateway Version 2.0</h1>
                </td>
            </tr>
        </tbody>
    </table>
    <br />
	<h1 class="menu">General Settings</h1>
    <h3>Host</h3> 
    <table cellpadding="3" width="900" border="0">
        <tbody id="table_host">
        </tbody>
    </table>
    <br />
    <h3>DNS Server</h3> 
    <table cellpadding="3" width="900" border="0">
        <tbody id="table_dns_server">
        </tbody>
    </table>
   	<br />
    <h1 class="menu">Network Settings</h1>
    <h3>DHCP Subnet</h3> 
    <table cellpadding="3" width="900" border="0">
        <tbody id="table_dhcp_subnet">
        </tbody>
    </table>
    <br />
    <h3>DHCP Range</h3> 
    <table cellpadding="3" width="900" border="0">
        <tbody id="table_dhcp_range">
        </tbody>
    </table>
    <h3>DHCP Host</h3> 
    <table cellpadding="3" width="900" border="0">
        <tbody id="table_dhcp_host">
        </tbody>
    </table>
    <br />
    <h1 class="menu">Bandwidth Manager</h1>
    <h3>Group</h3> 
    <table cellpadding="3" width="900" border="0">
        <tbody id="table_bwm_group">
        </tbody>
    </table>
    <br />
    <h3>Client</h3> 
    <table cellpadding="3" width="900" border="0">
        <tbody id="table_bwm_client">
        </tbody>
    </table>
    <h3>Default</h3> 
    <table cellpadding="3" width="900" border="0">
        <tbody id="table_bwm_default">
        </tbody>
    </table>
    <br />
    <h1 class="menu">Security</h1>
    <h3>ACL Group</h3> 
    <table cellpadding="3" width="900" border="0">
        <tbody id="table_acl_group">
        </tbody>
    </table>
    <br />
    <h3>ACL IP Address</h3> 
    <table cellpadding="3" width="900" border="0">
        <tbody id="table_acl_ip">
        </tbody>
    </table>
    <h3>Firewall</h3> 
    <table cellpadding="3" width="900" border="0">
        <tbody id="table_firewall">
        </tbody>
    </table>
    <h3>Static NAT</h3> 
    <table cellpadding="3" width="900" border="0">
        <tbody id="table_static_nat">
        </tbody>
    </table>
    <h3>Dynamic NAT</h3> 
    <table cellpadding="3" width="900" border="0">
        <tbody id="table_dynamic_nat">
        </tbody>
    </table>
    <h3>Web Gateway ACL</h3> 
    <table cellpadding="3" width="900" border="0">
        <tbody id="table_wg_acl">
        </tbody>
    </table>
    <br />
    <h3>Web Gateway Restriction</h3> 
    <table cellpadding="3" width="900" border="0">
        <tbody id="table_wg_restriction">
        </tbody>
    </table>
    <h3>VPN IPSec</h3> 
    <table cellpadding="3" width="900" border="0">
        <tbody id="table_vpn_ipsec">
        </tbody>
    </table>
    <h3>VPN PPTPServer</h3> 
    <table cellpadding="3" width="900" border="0">
        <tbody id="table_vpn_pptp_server">
        </tbody>
    </table>
    <br />
    <h3>VPN PPTPClient</h3> 
    <table cellpadding="3" width="900" border="0">
        <tbody id="table_vpn_pptp_client">
        </tbody>
    </table>
    <br />
    <h1 class="menu">IP PBX</h1>
    <h3>Extensions</h3> 
    <table cellpadding="3" width="900" border="0">
        <tbody id="table_ippbx_extensions">
        </tbody>
    </table>
    <br />
    <h3>Gateway</h3> 
    <table cellpadding="3" width="900" border="0">
        <tbody id="table_ippbx_gateway">
        </tbody>
    </table>
    <h3>Dial Plan</h3> 
    <table cellpadding="3" width="900" border="0">
        <tbody id="table_ippbx_dialplan">
        </tbody>
    </table>
    <br />
    <h1 class="menu">User Administration</h1>
    <h3>Account Manager</h3> 
    <table cellpadding="3" width="900" border="0">
        <tbody id="table_account_manager">
        </tbody>
    </table>
    <br />
    <h3>Role Manager</h3> 
    <table cellpadding="3" width="900" border="0">
        <tbody id="table_role_manager">
        </tbody>
    </table>   

</div>
</body>

<script>
	function show_host(){
		var data = "";
		var cols = ["host_name","IP"];
		data = "tbl_name=tbl_hosts"+"&col_no=2"+"&cols="+cols+"&is_active=0";
		var html_data="";
		$.post("show_data.php",data,function(response){
			$("#table_host").html(response);
		});
		}
	function show_dns_server(){
		var data = "";
		var cols = ["host_name","server1","server2"];
		data = "tbl_name=tbl_dns_servers"+"&col_no=3"+"&cols="+cols+"&is_active=0";
		var html_data="";
		$.post("show_data.php",data,function(response){
			$("#table_dns_server").html(response);
		});
		}
		
	function show_dhcp_subnet(){
		var data = "";
		var cols = ["subnet","net_mask","gateway","domain_name","domain_name_server1","domain_name_server2","netbios_name_server","default_lease_time","max_lease_time"];
		data = "tbl_name=tbl_dhcp"+"&col_no=9"+"&cols="+cols+"&is_active=1";
		var html_data="";
		$.post("show_data.php",data,function(response){
			$("#table_dhcp_subnet").html(response);
		});
		}
		
	function show_dhcp_range(){
		var data = "";
		var cols = ["range_start","range_end"];
		data = "tbl_name=tbl_dhcp_range"+"&col_no=2"+"&cols="+cols+"&is_active=1";
		var html_data="";
		$.post("show_data.php",data,function(response){
			$("#table_dhcp_range").html(response);
		});
		}		
	function show_dhcp_host(){
		var data = "";
		var cols = ["host_name","hd_ethernet","fixed_address"];
		data = "tbl_name=tbl_dhcp_host"+"&col_no=3"+"&cols="+cols+"&is_active=1";
		var html_data="";
		$.post("show_data.php",data,function(response){
			$("#table_dhcp_host").html(response);
		});
		}	
		
	function show_bwm_group(){
		var data = "";
		var cols = ["group_name","bandwidth","bw_limit","mode","laninterface","waninterface"];
		data = "tbl_name=tbl_bwm_group"+"&col_no=6"+"&cols="+cols+"&is_active=1";
		var html_data="";
		$.post("show_data.php",data,function(response){
			$("#table_bwm_group").html(response);
		});
		}			
	function show_bwm_client(){
		var data = "";
		var cols = ["client_name","download","upload","min_download","min_upload","c_priority","mac","status"];
		data = "tbl_name=tbl_bwm_client"+"&col_no=8"+"&cols="+cols+"&is_active=1";
		var html_data="";
		$.post("show_data.php",data,function(response){
			$("#table_bwm_client").html(response);
		});
		}
		
	function show_bwm_default(){
		var data = "";
		var cols = ["id","default_limit"];
		data = "tbl_name=tbl_bwm_default_limit"+"&col_no=2"+"&cols="+cols+"&is_active=0";
		var html_data="";
		$.post("show_data.php",data,function(response){
			$("#table_bwm_default").html(response);
		});
		}
	function show_acl_group(){
		var data = "";
		var cols = ["group_name","action"];
		data = "tbl_name=tbl_acl_group"+"&col_no=2"+"&cols="+cols+"&is_active=1";
		var html_data="";
		$.post("show_data.php",data,function(response){
			$("#table_acl_group").html(response);
		});
		}
	function show_acl_ip(){
		var data = "";
		var cols = ["type","ip_address"];
		data = "tbl_name=tbl_acl_group_ip"+"&col_no=2"+"&cols="+cols+"&is_active=1";
		var html_data="";
		$.post("show_data.php",data,function(response){
			$("#table_acl_ip").html(response);
		});
		}		
		
	function show_firewall(){
		var data = "";
		var cols = ["firewall_name","source","destination","incoming_interface","outgoing_interface","network_protocol","destination_port","target"];
		data = "tbl_name=tbl_firewall"+"&col_no=8"+"&cols="+cols+"&is_active=0";
		var html_data="";
		$.post("show_data.php",data,function(response){
			$("#table_firewall").html(response);
		});
		}		
	function show_static_nat(){
		var data = "";
		var cols = ["name","direction","interface","destination_ip","destination_port","forward_ip","forward_port","network_protocol"];
		data = "tbl_name=tbl_nat_static"+"&col_no=8"+"&cols="+cols+"&is_active=1";
		var html_data="";
		$.post("show_data.php",data,function(response){
			$("#table_static_nat").html(response);
		});
		}	
		
	function show_dynamic_nat(){
		var data = "";
		var cols = ["name","direction","interface","source_ip","exclude_src_ip","destination_ip","exclude_dest_ip"];
		data = "tbl_name=tbl_nat_dynamic"+"&col_no=7"+"&cols="+cols+"&is_active=1";
		var html_data="";
		$.post("show_data.php",data,function(response){
			$("#table_dynamic_nat").html(response);
		});
		}
	function show_wg_acl(){
		var data = "";
		var cols = ["acl_name","acl_type","acl_content"];
		data = "tbl_name=tbl_proxy"+"&col_no=3"+"&cols="+cols+"&is_active=1";
		var html_data="";
		$.post("show_data.php",data,function(response){
			$("#table_wg_acl").html(response);
		});
		}		
		
	function show_wg_restriction(){
		var data = "";
		var cols = ["name","acl_in","acl_not_in","restriction"];
		data = "tbl_name=tbl_proxy_acl_restriction"+"&col_no=4"+"&cols="+cols+"&is_active=1";
		var html_data="";
		$.post("show_data.php",data,function(response){
			$("#table_wg_restriction").html(response);
		});
		}	
		
	function show_vpn_ipsec(){
		var data = "";
		var cols = ["ipsec_name","left_v","leftsubnet","right_v","rightsubnet","esp","pfs","ikelifetime","keylife","psk"];
		data = "tbl_name=tbl_vpn_ipsec"+"&col_no=10"+"&cols="+cols+"&is_active=1";
		var html_data="";
		$.post("show_data.php",data,function(response){
			$("#table_vpn_ipsec").html(response);
		});
		}		
		
	function show_vpn_pptp_server(){
		var data = "";
		var cols = ["local_ip","remote_ip"];
		data = "tbl_name=tbl_pptp_server"+"&col_no=2"+"&cols="+cols+"&is_active=1";
		var html_data="";
		$.post("show_data.php",data,function(response){
			$("#table_vpn_pptp_server").html(response);
		});
		}										
				
	function show_vpn_pptp_client(){
		var data = "";
		var cols = ["user_name","password","ip"];
		data = "tbl_name=tbl_vpn_pptp_client"+"&col_no=3"+"&cols="+cols+"&is_active=1";
		var html_data="";
		$.post("show_data.php",data,function(response){
			$("#table_vpn_pptp_client").html(response);
		});
		}
		
	function show_ippbx_extensions(){
		var data = "";
		var cols = ["e_name","e_number","e_secret","e_nat","e_context"];
		data = "tbl_name=tbl_ippbx_extensions"+"&col_no=5"+"&cols="+cols+"&is_active=1";
		var html_data="";
		$.post("show_data.php",data,function(response){
			$("#table_ippbx_extensions").html(response);
		});
		}
	function show_ippbx_gateway(){
		var data = "";
		var cols = ["gw_name","gw_ip","gw_port","gw_direction","gw_nat","gw_context"];
		data = "tbl_name=tbl_ippbx_gw"+"&col_no=6"+"&cols="+cols+"&is_active=1";
		var html_data="";
		$.post("show_data.php",data,function(response){
			$("#table_ippbx_gateway").html(response);
		});
		}
	function show_ippbx_dialplan(){
		var data = "";
		var cols = ["dp_name","prefix","gw_name","dp_context","type"];
		data = "tbl_name=tbl_ippbx_dialplan"+"&col_no=5"+"&cols="+cols+"&is_active=1";
		var html_data="";
		$.post("show_data.php",data,function(response){
			$("#table_ippbx_dialplan").html(response);
		});
		}	
		
	function show_account_manager(){
		var data = "";
		var cols = ["UserID","UserName","UserType","email"];
		data = "tbl_name=tbl_user"+"&col_no=4"+"&cols="+cols+"&is_active=0";
		var html_data="";
		$.post("show_data.php",data,function(response){
			$("#table_account_manager").html(response);
		});
		}		
		
	function show_role_manager(){
		var data = "";
		var cols = ["id","rolename"];
		data = "tbl_name=tbl_roles"+"&col_no=2"+"&cols="+cols+"&is_active=1";
		var html_data="";
		$.post("show_data.php",data,function(response){
			$("#table_role_manager").html(response);
		});
		}													
	$(document).ready(function(){
		show_host();
		show_dns_server();
		show_dhcp_subnet();
		show_dhcp_range();
		show_dhcp_host();
		show_bwm_group();
		show_bwm_client();
		show_bwm_default();
		show_acl_group();
		show_acl_ip();
		show_firewall();
		show_static_nat();
		show_dynamic_nat();
		show_wg_acl();
		show_wg_restriction();
		show_vpn_ipsec();
		show_vpn_pptp_server();
		show_vpn_pptp_client();
		show_ippbx_extensions();
		show_ippbx_gateway();
		show_ippbx_dialplan();
		show_account_manager();
		show_role_manager();
	});
</script>