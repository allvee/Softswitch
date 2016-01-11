/**
 * Created by Mazhar on 3/10/2015. Edited by Talemul, Monir
 * 
 */

function defaultViewController() {

	var cms_auth = checkSession('cms_auth');
	if (cms_auth == null) {
		// login page
		showUserMenu('login');
	} else {
		// login page
		showUserMenu('index');// after log in index
	}
}
function showUserMenu(field_name) {
$('#tab_view').html('');
    message_clear();
    $('#id_loading_image').show();
    /* pages available before logging in */

    if (field_name == 'login') {
        displayContent("1", "#cmsData", "#contentListLayout", "ContentID");
    }

    /* pages available after logged in */

    var cms_auth = checkSession('cms_auth');
    if (cms_auth != null) {
        $('#id_loading_image').hide();
        $("#nav-navbar-collapse-1").removeClass("in");
        if (field_name == 'index') {
            $('#id_loading_image').hide();
            displayContent("2", "#cmsData", "#contentListLayout", "ContentID");
            default_menu();
        } else if (field_name == 'signOut') {
            cmsLogout(site_host);
        }

          /* Pages for IP Assignment */

         else if (field_name == 'ip_assignment_interface_assign_ip') {
            display_content_custom('10', '#modalData');
			var inputarray = [["Configuration", "ip_assignment_interface_assign_ip","active"], ["View","ip_assignment_interface_view","deactive"], ["Maintenance","ip_assignment_interface_maintenance","deactive"]];
            tab_custom(inputarray,"tab_view");
        } else if (field_name == 'ip_assignment_interface_add_suninterface') {
           // display_content_custom('11', '#modalData');
        } else if (field_name == 'ip_assignment_interface_view') {
            display_content_custom("150", "#modalData");
			var inputarray = [["Configuration", "ip_assignment_interface_assign_ip","deactive"], ["View","ip_assignment_interface_view","active"], ["Maintenance","ip_assignment_interface_maintenance","deactive"]];
            tab_custom(inputarray,"tab_view");
			report_interface_list();
        }else if (field_name == 'ip_assignment_interface_maintenance') {
           display_content_custom('1040', '#modalData');
           var inputarray = [["Configuration", "ip_assignment_interface_assign_ip","deactive"], ["View","ip_assignment_interface_view","deactive"], ["Maintenance","ip_assignment_interface_maintenance","active"]];
            tab_custom(inputarray,"tab_view");
        } else if (field_name == 'ip_assignment_bridge_config') {
            display_content_custom("12", "#modalData");
            //load_bridge_options("dynamic_nat_interface");
            fetchDropDownOption("#dynamic_nat_interface", cms_url['ip_assignment_bridge_options'], '');
            var inputarray = [["Configuration", "ip_assignment_bridge_config", "active"], ["View", "ip_assignment_bridge_view", "deactive"], ["Maintenance","ip_assignment_bridge_maintenance","deactive"]];
            tab_custom(inputarray, "tab_view");
        } else if (field_name == 'ip_assignment_bridge_view') {
            display_content_custom("150", "#modalData");
            var inputarray = [["Configuration", "ip_assignment_bridge_config", "deactive"], ["View", "ip_assignment_bridge_view", "active"], ["Maintenance","ip_assignment_bridge_maintenance","deactive"]];
            tab_custom(inputarray, "tab_view");
            table_initialize_ipassignment_bridge();
            report_menu_ipassignment_bridge();
        } else if (field_name == 'ip_assignment_bridge_maintenance) {
            display_content_custom('1040', '#modalData');
            var inputarray = [["Configuration", "ip_assignment_bridge_config", "deactive"], ["View", "ip_assignment_bridge_view", "deactive"], ["Maintenance","ip_assignment_bridge_maintenance","active"]];
            tab_custom(inputarray, "tab_view");
        }


        /* Pages for RT */

        else if (field_name == 'routing_static_config') {
            display_content_custom('21', '#modalData');
            var inputarray = [["Configuration", "routing_static_config", "active"], ["View", "routing_static_view", "deactive"], ["Maintanance", "routing_static_maintanance", "deactive"]];
            tab_custom(inputarray, "tab_view");
        } else if (field_name == 'routing_static_view') {
            display_content_custom('150', '#modalData');
            var inputarray = [["Configuration", "routing_static_config", "deactive"], ["View", "routing_static_view", "active"], ["Maintanance", "routing_static_maintanance", "deactive"]];
            tab_custom(inputarray, "tab_view");
            report_static_router();
        } else if (field_name == 'routing_static_maintanance') {
            display_content_custom('1010', '#modalData');
            var inputarray = [["Configuration", "routing_static_config", "deactive"], ["View", "routing_static_view", "deactive"], ["Maintanance", "routing_static_maintanance", "active"]];
            tab_custom(inputarray, "tab_view");
        } else if (field_name == 'routing_ospf_config') {
            display_content_custom("22", "#modalData");
            var inputarray = [["Configuration", "routing_ospf_config", "active"], ["View", "routing_ospf_view", "deactive"], ["Maintanance", "routing_ospf_maintanance", "deactive"]];
            tab_custom(inputarray, "tab_view");
        } else if (field_name == 'routing_ospf_view') {
            display_content_custom("150", "#modalData");
            var inputarray = [["Configuration", "routing_ospf_config", "deactive"], ["View", "routing_ospf_view", "active"], ["Maintanance", "routing_ospf_maintanance", "deactive"]];
            tab_custom(inputarray, "tab_view");
            report_ospf_router();
        } else if (field_name == 'routing_ospf_maintanance') {
            display_content_custom('1020', '#modalData');
            var inputarray = [["Configuration", "routing_ospf_config", "deactive"], ["View", "routing_ospf_view", "deactive"], ["Maintanance", "routing_ospf_maintanance", "active"]];
            tab_custom(inputarray, "tab_view");
        } else if (field_name == 'routing_rip_config') {
            display_content_custom("23", "#modalData");
            var data = {};
            fetchDropDownOption("#rip_version", cms_url['rcportal_rip_router_version'], data);
            var inputarray = [["Configuration", "routing_rip_config", "active"], ["View", "routing_rip_view", "deactive"], ["Maintanance", "routing_rip_maintanance", "deactive"]];
            tab_custom(inputarray, "tab_view");
        } else if (field_name == 'routing_rip_view') {
            display_content_custom("150", "#modalData");
            var inputarray = [["Configuration", "routing_rip_config", "deactive"], ["View", "routing_rip_view", "active"], ["Maintanance", "routing_rip_maintanance", "deactive"]];
            tab_custom(inputarray, "tab_view");
            report_rip_router();
        } else if (field_name == 'routing_rip_maintanance') {
            display_content_custom('1030', '#modalData');
            var inputarray = [["Configuration", "routing_rip_config", "deactive"], ["View", "routing_rip_view", "deactive"], ["Maintanance", "routing_rip_maintanance", "active"]];
            tab_custom(inputarray, "tab_view");
        } else if (field_name == 'routing_bgp_config') {
            display_content_custom("24", "#modalData");
            show_bgp();
            var inputarray = [["Configuration", "routing_bgp_config", "active"], ["View", "routing_bgp_view", "deactive"], ["Maintanance", "routing_bgp_maintanance", "deactive"]];
            tab_custom(inputarray, "tab_view");
        } else if (field_name == 'routing_bgp_view') {
            display_content_custom("150", "#modalData");
            var inputarray = [["Configuration", "routing_bgp_config", "deactive"], ["View", "routing_bgp_view", "active"], ["Maintanance", "routing_bgp_maintanance", "deactive"]];
            tab_custom(inputarray, "tab_view");
        } else if (field_name == 'routing_bgp_maintanance') {
            display_content_custom('1050', '#modalData');
            var inputarray = [["Configuration", "routing_bgp_config", "deactive"], ["View", "routing_bgp_view", "deactive"], ["Maintanance", "routing_bgp_maintanance", "active"]];
            tab_custom(inputarray, "tab_view");
        } else if (field_name == 'routing_vrrp_config') {
            var inputarray = [["Configuration", "routing_vrrp_config", "active"], ["View", "routing_vrrp_view", "deactive"], ["Maintanance", "routing_vrrp_maintanance", "deactive"]];
            display_content_custom("25", "#modalData");
            tab_custom(inputarray, "tab_view");
            fetchDropDownOption('#interface', cms_url['rcportal_interface_list_show'], '');
            fetchDropDownOption('#choose_track_interface', cms_url['rcportal_interface_list_show'], '');
        } else if (field_name == 'routing_vrrp_view') {
            display_content_custom("150", "#modalData");
            var inputarray = [["Configuration", "routing_vrrp_config", "deactive"], ["View", "routing_vrrp_view", "active"], ["Maintanance", "routing_vrrp_maintanance", "deactive"]];
            tab_custom(inputarray, "tab_view");
            table_initialize_vrrp_routing();
            report_menu_start_vrrp_routing();
        } else if (field_name == 'routing_vrrp_maintanance') {
            display_content_custom('1040', '#modalData');
            var inputarray = [["Configuration", "routing_vrrp_config", "deactive"], ["View", "routing_vrrp_view", "active"], ["Maintanance", "routing_vrrp_maintanance", "deactive"]];
            tab_custom(inputarray, "tab_view");
        } else if (field_name == 'routing_routes_view') {
            display_content_custom("150", "#modalData");
            table_initialize_all_routes();
            report_menu_start_all_routes();
        }



        /* Pages for Firewall */


        else if (field_name == 'firewall_group_add') {
            var inputarray = [["Configuration", "firewall_group_add", "active"], ["View", "firewall_group_view", "deactive"]];
            display_content_custom('31', '#modalData');
	     $('#sync').hide();
            tab_custom(inputarray, "tab_view");
        } else if (field_name == 'firewall_group_view') {
            var inputarray = [["Configuration", "firewall_group_add", "deactive"], ["View", "firewall_group_view", "active"]];
            display_content_custom('150', '#modalData');
            tab_custom(inputarray, "tab_view");
            table_initialize_firewall_group();
            report_menu_start_firewall_group();
        } else if (field_name == 'firewall_rules_add') {
            var inputarray = [["Configuration", "firewall_rules_add", "active"], ["View", "firewall_rules_view", "deactive"]];
            display_content_custom("32", "#modalData");
            tab_custom(inputarray, "tab_view");
            $(function () {
                $('#start_time').datetimepicker({
                    language: 'en',
                    weekStart: 1,
                    todayBtn: 1,
                    autoclose: 1,
                    todayHighlight: 1,
                    startView: 1,
                    minView: 0,
                    maxView: 1,
                    forceParse: 0
                });
            });
            $(function () {
                $('#end_time').datetimepicker({
                    language: 'en',
                    weekStart: 1,
                    todayBtn: 1,
                    autoclose: 1,
                    todayHighlight: 1,
                    startView: 1,
                    minView: 0,
                    maxView: 1,
                    forceParse: 0
                });
            });

        } else if (field_name == 'firewall_rules_view') {
            var inputarray = [["Configuration", "firewall_rules_add", "deactive"], ["View", "firewall_rules_view", "active"]];
            display_content_custom("150", "#modalData");
            tab_custom(inputarray, "tab_view");
            table_initialize_firewall_rule();
            report_menu_start_firewall_rule();
        } else if (field_name == 'firewall_config') {
             display_content_custom('33', '#modalData');

            show_firewall();
        }


         /* Pages for VPN */

        else if (field_name == 'vpn_ipsec_config') {

            var inputarray = [["Configuration", "vpn_ipsec_config","active"], ["View","vpn_ipsec_view","deactive"], ["Maintenance","vpn_ipsec_maintenance","deactive"]];
            display_content_custom("41", "#modalData");
            tab_custom(inputarray, "tab_view");

        } else if (field_name == 'vpn_ipsec_view') {
            display_content_custom("150", "#modalData");
            var inputarray = [["Configuration", "vpn_ipsec_config", "deactive"], ["View", "vpn_ipsec_view", "active"], ["Maintenance","vpn_ipsec_maintenance","deactive"]];
            tab_custom(inputarray, "tab_view");
            table_initialize_vpn_ipsec();
            report_menu_start_vpn_ipsec();

        } else if (field_name == 'vpn_ipsec_maintenance') {
            display_content_custom("1050", "#modalData");
            var inputarray = [["Configuration", "vpn_ipsec_config", "deactive"], ["View", "vpn_ipsec_view", "deactive"], ["Maintenance","vpn_ipsec_maintenance","active"]];
            tab_custom(inputarray, "tab_view");
        } else if (field_name == 'vpn_pptp_config_server') {
            display_content_custom("42", "#modalData");
        } else if (field_name == 'vpn_pptp_config_client') {

            display_content_custom("43", "#modalData");
            var inputarray = [["Configuration", "vpn_pptp_config_client", "active"], ["View", "vpn_pptp_view", "deactive"], ["Maintenance","vpn_pptp_maintenance","deactive"]];
            tab_custom(inputarray, "tab_view");


        } else if (field_name == 'vpn_pptp_view') {

            display_content_custom("150", "#modalData");
            var inputarray = [["Configuration", "vpn_pptp_config_client", "deactive"], ["View", "vpn_pptp_view", "active"], ["Maintenance","vpn_pptp_maintenance","deactive"]];
            tab_custom(inputarray, "tab_view");
            table_initialize_vpn_pptp_server();
            report_menu_start_vpn_pptp_server();

        } else if (field_name == 'vpn_pptp_maintenance') {
            display_content_custom("1050", "#modalData");
            var inputarray = [["Configuration", "vpn_pptp_config_client", "deactive"], ["View", "vpn_pptp_view", "deactive"], ["Maintenance","vpn_pptp_maintenance","active"]];
            tab_custom(inputarray, "tab_view");
        } else if (field_name == 'vpn_gre_config') {

            display_content_custom("44", "#modalData");
            var inputarray = [["Configuration", "vpn_gre_config", "active"], ["View", "vpn_gre_view", "deactive"], ["Maintenance","vpn_gre_maintenance","deactive"]];
            tab_custom(inputarray, "tab_view");
            //tab_div_vpn_gre_config();
        } else if (field_name == 'vpn_gre_view') {


            display_content_custom("150", "#modalData");
            var inputarray = [["Configuration", "vpn_gre_config", "deactive"], ["View", "vpn_gre_view", "active"], ["Maintenance","vpn_gre_maintenance","deactive"]];
            tab_custom(inputarray, "tab_view");
            //tab_div_vpn_gre_view();
            table_initialize_vpn_gre();
            report_menu_start_vpn_gre();
        } else if (field_name == 'vpn_gre_maintenance') {
            display_content_custom("1050", "#modalData");
            var inputarray = [["Configuration", "vpn_gre_config", "deactive"], ["View", "vpn_gre_view", "deactive"], ["Maintenance","vpn_gre_maintenance","active"]];
            tab_custom(inputarray, "tab_view");
        } else if (field_name == 'vpn_l2tp_config_server') {
            display_content_custom("45", "#modalData");

            // var inputarray = [["Config Server", "vpn_l2tp_config_server", "active"], ["Config Client", "vpn_l2tp_config_client", "deactive"], ["View", "vpn_l2tp_view", "deactive"]];
            var inputarray = [["Config Server", "vpn_l2tp_config_server", "active"], ["View", "vpn_l2tp_view", "deactive"], ["Maintenance","vpn_ipsec_view","deactive"]];
            tab_custom(inputarray, "tab_view");

        } else if (field_name == 'vpn_l2tp_config_client') {
            display_content_custom("46", "#modalData");
            // var inputarray = [["Config Server", "vpn_l2tp_config_server", "deactive"], ["Config Client", "vpn_l2tp_config_client", "active"], ["View", "vpn_l2tp_view", "deactive"]];
            var inputarray = [["Config Server", "vpn_l2tp_config_server", "deactive"], ["View", "vpn_l2tp_view", "active"], ["Maintenance","vpn_l2tp_config_maintenance","deactive"]];
            tab_custom(inputarray, "tab_view");
        } else if (field_name == 'vpn_l2tp_view') {


            display_content_custom("150", "#modalData");
            //var inputarray = [["Config Server", "vpn_l2tp_config_server", "deactive"], ["Config Client", "vpn_l2tp_config_client", "deactive"], ["View", "vpn_l2tp_view", "active"]];
            var inputarray = [["Config Server", "vpn_l2tp_config_server", "deactive"], ["View", "vpn_l2tp_view", "active"], ["Maintenance","vpn_l2tp_config_maintenance","deactive"]];
            tab_custom(inputarray, "tab_view");
            table_initialize_vpn_l2tp();
            report_menu_start_vpn_l2tp();
        } else if (field_name == 'vpn_l2tp_config_maintenance') {
            display_content_custom("1050", "#modalData");
            var inputarray = [["Config Server", "vpn_l2tp_config_server", "deactive"], ["View", "vpn_l2tp_view", "deactive"], ["Maintenance","vpn_l2tp_config_maintenance","active"]];
            tab_custom(inputarray, "tab_view");
        }



        /* Pages for NAT */
       else if (field_name == 'nat_static_config') {
            var inputarray = [["Configuration", "nat_static_config", "active"], ["View", "nat_static_view", "deactive"]];
            display_content_custom('51', '#modalData');
            tab_custom(inputarray, "tab_view");
            fetchDropDownOption('#interface', cms_url['rcportal_interface_list_show'], '');
        } else if (field_name == 'nat_static_view') {
            var inputarray = [["Configuration", "nat_static_config", "deactive"], ["View", "nat_static_view", "active"]];
            display_content_custom('150', '#modalData');
            tab_custom(inputarray, "tab_view");
            table_initialize_nat_static();
            report_menu_start_nat_static();
        } else if (field_name == 'nat_dynamic_config') {
            var inputarray = [["Configuration", "nat_dynamic_config", "active"], ["View", "nat_dynamic_view", "deactive"]];
            display_content_custom("52", "#modalData");
            tab_custom(inputarray, "tab_view");
            fetchDropDownOption('#interface', cms_url['rcportal_interface_list_show'], '');
        } else if (field_name == 'nat_dynamic_view') {
            var inputarray = [["Configuration", "nat_dynamic_config", "deactive"], ["View", "nat_dynamic_view", "active"]];
            display_content_custom("150", "#modalData");
            tab_custom(inputarray, "tab_view");
            table_initialize_nat_dynamic();
            report_menu_start_nat_dynamic();
        }

        /* Pages for BWP */

        else if (field_name == 'bwp_config_add') {
            display_content_custom('61', '#modalData');
            //var inputarray = [["Add", "bwp_config_add", "active"], ["View", "bwp_config_view", "deactive"]];
            //tab_custom(inputarray, "tab_view");
            show_bwp();
        } /*else if (field_name == 'bwp_config_view') {
            display_content_custom('150', '#modalData');
            var inputarray = [["Add", "bwp_config_add", "deactive"], ["View", "bwp_config_view", "active"]];
            tab_custom(inputarray, "tab_view");
            show_bwp();
        }*/ else if (field_name == 'bwp_log') {
            display_content_custom('150', '#modalData');

        }

        /* Pages for BWC */

         else if (field_name == 'bwc_group_add') {
            display_content_custom('71', '#modalData');
            fetchDropDownOption('#bwc_lan_interface', cms_url['rcportal_interface_list_show'], '');
            fetchDropDownOption('#bwc_wan_interface', cms_url['rcportal_interface_list_show'], '');
            var inputarray = [["Add", "bwc_group_add", "active"], ["View", "bwc_group_view", "deactive"]];
            tab_custom(inputarray, "tab_view");
        } else if (field_name == 'bwc_group_view') {
            display_content_custom('150', '#modalData');
            var inputarray = [["Add", "bwc_group_add", "deactive"], ["View", "bwc_group_view", "active"]];
            tab_custom(inputarray, "tab_view");
            report_bwc_group();
        } else if (field_name == 'bwc_time_add') {
            display_content_custom("72", "#modalData");
            var inputarray = [["Add", "bwc_time_add", "active"], ["View", "bwc_time_view", "deactive"]];
            tab_custom(inputarray, "tab_view");
        } else if (field_name == 'bwc_time_view') {
            display_content_custom("150", "#modalData");
            var inputarray = [["Add", "bwc_time_add", "deactive"], ["View", "bwc_time_view", "active"]];
            tab_custom(inputarray, "tab_view");
            report_bwc_timepackage();
        } else if (field_name == 'bwc_client_add') {
            display_content_custom("73", "#modalData");
            var inputarray = [["Add", "bwc_client_add", "active"], ["View", "bwc_client_view", "deactive"]];
            tab_custom(inputarray, "tab_view");
        } else if (field_name == 'bwc_client_view') {
            display_content_custom("150", "#modalData");
            var inputarray = [["Add", "bwc_client_add", "deactive"], ["View", "bwc_client_view", "active"]];
            tab_custom(inputarray, "tab_view");
            report_bwc_client();
        }


        /* Pages for Alert Mgt */

        else if (field_name == 'alert_mgt_event_add') {
            display_content_custom('81', '#modalData');
            var inputarray = [["Add", "alert_mgt_event_add", "active"], ["View", "alert_mgt_event_view", "deactive"]];
            tab_custom(inputarray, "tab_view");
        } else if (field_name == 'alert_mgt_event_view') {
            display_content_custom('150', '#modalData');
            var inputarray = [["Add", "alert_mgt_event_add", "deactive"], ["View", "alert_mgt_event_view", "active"]];
            tab_custom(inputarray, "tab_view");
            table_initialize_alert_event();
            report_menu_alert_event();
        } else if (field_name == 'alert_mgt_config_email') {
            display_content_custom('82', '#modalData');
            var inputarray = [["Email", "alert_mgt_config_email", "active"], ["SMS", "alert_mgt_config_sms", "deactive"]];
            tab_custom(inputarray, "tab_view");
            display_alert_email();
        } else if (field_name == 'alert_mgt_config_sms') {
            display_content_custom('83', '#modalData');
            var inputarray = [["Email", "alert_mgt_config_email", "deactive"], ["SMS", "alert_mgt_config_sms", "active"]];
            tab_custom(inputarray, "tab_view");
            display_alert_sms();
        }


        /* Pages for Administration */

        else if (field_name == 'admin_account_add') {
            display_content_custom('91', '#modalData');
        } else if (field_name == 'admin_account_view') {
            display_content_custom('150', '#modalData');
        } else if (field_name == 'admin_role_add') {
            display_content_custom('92', '#modalData');
        } else if (field_name == 'admin_role_view') {
            display_content_custom('150', '#modalData');
        } else if (field_name == 'admin_menu_permission') {
            display_content_custom('93', '#modalData');
        }

        /* Pages for SoftSwitch */

        else if (field_name == 'softswitch_extensions_add') {
            display_content_custom('101', '#modalData');
            var inputarray = [["Add", "softswitch_extensions_add", "active"], ["View", "softswitch_extensions_view", "deactive"]];
            tab_custom(inputarray, "tab_view");
        } else if (field_name == 'softswitch_extensions_view') {
            display_content_custom('150', '#modalData');
            var inputarray = [["Add", "softswitch_extensions_add", "deactive"], ["View", "softswitch_extensions_view", "active"]];
            tab_custom(inputarray, "tab_view");
            table_initialize_dial_plan_info();
            report_menu_start_extensions_info();
        } else if (field_name == 'softswitch_context_add') {
            display_content_custom("102", "#modalData");
            var inputarray = [["Add", "softswitch_context_add", "active"], ["View", "softswitch_context_view", "deactive"]];
            tab_custom(inputarray, "tab_view");
        } else if (field_name == 'softswitch_context_view') {
            display_content_custom("150", "#modalData");
            var inputarray = [["Add", "softswitch_context_add", "deactive"], ["View", "softswitch_context_view", "active"]];
            tab_custom(inputarray, "tab_view");
            table_initialize_context_info();
            report_menu_start_context_info();
        } else if (field_name == 'softswitch_dial_context_add') {
            display_content_custom("103", "#modalData");
            var inputarray = [["Configuration", "softswitch_dial_context_add", "active"], ["View", "softswitch_dial_context_view", "deactive"]];
            tab_custom(inputarray, "tab_view");
        } else if (field_name == 'softswitch_dial_context_view') {
            display_content_custom("150", "#modalData");
            var inputarray = [["Configuration", "softswitch_dial_context_add", "deactive"], ["View", "softswitch_dial_context_view", "active"]];
            tab_custom(inputarray, "tab_view");
            table_initialize_dial_plan_context_info();
            report_menu_start_dial_plan_context_info();
        } else if (field_name == 'softswitch_dial_plan_add') {
            display_content_custom('104', '#modalData');
            var inputarray = [["Add", "softswitch_dial_plan_add", "active"], ["View", "softswitch_dial_plan_view", "deactive"]];
            tab_custom(inputarray, "tab_view");
        } else if (field_name == 'softswitch_dial_plan_view') {
            display_content_custom('150', '#modalData');
            var inputarray = [["Add", "softswitch_dial_plan_add", "deactive"], ["View", "softswitch_dial_plan_view", "active"]];
            tab_custom(inputarray, "tab_view");
            table_initialize_dialplan_info();
            report_menu_start_dialplan_info();
        } else if (field_name == 'softswitch_configuration') {
            display_content_custom("105", "#modalData");
            var inputarray = [["Add", "softswitch_configuration", "active"], ["View", "softswitch_configuration_view", "deactive"]];
            tab_custom(inputarray, "tab_view");
        } else if (field_name == 'softswitch_configuration_view') {
            display_content_custom('150', '#modalData');
            var inputarray = [["Add", "softswitch_configuration", "deactive"], ["View", "softswitch_configuration_view", "active"]];
            tab_custom(inputarray, "tab_view");
            table_initialize_soft_config();
            report_menu_start_soft_config();
        } else if (field_name == 'softswitch_route_add') {
            display_content_custom("106", "#modalData");
            var inputarray = [["Add", "softswitch_route_add", "active"], ["View", "softswitch_route_view", "deactive"]];
            tab_custom(inputarray, "tab_view");
        } else if (field_name == 'softswitch_route_view') {
            display_content_custom("150", "#modalData");
            var inputarray = [["Add", "softswitch_route_add", "deactive"], ["View", "softswitch_route_view", "active"]];
            tab_custom(inputarray, "tab_view");
            table_initialize_route_info();
            report_menu_start_route_info();
        } else if (field_name == 'softswitch_server_add') {
            display_content_custom("107", "#modalData");
            var inputarray = [["Add", "softswitch_server_add", "active"], ["View", "softswitch_server_view", "deactive"]];
            tab_custom(inputarray, "tab_view");
        } else if (field_name == 'softswitch_server_view') {
            display_content_custom('150', '#modalData');
            var inputarray = [["Add", "softswitch_server_add", "deactive"], ["View", "softswitch_server_view", "active"]];
            tab_custom(inputarray, "tab_view");
            table_initialize_server_info();
            report_menu_start_server_info();
        } else if (field_name == 'softswitch_log_add') {
            display_content_custom('108', '#modalData');
        } else if (field_name == 'softswitch_log_log') {
            display_content_custom("109", "#modalData");
        } else if (field_name == 'softswitch_cdr_call') {
            display_content_custom("110", "#modalData");
        } else if (field_name == 'softswitch_cdr_im') {
            display_content_custom("111", "#modalData");
        }  else if (field_name == 'softswitch_client_setting') {
            display_content_custom("112", "#modalData");
            show_softswitch_ippbx_client();
        }

        /* Pages for IVR */

        else if (field_name == 'ivr_ivr_mapping_add') {
            display_content_custom('121', '#modalData');
            var inputarray = [["Add", "ivr_ivr_mapping_add", "active"], ["View", "ivr_ivr_mapping_view", "deactive"]];
            tab_custom(inputarray, "tab_view");
        } else if (field_name == 'ivr_ivr_mapping_view') {
            display_content_custom('150', '#modalData');
            var inputarray = [["Add", "ivr_ivr_mapping_add", "deactive"], ["View", "ivr_ivr_mapping_view", "active"]];
            tab_custom(inputarray, "tab_view");
        } else if (field_name == 'ivr_ivr_tree_add') {
            display_content_custom("122", "#modalData");
            var inputarray = [["Add", "ivr_ivr_tree_add", "active"], ["View", "ivr_ivr_tree_view", "deactive"]];
            tab_custom(inputarray, "tab_view");
        } else if (field_name == 'ivr_ivr_tree_view') {
            display_content_custom("150", "#modalData");
            var inputarray = [["Add", "ivr_ivr_tree_add", "deactive"], ["View", "ivr_ivr_tree_view", "active"]];
            tab_custom(inputarray, "tab_view");
        } else if (field_name == 'ivr_ivr_data') {
            display_content_custom("123", "#modalData");
        }

        /* Pages for SMSGW */

        else if (field_name == 'smsgw_configuration') {
            display_content_custom('131', '#modalData');
        } else if (field_name == 'smsgw_shortcode_add') {
            display_content_custom('132', '#modalData');
            var inputarray = [["Add", "smsgw_shortcode_add", "active"], ["View", "smsgw_shortcode_view", "deactive"]];
            tab_custom(inputarray, "tab_view");
        } else if (field_name == 'smsgw_shortcode_view') {
            display_content_custom("150", "#modalData");
            var inputarray = [["Add", "smsgw_shortcode_add", "deactive"], ["View", "smsgw_shortcode_view", "active"]];
            tab_custom(inputarray, "tab_view");
        } else if (field_name == 'smsgw_keyword_add') {
            display_content_custom("133", "#modalData");
            var inputarray = [["Add", "smsgw_keyword_add", "active"], ["View", "smsgw_keyword_view", "deactive"]];
            tab_custom(inputarray, "tab_view");
        } else if (field_name == 'smsgw_keyword_view') {
            display_content_custom("150", "#modalData");
            var inputarray = [["Add", "smsgw_keyword_add", "deactive"], ["View", "smsgw_keyword_view", "active"]];
            tab_custom(inputarray, "tab_view");
        } else if (field_name == 'smsgw_service_add') {
            display_content_custom("134", "#modalData");
            var inputarray = [["Add", "smsgw_service_add", "active"], ["View", "smsgw_service_view", "deactive"]];
            tab_custom(inputarray, "tab_view");
        } else if (field_name == 'smsgw_service_view') {
            display_content_custom("150", "#modalData");
            var inputarray = [["Add", "smsgw_service_add", "deactive"], ["View", "smsgw_service_view", "active"]];
            tab_custom(inputarray, "tab_view");
        } else if (field_name == 'smsgw_report') {
            display_content_custom("135", "#modalData");
        }


        /* Pages for SMS Blast */

        else if (field_name == 'smsblast_configuration') {
            display_content_custom('141', '#modalData');
        } else if (field_name == 'smsblast_group_add') {

              display_content_custom('142', '#modalData');
		var inputarray = [["Add", "smsblast_group_add","active"], ["View","smsblast_group_view","deactive"]];
              tab_custom(inputarray,"tab_view");

        } else if (field_name == 'smsblast_group_view') {

             display_content_custom("150", "#modalData");
	      var inputarray = [["Add", "smsblast_group_add","deactive"], ["View","smsblast_group_view","active"]];
             tab_custom(inputarray,"tab_view");
	      report_smsblust_group();

        } else if (field_name == 'smsblast_contact_add') {
          
		display_content_custom('141', '#modalData');
		var inputarray = [["Add Contact", "smsblast_contact_add","active"], ["View Contact","smsblast_contact_view","deactive"]];
              tab_custom(inputarray,"tab_view");
		
		fetchDropDownOption("#group",cms_url['smsblust_get_contact_group_list'],'');        
	} else if (field_name == 'smsblast_contact_view') {

             display_content_custom("150", "#modalData");
	      var inputarray = [["Add Contact", "smsblast_contact_add","deactive"], ["View Contact","smsblast_contact_view","active"]];
             tab_custom(inputarray,"tab_view");
	      report_smsblast_group_recipient();
        } else if (field_name == 'smsblast_template_add') {


             display_content_custom("144", "#modalData");
	      var inputarray = [["Add", "smsblast_template_add","active"], ["View","smsblast_template_view","deactive"]];
             tab_custom(inputarray,"tab_view");
        } else if (field_name == 'smsblast_template_view') {

             display_content_custom("150", "#modalData");
	      var inputarray = [["Add", "smsblast_template_add","deactive"], ["View","smsblast_template_view","active"]];
             tab_custom(inputarray,"tab_view");
	      report_sms_template();
        }  else if (field_name == 'smsblast_blast_singlesms') {
            display_content_custom("145", "#modalData");
            var inputarray = [["Single SMS", "smsblast_blast_singlesms", "active"],["Bulk SMS", "smsblast_blast_bulksms", "deactive"]];
            tab_custom(inputarray, "tab_view");
            fetchDropDownOption("#time_slot", cms_url['smsblust_get_time_slot'], '');

        } else if (field_name == 'smsblast_blast_bulksms') {

            display_content_custom("146", "#modalData");
            var inputarray = [["Single SMS", "smsblast_blast_singlesms", "deactive"],["Bulk SMS", "smsblast_blast_bulksms", "active"]];
            tab_custom(inputarray, "tab_view");
            fetchDropDownOption("#group", cms_url['smsblust_get_contact_group_list'], '');
            fetchDropDownOption("#time_slot", cms_url['smsblust_get_time_slot'], '');
            fetchDropDownOption("#load_template", cms_url['smsblust_get_sms_template'], '');
        } else if (field_name == 'smsblast_report') {
            //display_content_custom("147", "#modalData");
 		   display_content_custom("150", "#modalData");
		   sms_blast_report();
        }else if ( field_name == 'smsblast_timeslot' ) {
           // display_content_custom("147", "#modalData");
		   display_content_custom("1563", "#modalData");
		   var inputarray = [["Configuration", "smsblast_timeslot","active"], ["View","smsblast_timeslot_view","deactive"]];
           tab_custom(inputarray,"tab_view");
		   console.log("DLLLDK");	
			
		  // sms_blast_report();
        }else if ( field_name == 'smsblast_timeslot_view' ) {
           // display_content_custom("147", "#modalData");
		   display_content_custom("150", "#modalData");
		    var inputarray = [["Configuration", "smsblast_timeslot","deactive"], ["View","smsblast_timeslot_view","active"]];
            tab_custom(inputarray,"tab_view");
			report_smsblast_time_slot();
		  // sms_blast_report();
        }else if( field_name == 'smsblast_account_management' ){
		
		   display_content_custom("1564", "#modalData");
		   var inputarray = [["Configuration", "smsblast_account_management","active"], ["View","smsblast_account_management_view","deactive"]];
           tab_custom(inputarray,"tab_view");
		}else if( field_name =='smsblast_account_management_view'){
			display_content_custom("150", "#modalData");
		    var inputarray = [["Configuration", "smsblast_account_management","deactive"], ["View","smsblast_account_management_view","active"]];
            tab_custom(inputarray,"tab_view");
			report_smsblast_account();
		}else if( field_name == 'smsblast_credit_transfer' ){
		
		   display_content_custom("1565", "#modalData");
		   var inputarray = [["Configuration", "smsblast_credit_transfer","active"]];
           tab_custom(inputarray,"tab_view");
		   fetchDropDownOption("#account_name",cms_url['rcportal_smsblast_get_accounts'],'');
		   
		}else if( field_name == 'smsblast_bulksms_permission' ){
			display_content_custom("150", "#modalData");
		       var inputarray = [["BulkSMS","smsblast_bulksms_permission","active"]];
                     tab_custom(inputarray,"tab_view");
			report_smsblast_bulksms_permission();
		}

        /* Pages for OBD */

        else if (field_name == 'obd_dashboard') {
            display_content_custom('151', '#modalData');
            dashboard_dropdown_initialize();
        } else if (field_name == 'obd_prompt_upload') {
            display_content_custom('152', '#modalData');
            var inputarray = [["Upload", "obd_prompt_upload", "active"], ["View", "obd_prompt_view", "deactive"]];
            tab_custom(inputarray, "tab_view");
            createDropDown("timeslot_id",'rcportal/webservices/obd/getTimeslotList',null, '--Search--',' ');
            createDropDown("server_id", "rcportal/webservices/obd/getOBDServerInstances", null, "--Select--", "");
            createDropDown("white_list", "rcportal/webservices/obd/get_white_list", null, "--Select--", "");
            upload_prompt_dropdown_initialize();
        } else if (field_name == 'obd_prompt_view') {
            display_content_custom("150", "#modalData");
            var inputarray = [["Upload", "obd_prompt_upload", "deactive"], ["View", "obd_prompt_view", "active"]];
            tab_custom(inputarray, "tab_view");
        } else if (field_name == 'obd_dnd_upload') {
            display_content_custom("153", "#modalData");
            var inputarray = [["Upload", "obd_dnd_upload", "active"], ["View", "obd_dnd_view", "deactive"]];
            tab_custom(inputarray, "tab_view");
        } else if (field_name == 'obd_dnd_view') {
            display_content_custom("150", "#modalData");
            var inputarray = [["Upload", "obd_dnd_upload", "deactive"], ["View", "obd_dnd_view", "active"]];
            tab_custom(inputarray, "tab_view");
            table_initialize_obd_dnd();
            report_menu_start_obd_dnd();
        } else if (field_name == 'obd_white_upload') {
            display_content_custom("154", "#modalData");
            var inputarray = [["Upload", "obd_white_upload", "active"], ["View", "obd_white_view", "deactive"]];
            tab_custom(inputarray, "tab_view");
        } else if (field_name == 'obd_white_view') {
            display_content_custom("150", "#modalData");
            var inputarray = [["Upload", "obd_white_upload", "deactive"], ["View", "obd_white_view", "active"]];
            tab_custom(inputarray, "tab_view");
            table_initialize_obd_white();
            report_menu_start_obd_white();
        } else if (field_name == 'obd_execution') {
            display_content_custom("155", "#modalData");
            table_initialize_obd_execution();
            report_menu_start_obd_execution();
        }

        /* Pages for Diagnosis */

        else if (field_name == 'diagnosis_firewall') {
            display_content_custom('161', '#modalData');
        } else if (field_name == 'diagnosis_utility') {
            display_content_custom('162', '#modalData');
	     var inputarray = [["Utility Manager", "diagnosis_utility","active"]];
            tab_custom(inputarray,"tab_view");
	     fetchDropDownOption("#blink_interface",cms_url['rcportal_um_get_interface'],'');
	     fetchDropDownOption("#source_interface",cms_url['rcportal_um_get_interface'],'');
        } else if (field_name == 'diagnosis_dump_screen') {
            display_content_custom("163", "#modalData");
        } else if (field_name == 'diagnosis_dump_file') {
                display_content_custom("164", "#modalData");
            }

        
      /* Pages for DHCP */

        else if (field_name == 'dhcp_subnet') {
            display_content_custom('171', '#modalData');
            var inputarray = [["Configuration", "dhcp_subnet", "active"], ["View", "dhcp_subnet_view", "deactive"]];
            tab_custom(inputarray, "tab_view");
            fetchDropDownOption('#interface_name', cms_url['rcportal_interface_list_show'], '');
        } else if (field_name == 'dhcp_subnet_view') {
            display_content_custom('150', '#modalData');
            var inputarray = [["Configuration", "dhcp_subnet", "deactive"], ["View", "dhcp_subnet_view", "active"]];
            tab_custom(inputarray, "tab_view");
            table_initialize_dhcp_subnet();
            report_menu_start_dhcp_subnet();
        } else if (field_name == 'dhcp_range') {
            display_content_custom("172", "#modalData");
            var inputarray = [["Configuration", "dhcp_range", "active"], ["View", "dhcp_range_view", "deactive"]];
            tab_custom(inputarray, "tab_view");
            fetchDropDownOption('#subnet', cms_url['drop_down_dhcp_subnet'], '');
        } else if (field_name == 'dhcp_range_view') {
            display_content_custom("150", "#modalData");
            var inputarray = [["Configuration", "dhcp_range", "deactive"], ["View", "dhcp_range_view", "active"]];
            tab_custom(inputarray, "tab_view");
            table_initialize_dhcp_range();
            report_menu_start_dhcp_range();
        } else if (field_name == 'dhcp_host') {
            display_content_custom('173', '#modalData');
            var inputarray = [["Configuration", "dhcp_host", "active"], ["View", "dhcp_host_view", "deactive"]];
            tab_custom(inputarray, "tab_view");
            fetchDropDownOption('#subnet', cms_url['drop_down_dhcp_subnet'], '');
        } else if (field_name == 'dhcp_host_view') {
            display_content_custom('150', '#modalData');
            var inputarray = [["Configuration", "dhcp_host", "deactive"], ["View", "dhcp_host_view", "active"]];
            tab_custom(inputarray, "tab_view");
            table_initialize_dhcp_host();
            report_menu_start_dhcp_host();
        } else if (field_name == 'dhcp_lease') {
            display_content_custom("174", "#modalData");
            var inputarray = [["Configuration", "dhcp_lease", "active"], ["View", "dhcp_lease_view", "deactive"]];
            tab_custom(inputarray, "tab_view");
        } else if (field_name == 'dhcp_lease_view') {
                display_content_custom("150", "#modalData");
                var inputarray = [["Configuration", "dhcp_lease", "deactive"], ["View", "dhcp_lease_view", "active"]];
                tab_custom(inputarray, "tab_view");
                table_initialize_dhcp_lease();
                report_menu_start_dhcp_lease();
        }

	/* Pages for Audit Trial */
	 else if (field_name == 'audit') {
            	display_content_custom("165", "#modalData");
		var inputarray = [["History", "audit", "active"], ["Compare", "compair", "deactive"]];
            	tab_custom(inputarray, "tab_view");
		report_menu_start_audit_history();
        }
	 else if (field_name == 'compair') {
		display_content_custom("166", "#modalData");
		var inputarray = [["History", "audit", "deactive"], ["Compare", "compair", "active"]];
            	tab_custom(inputarray, "tab_view");
		report_menu_start_audit_compare();
        }



		// dropdown_chosen_style();

		setTimeout(function() {
			showDashboardInfo();
                     //loadGraph();
		}, 1000);
		setTimeout(function() {
			dropdown_chosen_style()
		}, 1500);

		//setTimeout(function() {


		// highcharts_custom('#container11', 'column','URL');
            //highcharts_custom('#container21', 'spline','URL');
            //highcharts_custom('#container31', 'pie','URL');
	}

	$('#id_loading_image').hide();

	// if ($("#nav-navbar-collapse-1").hasClass("in")) {
	// $("#nav-navbar-collapse-1").removeClass("in").addClass("collapse");
	// }
}

function loadGraph() {

	var bwDataPoints = {};

	$.each($("input[name='interface']"), function() {
		var ival = $(this).val();
		bwDataPoints[ival] = [];
	});

	bwChartOptions = {
		zoomEnabled : true,
		title : {
			text : "BW Consumption"
		},
		toolTip : {
			shared : true
		},
		legend : {
			verticalAlign : "top",
			horizontalAlign : "center",
			fontSize : 14,
			fontWeight : "bold",
			fontFamily : "calibri",
			fontColor : "dimGrey"
		},

		axisY : {
			sufix : 'KB',
			includeZero : false
		},
		data : [],
		legend : {
			cursor : "pointer",
			itemclick : function(e) {
				if (typeof (e.dataSeries.visible) === "undefined"
						|| e.dataSeries.visible) {
					e.dataSeries.visible = false;
				} else {
					e.dataSeries.visible = true;
				}
				bwchart.render();
			}
		}
	};

	var bwchart = new CanvasJS.Chart("bwconsumption", bwChartOptions);
	bwchart.render();
	setInterval(function() {
		updateConsumptionChart()
	}, 1000);

	var updateConsumptionChart = function(count) {

		count = count || 1;
		// count is number of times loop runs to generate random
		// dataPoints.
		for ( var i = 0; i < count; i++) {
			$.each( bwchart.options.data,
					function(index, data) {

								$.ajax({url : "/canvas_charts/services/bw_consumption.php?interface="
															+ data.name,
										async : false,
										dataType : "json"
										}).done(
												function(point) {
													bwchart.options.data[index].dataPoints
															.push(point);

													bwchart.options.data[index].legendText = data.name
															+ " "
															+ point.y
															+ " KB";

												});
								if (bwchart.options.data[index].dataPoints.length > 10) {
									bwchart.options.data[index].dataPoints
											.shift();
								}
							});
		}
		;
		bwchart.render();

	};
	$("input[name=interface]").click(function() {
		var data = [];
		var bwDataPoints = {};

		$.each($("input[name='interface']:checked"), function() {
			var ival = $(this).val();
			bwDataPoints[ival] = [];

			data.push({
				type : "line",
				xValueType : "dateTime",
				showInLegend : true,
				name : ival,
				dataPoints : bwDataPoints[ival]
			});
		});

		bwchart.options.data = data;
		bwchart.render();

	});

	$("input[name=interface]:first").click();
	// Top 10 Users

	topUserOptions = {
		title : {
			text : "Top 10 User Last hour"
		},
		axisY : {
			sufix : 'MB',
			includeZero : false
		},
		data : [ {

			dataPoints : []
		} ]

	};

	var topUserChart = new CanvasJS.Chart("uusage", topUserOptions);
	topUserChart.render();

	var updateUsersChart = function() {

		$.ajax({
			url : "/canvas_charts/services/user.php",
			async : false,
			dataType : "json"
		}).done(function(users) {
			topUserChart.options.data[0].dataPoints = users;

		});

		topUserChart.render();

	};

	updateUsersChart(); // load first time

	setInterval(function() {
		updateUsersChart()
	}, 1000 * 60);

	// resource Monitor

	Resource = {
		title : {
			text : "Resource Monitor"
		},
		theme : "theme1",
		axisY : {
			title : "Percent Sales",
			suffix : "%",
			includeZero : true
		},
		toolTip : {
			content : "{label} <br/> {name}: {y}  (#percent%)"
		},
		data : [

		]

	};

	var ResourceChart = new CanvasJS.Chart("process_utilize", Resource);
	ResourceChart.render();

	var updateResourceChart = function() {

		$.ajax({
			url : "/canvas_charts/services/resource.php",
			async : false,
			dataType : "json"
		}).done(function(usages) {
			ResourceChart.options.data = usages;
		});
		ResourceChart.render();

	};

	updateResourceChart(); // load first time

	setInterval(function() {
		updateResourceChart()
	}, 1000 * 2);

}
