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

function set_brust_change()
 {
	var data = $("#bwc_info_Brust").val();

	if(data == "0")
         	{
			$("#brust_bw").hide();
                         dropdown_chosen_style();
		}else
			{

		  	$("#brust_bw").show();
			}
 }

function set_group_brust_change()
 {
	var data = $("#bwc_group_Brust").val();

	if(data == "0")
         	{
			$("#brust_bw").hide();
                         dropdown_chosen_style();
		}else
			{

		  	$("#brust_bw").show();
			}
 }
function showUserMenu(field_name) {
$('#tab_view').html('');
    message_clear();
    $('#id_loading_image').show();
    /* pages available before logging in */

    if (field_name == 'login') {
        displayContent("1700", "#cmsData", "#contentListLayout", "ContentID");
    }

    /* pages available after logged in */

    var cms_auth = checkSession('cms_auth');
    if (cms_auth != null) {
        $('#id_loading_image').hide();

        $("#nav-navbar-collapse-1").removeClass("in");
        if (field_name == 'index') {
            $('#id_loading_image').hide();
            displayContent("1701", "#cmsData", "#contentListLayout", "ContentID");
            default_menu();
	     version_check();
        } else if (field_name == 'signOut') {
            cmsLogout(site_host);
        }


else if (field_name == 'softswitch_extensions_add') {
            display_content_custom('1702', '#modalData');
            //$('.tabtitle').hide();
            $("#set_title").html('<img width="3%" src="softswitch/img/icon-setting.png"> <span style="font-weight:bold;">Extensions </span>');

           var inputarray = [["Add", "softswitch_extensions_add", "active"], ["View", "softswitch_extensions_view", "deactive"]];
            tab_custom(inputarray, "tab_view");
        } else if (field_name == 'softswitch_extensions_view') {
            display_content_custom('150', '#modalData');
            //$('.tabtitle').hide();
            $("#set_title").html('<img width="3%" src="softswitch/img/icon-setting.png"> <span style="font-weight:bold;">Extensions </span>');

            var inputarray = [["Add", "softswitch_extensions_add", "deactive"], ["View", "softswitch_extensions_view", "active"]];
            tab_custom(inputarray, "tab_view");
            table_initialize_dial_plan_info();
            report_menu_start_extensions_info();
        }else if (field_name == 'softswitch_gateway') {

            display_content_custom('1713', '#modalData');
            $('.tabtitle').hide();
            $("#set_title").html('<img width="3%" src="softswitch/img/icon-setting.png"> <span style="font-weight:bold;">Gateway </span>');
            var inputarray = [["Add", "softswitch_gateway", "active"], ["View", "softswitch_gateway_view", "deactive"]];
            tab_custom(inputarray, "tab_view");
        }else if (field_name == 'softswitch_gateway_view') {
            display_content_custom('150', '#modalData');
            $('.tabtitle').hide();
            $("#set_title").html('<img width="3%" src="softswitch/img/icon-setting.png"> <span style="font-weight:bold;">Gateway </span>');
            var inputarray = [["Add", "softswitch_gateway", "deactive"], ["View", "softswitch_gateway_view", "active"]];
            tab_custom(inputarray, "tab_view");
	    table_initialize_soft_gw();
            report_menu_start_soft_gw();
        } 

		else if (field_name == 'softswitch_dial_plan_add') {

            display_content_custom('1714', '#modalData');
		getSoftswitchGwInbound();
		getSoftswitchGwOutbound();
            $("#set_title").html('<img width="3%" src="softswitch/img/icon-setting.png"> <span style="font-weight:bold;">Dial Plan Settings </span>');
            var inputarray = [["Add", "softswitch_dial_plan_add", "active"], ["View", "softswitch_dial_plan_view", "deactive"]];
            tab_custom(inputarray, "tab_view");
       }

else if (field_name == 'softswitch_dial_plan_view') {
            display_content_custom('150', '#modalData');
            $("#set_title").html('<img width="3%" src="softswitch/img/icon-setting.png"> <span style="font-weight:bold;">Dial Plan Settings</span>');
            var inputarray = [["Add", "softswitch_dial_plan_add", "deactive"], ["View", "softswitch_dial_plan_view", "active"]];
            tab_custom(inputarray, "tab_view");
	    table_initialize_soft_dialPlan();
         report_menu_start_soft_dialPlan();
             }

else if (field_name == 'softswitch_context_add') {
            display_content_custom("1703", "#modalData");
            $('.tabtitle').hide();
            $("#set_title").html('<img width="3%" src="softswitch/img/icon-setting.png"> <span style="font-weight:bold;">Softswitch Context Setting</span>');

            var inputarray = [["Add", "softswitch_context_add", "active"], ["View", "softswitch_context_view", "deactive"]];
            tab_custom(inputarray, "tab_view");
        } else if (field_name == 'softswitch_context_view') {
            display_content_custom("150", "#modalData");
            $('.tabtitle').hide();
            $("#set_title").html('<img width="3%" src="softswitch/img/icon-setting.png"> <span style="font-weight:bold;">Softswitch Context Setting</span>');
            var inputarray = [["Add", "softswitch_context_add", "deactive"], ["View", "softswitch_context_view", "active"]];
            tab_custom(inputarray, "tab_view");
            table_initialize_context_info();
            report_menu_start_context_info();
        } else if (field_name == 'softswitch_dial_context_add') {
            display_content_custom("1704", "#modalData");
            $('.tabtitle').hide();
            $("#set_title").html('<img width="3%" src="softswitch/img/icon-setting.png"> <span style="font-weight:bold;">Dial Plan Context Setting</span>');
            var inputarray = [["Configuration", "softswitch_dial_context_add", "active"], ["View", "softswitch_dial_context_view", "deactive"]];
            tab_custom(inputarray, "tab_view");
        } else if (field_name == 'softswitch_dial_context_view') {
            display_content_custom("150", "#modalData");
            $('.tabtitle').hide();
            $("#set_title").html('<img width="3%" src="softswitch/img/icon-setting.png"> <span style="font-weight:bold;">Dial Plan Context Setting</span>');
            var inputarray = [["Configuration", "softswitch_dial_context_add", "deactive"], ["View", "softswitch_dial_context_view", "active"]];
            tab_custom(inputarray, "tab_view");
            table_initialize_dial_plan_context_info();
            report_menu_start_dial_plan_context_info();
        } else if (field_name == 'softswitch_dial_plan_add') {
            display_content_custom('1705', '#modalData');
            $('.tabtitle').hide();
            $("#set_title").html('<img width="3%" src="softswitch/img/icon-setting.png"> <span style="font-weight:bold;">Dial Plan Setting</span>');
            var inputarray = [["Add", "softswitch_dial_plan_add", "active"], ["View", "softswitch_dial_plan_view", "deactive"]];
            tab_custom(inputarray, "tab_view");
        } else if (field_name == 'softswitch_dial_plan_view') {
            display_content_custom('150', '#modalData');
            $('.tabtitle').hide();
            $("#set_title").html('<img width="3%" src="softswitch/img/icon-setting.png"> <span style="font-weight:bold;">Dial Plan Setting</span>');

            var inputarray = [["Add", "softswitch_dial_plan_add", "deactive"], ["View", "softswitch_dial_plan_view", "active"]];
            tab_custom(inputarray, "tab_view");
            table_initialize_dialplan_info();
            report_menu_start_dialplan_info();
        } else if (field_name == 'softswitch_configuration') {
            display_content_custom("1710", "#modalData");
            $('.tabtitle').hide();
            $("#set_title").html('<img width="3%" src="softswitch/img/icon-setting.png"> <span style="font-weight:bold;">Configuration</span>');
           // parse_softswitch_config_data();
           /* var inputarray = [["Add", "softswitch_configuration", "active"], ["View", "softswitch_configuration_view", "deactive"]];
            tab_custom(inputarray, "tab_view");*/
        } else if (field_name == 'softswitch_configuration_view') {
            display_content_custom('150', '#modalData');
            $('.tabtitle').hide();
            $("#set_title").html('<img width="3%" src="softswitch/img/icon-setting.png"> <span style="font-weight:bold;">Configuration</span>');

            var inputarray = [["Add", "softswitch_configuration", "deactive"], ["View", "softswitch_configuration_view", "active"]];
            tab_custom(inputarray, "tab_view");
            table_initialize_soft_config();
            report_menu_start_soft_config();
        } else if (field_name == 'softswitch_route_add') {
            display_content_custom("1706", "#modalData");
            $('.tabtitle').hide();
            $("#set_title").html('<img width="3%" src="softswitch/img/icon-setting.png"> <span style="font-weight:bold;">Routes</span>');

            var inputarray = [["Add", "softswitch_route_add", "active"], ["View", "softswitch_route_view", "deactive"]];
            tab_custom(inputarray, "tab_view");
           // parse_softswitch_routes();
        } else if (field_name == 'softswitch_route_view') {
            display_content_custom("150", "#modalData");
            $('.tabtitle').hide();
            $("#set_title").html('<img width="3%" src="softswitch/img/icon-setting.png"> <span style="font-weight:bold;">Routes</span>');

            var inputarray = [["Add", "softswitch_route_add", "deactive"], ["View", "softswitch_route_view", "active"]];
            tab_custom(inputarray, "tab_view");
            table_initialize_route_info();
            report_menu_start_route_info();
        } else if (field_name == 'softswitch_server_add') {
            display_content_custom("1711", "#modalData");
            $('.tabtitle').hide();
            $("#set_title").html('<img width="3%" src="softswitch/img/icon-setting.png"> <span style="font-weight:bold;">Servers</span>');
            var inputarray = [["Add", "softswitch_server_add", "active"], ["View", "softswitch_server_view", "deactive"]];
            tab_custom(inputarray, "tab_view");
            parse_softswitch_servers();
        } else if (field_name == 'softswitch_server_view') {
            display_content_custom('150', '#modalData');
            $('.tabtitle').hide();
            $("#set_title").html('<img width="3%" src="softswitch/img/icon-setting.png"> <span style="font-weight:bold;">Servers</span>');

            var inputarray = [["Add", "softswitch_server_add", "deactive"], ["View", "softswitch_server_view", "active"]];
            tab_custom(inputarray, "tab_view");
            table_initialize_server_info();
            report_menu_start_server_info();
        } else if (field_name == 'softswitch_client_setting') {
            display_content_custom("1712", "#modalData");
            $('.tabtitle').hide();
            $("#set_title").html('<img width="3%" src="softswitch/img/icon-setting.png"> <span style="font-weight:bold;">Client Settings</span>');

            show_softswitch_ippbx_client();
        }

        // al amin
        else if (field_name == 'for_test_add') {
            display_content_custom('1807', '#modalData');
            //$('.tabtitle').hide();
           $("#set_title").html('<img width="3%" src="softswitch/img/icon-setting.png"> <span style="font-weight:bold;">Test Purpose </span>');

           var inputarray = [["Add", "for_test_add", "active"], ["View", "for_test_view", "deactive"]];
            tab_custom(inputarray, "tab_view");
        }
        else if (field_name == 'for_test_view') {
            display_content_custom('1808', '#modalData');
            $('.tabtitle').hide();

            var inputarray = [["Add","for_test_add","deactive"],["View","for_test_view","active"]];
            tab_custom(inputarray, "tab_view");
            table_initialize_soft_gw();
            report_menu_start_soft_gw();
        }
        // end alamin
		   else if (field_name == 'softswitch_diagnosis') {
            display_content_custom('1707', '#modalData');
            $('.tabtitle').hide();
            $("#set_title").html('<img width="3%" src="softswitch/img/icon-setting.png"> <span style="font-weight:bold;">Softswitch Diagnosis</span>');

            softswitch_DateTimePicker('call_start_time');
            softswitch_DateTimePicker('call_end_time');
            var inputarray = [["CDR", "softswitch_diagnosis", "active"], ["Log", "softswitch_diagnosis_log", "deactive"], ["Maintenance", "softswitch_diagnosis_maintenance", "deactive"]];
            tab_custom(inputarray, "tab_view");
        }  else if (field_name == 'softswitch_diagnosis_log') {
            display_content_custom('1708', '#modalData');
            $('.tabtitle').hide();
            $("#set_title").html('<img width="3%" src="softswitch/img/icon-setting.png"> <span style="font-weight:bold;">Softswitch Diagnosis</span>');

            softswitch_DatePicker('log_server_time_from');
            softswitch_DatePicker('log_server_time_to');
            softswitch_DatePicker('source_timestamp_from');
            softswitch_DatePicker('source_timestamp_to');
            var inputarray = [["CDR", "softswitch_diagnosis", "deactive"], ["Log", "softswitch_diagnosis_log", "active"], ["Maintenance", "softswitch_diagnosis_maintenance", "deactive"]];
            tab_custom(inputarray, "tab_view");
        } else if (field_name == 'softswitch_diagnosis_maintenance') {
            display_content_custom('1715', '#modalData');
            $('.tabtitle').hide();
            $("#set_title").html('<img width="3%" src="softswitch/img/icon-setting.png"> <span style="font-weight:bold;">Softswitch Diagnosis</span>');

            var inputarray = [["CDR", "softswitch_diagnosis", "deactive"], ["Log", "softswitch_diagnosis_log", "deactive"], ["Maintanance", "softswitch_diagnosis_maintenance", "active"]];
            tab_custom(inputarray, "tab_view");
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


}
