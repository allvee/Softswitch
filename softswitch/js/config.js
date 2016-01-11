/*
 *Host site name
 */
var site_host = window.location.href;
var site_host_temp = site_host.split('/');

var site_host = "";
for (var i = 0; i < (site_host_temp.length - 1); i++) {
    site_host = site_host + site_host_temp[i] + "/";
}

var layoutId = 1;
/*  ================ for file edit in linux machine ===================================*/
//var cms_url['cms_host']='http://192.168.244.201/ocmportal/rcportal/webservices/';
//

//var host = site_host; // change with your site name

//cms configuration
cms_service_url = new Array();

cms_service_url['cms_service_host'] = site_host + 'WebFramework/';

cms_service_url['get_header_footer'] = cms_service_url['cms_service_host'] + 'CMSWebService/getHeaderFooter.php?layoutid=' + layoutId;


/*configuration_info
 *  Cms structure url
 */
cms_url = new Array();
cms_url['get_cms_url'] = site_host + 'softswitch/'; // change with your folder name

cms_url['cms_host'] = cms_url['get_cms_url'] + 'webservices/';
 
/* =====================================
 *      Talemul
 * =====================================*/

cms_url['UserLogin'] = cms_url['cms_host'] + 'UserLogin/UserLogin.php';


cms_url['dhakaGate_error'] = cms_url['cms_host'] + 'error/error.php';

cms_url['rcportal_user_info'] = cms_url['cms_host'] + 'user_info/rcportal_user_info.php';
cms_url['rcportal_user_info_edit'] = cms_url['cms_host'] + 'user_info/rcportal_user_info_edit.php';
cms_url['rcportal_user_info_delete'] = cms_url['cms_host'] + 'user_info/rcportal_user_info_delete.php';

cms_url['rcportal_nat_static'] = cms_url['cms_host'] + 'nat/static.php';

cms_url['save_vpn_ipsec'] = cms_url['cms_host'] + 'vpn/save_vpn_ipsec.php';
cms_url['view_vpn_ipsec'] = cms_url['cms_host'] + 'vpn/view_vpn_ipsec.php';

cms_url['save_vpn_pptp_client'] = cms_url['cms_host'] + 'vpn/save_vpn_pptp_client.php';
cms_url['save_vpn_pptp_server'] = cms_url['cms_host'] + 'vpn/save_vpn_pptp_server.php';
cms_url['view_vpn_pptp_server'] = cms_url['cms_host'] + 'vpn/view_vpn_pptp_server.php';

cms_url['save_dhcp_subnet'] = cms_url['cms_host'] + 'dhcp/save_dhcp_subnet.php';
cms_url['view_dhcp_subnet'] = cms_url['cms_host'] + 'dhcp/view_dhcp_subnet.php';
cms_url['save_dhcp_host'] = cms_url['cms_host'] + 'dhcp/save_dhcp_host.php';
cms_url['view_dhcp_host'] = cms_url['cms_host'] + 'dhcp/view_dhcp_host.php';
cms_url['save_dhcp_range'] = cms_url['cms_host'] + 'dhcp/save_dhcp_range.php';
cms_url['view_dhcp_range'] = cms_url['cms_host'] + 'dhcp/view_dhcp_range.php';
cms_url['save_dhcp_lease'] = cms_url['cms_host'] + 'dhcp/save_dhcp_lease.php';
cms_url['view_dhcp_lease'] = cms_url['cms_host'] + 'dhcp/view_dhcp_lease.php';


cms_url['drop_down_dhcp_subnet'] = cms_url['cms_host'] + 'dhcp/drop_down_dhcp_subnet.php';
cms_url['view_smsgw_shortcodes']=cms_url['cms_host']+ 'smsgw/view_smsgw_shortcodes.php';
cms_url['save_smsgw_keyword']=cms_url['cms_host']+ 'smsgw/save_smsgw_keyword.php';

cms_url['view_smsgw_keyword']=cms_url['cms_host']+ 'smsgw/view_smsgw_keyword.php';
cms_url['save_smsgw_shortcodes']=cms_url['cms_host']+ 'smsgw/save_smsgw_shortcodes.php';

cms_url['save_smsgw_service'] = cms_url['cms_host'] + 'smsgw/save_smsgw_service.php';
cms_url['view_smsgw_service'] = cms_url['cms_host'] + 'smsgw/view_smsgw_service.php';
cms_url['save_smsgw_tps'] = cms_url['cms_host'] + 'smsgw/save_smsgw_tps.php';
cms_url['view_smsgw_tps'] = cms_url['cms_host'] + 'smsgw/view_smsgw_tps.php';
cms_url['view_smsgw_report'] = cms_url['cms_host'] + 'smsgw/view_smsgw_report.php';

cms_url['rcportal_get_tcpdump_exec'] = cms_url['cms_host'] +'um/get_tcpdump_exec.php';

cms_url['rcportal_tcpdump_get_tcpdump_files'] = cms_url['cms_host'] +'um/get_tcpdump_file.php';

cms_url['show_dump_stats'] = cms_url['cms_host'] +'um/show_dump_stats.php';
cms_url['rcportal_get_dump_stats'] = cms_url['cms_host'] +'um/get_tcpdump_stats.php';


/* =====================================
 *Monir
 * =====================================*/
cms_url['rcportal_interface_list_show'] = cms_url['cms_host'] + 'nat/get_interface.php';
cms_url['rcportal_nat_static'] = cms_url['cms_host'] + 'nat/view_static_nat.php';
cms_url['rcportal_static_nat_submit'] = cms_url['cms_host'] + 'nat/submit_static_nat.php';
cms_url['rcportal_nat_dynamic'] = cms_url['cms_host'] + 'nat/view_dynamic_nat.php';
cms_url['rcportal_dynamic_nat_submit'] = cms_url['cms_host'] + 'nat/submit_dynamic_nat.php';

cms_url['rcportal_vrrp_routing'] = cms_url['cms_host'] + 'RT/vrrp/view_vrrp_routing.php';
cms_url['rcportal_vrrp_routing_submit'] = cms_url['cms_host'] + 'RT/vrrp/save_vrrp_configuration.php';
cms_url['rcportal_vrrp_check_instance'] = cms_url['cms_host'] + 'RT/vrrp/check_instance_name.php';

cms_url['rcportal_bgp_routing_submit'] = cms_url['cms_host'] + 'RT/bgp/save_bgp.php';
cms_url['rcportal_bgp_count'] = cms_url['cms_host'] + 'RT/bgp/count_bgp.php';
cms_url['rcportal_bgp_data_restore'] = cms_url['cms_host'] + 'RT/bgp/restore_bgp_data';
cms_url['rcportal_all_routes'] = cms_url['cms_host'] + 'RT/all_routes/get_all_route_list.php';

cms_url['rcportal_firewall_group'] = cms_url['cms_host'] + 'firewall/group/view_firewall_group.php';
cms_url['rcportal_firewall_group_submit'] = cms_url['cms_host'] + 'firewall/group/save_firewall_group.php';
cms_url['rcportal_firewall_sync_content'] = cms_url['cms_host'] + 'firewall/group/get_firewall_sync_content.php';
cms_url['rcportal_firewall_rule'] = cms_url['cms_host'] + 'firewall/rule/view_firewall_rule.php';
cms_url['rcportal_firewall_rule_submit'] = cms_url['cms_host'] + 'firewall/rule/save_firewall_rule.php';
cms_url['rcportal_firewall_group_ip'] = cms_url['cms_host'] + 'firewall/rule/get_firewall_group_ip.php';
cms_url['rcportal_firewall_group_host'] = cms_url['cms_host'] + 'firewall/rule/get_firewall_group_host.php';


cms_url['rcportal_firewall_save_config'] = cms_url['cms_host'] + 'firewall/config/save_firewall_config.php';
cms_url['rcportal_firewall_show_config'] = cms_url['cms_host'] + 'firewall/config/show_firewall_config.php';

cms_url['rcportal_firewall_log_show'] = cms_url['cms_host']  + 'um/view_firewall_log.php';
cms_url['rcportal_firewall_log_rule_show'] = cms_url['cms_host']  + 'um/view_firewall_log_rule.php';

cms_url['rcportal_check_available_version'] = cms_url['cms_host']  + 'version_control/version_check_locally.php';

cms_url['rcportal_backup_history'] = cms_url['cms_host']  + 'version_control/backup_history.php';

/* =====================================
 * Danial
 * =====================================*/
cms_url['rcportal_static_router_config'] = cms_url['cms_host'] + 'RT/static/save_static_config.php';
cms_url['rcportal_static_router_view'] = cms_url['cms_host'] + 'RT/static/static_router_view.php';

cms_url['rcportal_ospf_router_view'] =  cms_url['cms_host'] + 'RT/ospf/ospf_router_view.php';
cms_url['rcportal_ospf_router_config'] = cms_url['cms_host'] + 'RT/ospf/save_ospf_config.php';
cms_url['rcportal_bgp_acl_view'] = cms_url['cms_host'] + 'RT/bgp/bgp_acl_view.php';
cms_url['rcportal_save_bgp_acl'] = cms_url['cms_host'] + 'RT/bgp/save_bgp_acl.php';



cms_url['rcportal_rip_router_view'] = cms_url['cms_host'] + 'RT/rip/rip_router_view.php';
cms_url['rcportal_rip_router_config'] = cms_url['cms_host'] + 'RT/rip/save_rip_config.php';
cms_url['rcportal_rip_router_version'] = cms_url['cms_host'] + 'RT/rip/get_rip_version.php';

cms_url['rcportal_interface_list'] = cms_url['cms_host'] + 'ip_assignment/interface/get_interface_list.php';
cms_url['rcportal_interface_config'] = cms_url['cms_host'] + 'ip_assignment/interface/save_interface_config.php';
cms_url['rcportal_interface_action'] = cms_url['cms_host'] + 'ip_assignment/interface/interface.php';
cms_url['rcportal_add_subinterface'] =  cms_url['cms_host'] + 'ip_assignment/interface/add_interface.php';
//sms blust

cms_url['smsblust_get_time_slot'] = cms_url['cms_host'] + 'smsblust/get_time_slot.php';
cms_url['smsblust_get_srcmn_from_mask'] = cms_url['cms_host'] + 'smsblust/get_srcmn_from_mask.php';
cms_url['smsblust_submit_single_sms'] = cms_url['cms_host'] + 'smsblust/submit_single_sms.php';
cms_url['smsblust_get_contact_group_list'] = cms_url['cms_host'] + 'smsblust/get_contact_group_list.php';
cms_url['smsblust_get_sms_template'] = cms_url['cms_host'] + 'smsblust/get_smstemplate.php';
cms_url['smsblust_submit_bulk_sms'] =  cms_url['cms_host'] + 'smsblust/submit_bulk_sms.php';
cms_url['smsblust_save_smstemplate'] = cms_url['cms_host'] + 'smsblust/save_smstemplate.php';
cms_url['rcportal_smsblust_smstemplate'] = cms_url['cms_host'] + 'smsblust/view_smstemplate.php';
cms_url['rcportal_smsblust_group_view'] = cms_url['cms_host'] + 'smsblust/view_smsblust_group.php';
cms_url['rcportal_save_smsblust_group'] = cms_url['cms_host'] + 'smsblust/save_smsblust_group.php';
cms_url['rcportal_smsblast_group_recipient'] = cms_url['cms_host'] + 'smsblust/view_smsgw_group_recipient.php';
cms_url['rcportal_smsblast_group_recipient_delete'] = cms_url['cms_host'] + 'smsblust/delete_smsblast_group_recipient.php';
cms_url['rcportal_smsblast_group_recipient_save'] = cms_url['cms_host'] + 'smsblust/save_smsblast_group_recipient.php';
cms_url['rcportal_smsblast_report'] = cms_url['cms_host'] + 'smsblust/sms_blast_report.php';
cms_url['rcportal_smsblast_resend'] = cms_url['cms_host'] + 'smsblust/sms_blast_resend.php';
cms_url['rcportal_smsblast_timeslot_view'] = cms_url['cms_host'] + 'smsblust/view_smsblast_time_slot.php';
cms_url['rcportal_smsblast_get_timeslot'] =  cms_url['cms_host'] + 'smsblust/get_cgw_timeSlot.php';
cms_url['rcportal_submit_smsblast_timeslot'] = cms_url['cms_host'] + 'smsblust/submit_cgw_timeSlot.php';
cms_url['rcportal_smsblast_timeslot_id_check'] = cms_url['cms_host'] + 'smsblust/time_slot_exist.php';
cms_url['rcportal_smsblast_account_view'] = cms_url['cms_host'] + 'smsblust/view_smsblast_account.php';
cms_url['rcportal_smsblast_submit_account'] = cms_url['cms_host'] + 'smsblust/submit_account_manager.php';
cms_url['rcportal_smsblast_get_accounts'] =  cms_url['cms_host'] + 'smsblust/get_smsgw_accounts.php';
cms_url['rcportal_smsblast_submit_credit_transfer'] = cms_url['cms_host'] + 'smsblust/submit_credit_transfer.php';
cms_url['rcportal_smsblast_get_current_balance'] = cms_url['cms_host'] + 'smsblust/get_smsgw_accounts_balance.php';
cms_url['rcportal_smsblast_bulksms_view'] = cms_url['cms_host'] + 'smsblust/view_bulk_sms_permission.php';
cms_url['rcportal_smsblast_send_bulksms'] = cms_url['cms_host'] + 'smsblust/submitBulkSms.php';
//smsgw
cms_url['smsgw_get_config'] =  cms_url['cms_host'] + 'smsgw/get_smsgw_config.php';
cms_url['rcportal_submit_smsgw_config'] = cms_url['cms_host'] + 'smsgw/save_smsgw_config.php';

// Utility Manager
cms_url['rcportal_um_show_mac'] = cms_url['cms_host'] + 'um/get_execute_cmd.php';
cms_url['rcportal_um_show_ping'] = cms_url['cms_host'] + 'um/get_ping_output.php';
cms_url['rcportal_um_get_interface'] = cms_url['cms_host'] + 'um/get_source_interface.php';
cms_url['rcportal_um_show_config'] = cms_url['cms_host'] + 'um/frmShowUGW.php';
cms_url['rcportal_tcpdump_get_interface_options'] = cms_url['cms_host'] + 'um/get_tcpdump_interface.php';
cms_url['get_audit_trial_compare_string'] = cms_url['cms_host'] +'audit/get_audit_compare_string.php';
cms_url['rcportal_get_audit_pages'] = cms_url['cms_host'] +'audit/get_audit_pages.php';

/* =====================================
 *Nazibul start
 *______________________________________*/

cms_url['vpn_l2tp_save_action'] = cms_url['cms_host'] + 'vpn/save_l2tp.php';
cms_url['vpn_l2tp_table_view'] = cms_url['cms_host'] + 'vpn/view_vpn_l2tp.php';
cms_url['vpn_gre_save_action'] = cms_url['cms_host'] + 'vpn/save_gre.php';
cms_url['vpn_gre_table_view'] = cms_url['cms_host'] + 'vpn/view_vpn_gre.php';
cms_url['vpn_gre_update_status'] = cms_url['cms_host'] + 'vpn/update_gre_status.php';

cms_url['ip_assignment_bridge_action'] = cms_url['cms_host'] + 'bridge/save_bridge_data.php';
cms_url['ip_assignment_bridge_view'] = cms_url['cms_host'] + 'bridge/view_bridge_data.php';
cms_url['ip_assignment_bridge_options'] = cms_url['cms_host'] + 'bridge/get_bridge_options.php';
cms_url['alert_msg_event_add'] = cms_url['cms_host'] + 'alert_message/save_alert_event.php';
cms_url['alert_msg_event_view'] = cms_url['cms_host'] + 'alert_message/view_alert_event.php';
cms_url['alert_msg_email_data'] = cms_url['cms_host'] + 'alert_message/data_alert_email.php';
cms_url['alert_msg_email_add'] = cms_url['cms_host'] + 'alert_message/save_alert_email.php';
cms_url['alert_msg_sms_data'] = cms_url['cms_host'] + 'alert_message/data_alert_sms.php';
cms_url['alert_msg_sms_add'] = cms_url['cms_host'] + 'alert_message/save_alert_sms.php';
cms_url['alert_msg_recept_group'] = cms_url['cms_host'] + 'alert_message/save_alert_recpt_group.php';
cms_url['alert_msg_recept_view'] = cms_url['cms_host'] + 'alert_message/view_alert_receipt_group.php';
cms_url['alert_all_recept_group'] = cms_url['cms_host'] + 'alert_message/view_recept_group.php';
cms_url['alert_app_event_save'] = cms_url['cms_host'] + 'alert_message/save_application_event.php';
cms_url['alert_app_event_view'] = cms_url['cms_host'] + 'alert_message/view_application_event.php';
cms_url['alert_app_all'] = cms_url['cms_host'] + 'alert_message/get_all_application.php';
cms_url['alert_event_all'] = cms_url['cms_host'] + 'alert_message/get_all_event.php';

cms_url['view_extensions_info'] = cms_url['cms_host'] + 'softswitch/view_extension_info.php';
cms_url['parse_extensions_info'] = cms_url['cms_host'] + 'softswitch/parse_extension_info.php';
cms_url['add_extensions_info'] =  cms_url['cms_host'] + 'softswitch/add_extension_basic_info.php';
cms_url['view_dialplan_info'] = cms_url['cms_host'] + 'softswitch/view_dial_plan.php';
cms_url['add_dial_plan_info'] = cms_url['cms_host'] + 'softswitch/add_dial_plan_info.php';
cms_url['view_dial_plan_context_info'] = cms_url['cms_host'] + 'softswitch/view_dial_plan_context_info.php';
cms_url['add_dial_plan_context_info'] =  cms_url['cms_host'] + 'softswitch/add_dial_plan_context_info.php';
cms_url['view_context_info'] = cms_url['cms_host'] + 'softswitch/view_context_info.php';
cms_url['add_context_info'] =  cms_url['cms_host'] + 'softswitch/add_context_info.php';
cms_url['configuration_info']=cms_url['cms_host']+ 'softswitch/configuration_info.php';
//cms_url['view_configuration_info']=cms_url['cms_host']+ 'softswitch/view_configuration_info.php';

cms_url['routing_static_restart']=cms_url['cms_host']+ 'RT/frmRoutingRestart.php';
cms_url['routing_get_executed_result']=cms_url['cms_host']+ 'RT/get_executed_result.php';
cms_url['routing_dhcp_restart']=cms_url['cms_host']+ 'dhcp/frmDhcpRestart.php';
cms_url['routing_vpn_restart']=cms_url['cms_host']+ 'vpn/frmVPNRestart.php';

/*______________________________________
 *Nazibul end
 * =====================================*/



/* =====================================
 *
 * Rakib start
 * =====================================*/
 /*    cms_url['bwc_group_table_view'] = cms_url['cms_host'] + 'bwc/show_group.php';
     cms_url['bwc_group_save_action'] = cms_url['cms_host'] + 'bwc/save_group.php';
     cms_url['bwc_client_table_view'] = cms_url['cms_host'] + 'bwc/show_client.php';
     cms_url['bwc_client_save_action'] = cms_url['cms_host'] + 'bwc/save_client.php';
*/
     cms_url['bwc_group_table_view'] = cms_url['cms_host'] + 'bwc/show_group.php';
     cms_url['bwc_group_save_action'] = cms_url['cms_host'] + 'bwc/save_group.php';
     cms_url['bwc_client_table_view'] = cms_url['cms_host'] + 'bwc/show_client.php';
     cms_url['bwc_client_save_action'] = cms_url['cms_host'] + 'bwc/save_client.php';
     cms_url['bwc_group_options'] = cms_url['cms_host'] + 'bwc/show_group_client.php';
     cms_url['bwc_client_rules_table_view'] = cms_url['cms_host'] + 'bwc/show_client_rules.php';
     cms_url['bwc_time_options'] = cms_url['cms_host'] + 'bwc/show_time_client.php';
     cms_url['bwc_timepackage_table_view'] = cms_url['cms_host'] + 'bwc/show_timepackage.php';
     cms_url['bwc_timepackage_save_action'] = cms_url['cms_host'] + 'bwc/save_timepackage.php';
     cms_url['bwp_show_action'] = cms_url['cms_host'] + 'bwp/show_bwp.php';
     cms_url['bwp_save_action'] = cms_url['cms_host'] + 'bwp/save_bwp.php';
     cms_url['get_bwp_command_output'] = cms_url['cms_host'] + 'bwp/show_bwp_log.php';



/* =====================================
 *
 * =====================================*/

/* =====================================
 *	Plabon start
 * =====================================*/

cms_url['submit_dnd_list'] = cms_url['cms_host'] + 'obd/fileImportDND.php';
cms_url['view_dnd_list'] = cms_url['cms_host'] + 'obd/view_dnd_list.php';
cms_url['delete_obd_dnd'] = cms_url['cms_host'] + 'obd/delete_obd_dnd.php';
cms_url['submit_white_list'] = cms_url['cms_host'] + 'obd/fileImportWhite.php';
cms_url['view_white_list'] = cms_url['cms_host'] + 'obd/view_white_list.php';
cms_url['delete_obd_white'] = cms_url['cms_host'] + 'obd/delete_obd_white.php';
cms_url['show_obd_dashboard'] = cms_url['cms_host'] + 'obd/show_obd_dashboard.php';
cms_url['show_execution_list'] = cms_url['cms_host'] + 'obd/show_execution_list.php';
cms_url['submit_obd_instance'] = cms_url['cms_host'] + 'obd/submit_obd_instance.php';
cms_url['obd_execution_operation'] = cms_url['cms_host'] + 'obd/obd_execute_operation.php';
/* =====================================
 *	Plabon end
 * =====================================*/



/* =====================================
softswitch
 * =====================================*/

cms_url['view_extensions_info'] = cms_url['cms_host'] + 'softswitch/view_extension_info.php';
cms_url['add_extensions_info'] = cms_url['cms_host'] + 'softswitch/add_extension_basic_info.php';

cms_url['view_dialplan_info'] = cms_url['cms_host'] + 'softswitch/view_dial_plan.php';
cms_url['add_dial_plan_info'] = cms_url['cms_host'] + 'softswitch/add_dial_plan_info.php';

cms_url['view_dial_plan_context_info'] = cms_url['cms_host'] + 'softswitch/view_dial_plan_context_info.php';
cms_url['add_dial_plan_context_info'] = cms_url['cms_host'] + 'softswitch/add_dial_plan_context_info.php';

cms_url['view_context_info'] = cms_url['cms_host'] + 'softswitch/view_context_info.php';
cms_url['add_context_info'] = cms_url['cms_host'] + 'softswitch/add_context_info.php';

cms_url['view_route_info'] = cms_url['cms_host'] + 'softswitch/view_route_info.php';
cms_url['add_route_info'] = cms_url['cms_host'] + 'softswitch/add_route_info.php';
cms_url['parse_route_info'] = cms_url['cms_host'] + 'softswitch/parse_route_info.php';

cms_url['view_server_info'] = cms_url['cms_host'] + 'softswitch/view_server_info.php';
cms_url['add_server_info'] = cms_url['cms_host'] + 'softswitch/add_server_info.php';
cms_url['parse_server_info'] = cms_url['cms_host'] + 'softswitch/parse_server_info.php';

cms_url['show_im_cdr'] = cms_url['cms_host'] + 'softswitch/search_im_cdr.php';
cms_url['show_call_cdr'] = cms_url['cms_host'] + 'softswitch/search_call_cdr.php';

cms_url['show_client_setting_info'] = cms_url['cms_host'] + 'softswitch/show_client_setting_info.php';
cms_url['save_client_setting_info'] = cms_url['cms_host'] + 'softswitch/save_client_setting_info.php';


cms_url['configuration_info'] = cms_url['cms_host'] + 'softswitch/configuration_info.php';

cms_url['show_log_management'] = cms_url['cms_host'] + 'softswitch/search_log_management_info.php';
cms_url['softswitch_maintenance'] = cms_url['cms_host'] + 'softswitch/softswitch_maintenance.php';
cms_url['add_soft_gw'] = cms_url['cms_host']+ 'softswitch/add_softswitch_gw.php';
cms_url['view_soft_gw'] = cms_url['cms_host']+ 'softswitch/view_softswitch_gw.php';

cms_url['softswitch_gw_inbound'] = cms_url['cms_host']+ 'softswitch/get_gw_inbound';
cms_url['softswitch_gw_outbound'] = cms_url['cms_host']+ 'softswitch/get_gw_outbound';

cms_url['soft_dial_plan'] = cms_url['cms_host']+ 'softswitch/add_soft_dial_plan.php';
cms_url['view_soft_dialplan'] = cms_url['cms_host']+ 'softswitch/view_softswitch_dialplan.php';



/*===============================================================================================
                                      audit trial
=================================================================================================*/
cms_url['audit_history'] = cms_url['cms_host'] + 'audit/audit_history.php';
cms_url['audit_compare'] = cms_url['cms_host'] + 'audit/audit_compare.php';

 /*===============================================================================================
                                     IVR
=================================================================================================*/
cms_url['ivr_server_name'] = cms_url['cms_host'] + 'ivr/ivr_mapping_getServerName';
cms_url['save_ivr_mapping'] = cms_url['cms_host'] + 'ivr/ivr_mapping_add.php';
cms_url['rcportal_ivr_mapping_view'] = cms_url['cms_host'] + 'ivr/ivr_mapping_view.php';

cms_url['ivr_data_server_name'] = cms_url['cms_host'] + 'ivr/ivr_data_getServerName';
cms_url['ivr_data_service_name'] = cms_url['cms_host'] + 'ivr/ivr_data_getService';
cms_url['ivr_data_page_name'] = cms_url['cms_host'] + 'ivr/ivr_data_getPage';
cms_url['rcportal_ivr_data_view'] = cms_url['cms_host'] + 'ivr/searchView_ivr_mapping.php';



cms_url['save_ivr_server_info']=cms_url['cms_host']+ 'smsgw/ivr_server_info_save.php';
cms_url['view_ivr_server_info']=cms_url['cms_host']+ 'smsgw/ivr_server_info_view.php';


/* =====================================
 *
 * =====================================*/
 

/*=======================================
				General Settings
=========================================*/
cms_url['general_settings_timeZone'] = cms_url['cms_host'] + 'general_settings/general_setting.php';

/* =====================================
 *      Shubhajit start
 * =====================================*/
cms_url['read_sgw_config'] = cms_url['cms_host'] + 'SignalingGateway/Config/read_sgw_config.php';
cms_url['write_sgw_config'] = cms_url['cms_host'] + 'SignalingGateway/Config/write_sgw_config.php';

cms_url['read_from_chmap'] = cms_url['cms_host'] + 'SignalingGateway/ChMap/read_from_chmap.php';
cms_url['write_from_chmap'] = cms_url['cms_host'] + 'SignalingGateway/ChMap/write_from_chmap.php';

/* =====================================
 *      Shubhajit End
 * =====================================*/

/* =====================================
 * Call handler start...
 * =====================================*/

cms_url['call_handler_vsdp_config'] = cms_url['cms_host']+ 'call_handler/call_handler_vsdp_config.php';
cms_url['call_handler_parse_vsdp'] = cms_url['cms_host'] + 'call_handler/call_handler_parse_vsdp.php';
cms_url['call_handler_chMap_config'] = cms_url['cms_host'] + 'call_handler/call_handler_chMap_config.php';
cms_url['call_hander_parse_chMap']  = cms_url['cms_host'] + 'call_handler/call_handler_parse_chMap.php';
cms_url['call_handler_iufp_config'] = cms_url['cms_host'] + 'call_handler/call_handler_iufp_config.php';
cms_url['call_handler_parse_iufp'] = cms_url['cms_host'] + 'call_handler/call_handler_parse_iufp.php';
/* =====================================
 * call handler end
 * =====================================*/


