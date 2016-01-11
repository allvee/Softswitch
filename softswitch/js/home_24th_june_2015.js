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
            var inputarray = [["Add", "softswitch_extensions_add", "active"], ["View", "softswitch_extensions_view", "deactive"]];
            tab_custom(inputarray, "tab_view");
        } else if (field_name == 'softswitch_extensions_view') {
            display_content_custom('150', '#modalData');
            var inputarray = [["Add", "softswitch_extensions_add", "deactive"], ["View", "softswitch_extensions_view", "active"]];
            tab_custom(inputarray, "tab_view");
            table_initialize_dial_plan_info();
            report_menu_start_extensions_info();
        } else if (field_name == 'softswitch_context_add') {
            display_content_custom("1703", "#modalData");
            var inputarray = [["Add", "softswitch_context_add", "active"], ["View", "softswitch_context_view", "deactive"]];
            tab_custom(inputarray, "tab_view");
        } else if (field_name == 'softswitch_context_view') {
            display_content_custom("150", "#modalData");
            var inputarray = [["Add", "softswitch_context_add", "deactive"], ["View", "softswitch_context_view", "active"]];
            tab_custom(inputarray, "tab_view");
            table_initialize_context_info();
            report_menu_start_context_info();
        } else if (field_name == 'softswitch_dial_context_add') {
            display_content_custom("1704", "#modalData");
            var inputarray = [["Configuration", "softswitch_dial_context_add", "active"], ["View", "softswitch_dial_context_view", "deactive"]];
            tab_custom(inputarray, "tab_view");
        } else if (field_name == 'softswitch_dial_context_view') {
            display_content_custom("150", "#modalData");
            var inputarray = [["Configuration", "softswitch_dial_context_add", "deactive"], ["View", "softswitch_dial_context_view", "active"]];
            tab_custom(inputarray, "tab_view");
            table_initialize_dial_plan_context_info();
            report_menu_start_dial_plan_context_info();
        }
        
        
        else if (field_name == 'softswitch_dial_plan_add') {
            display_content_custom('1705', '#modalData');
            var inputarray = [["Add", "softswitch_dial_plan_add", "active"], ["View", "softswitch_dial_plan_view", "deactive"]];
            tab_custom(inputarray, "tab_view");
        } else if (field_name == 'softswitch_dial_plan_view') {
            display_content_custom('150', '#modalData');
            var inputarray = [["Add", "softswitch_dial_plan_add", "deactive"], ["View", "softswitch_dial_plan_view", "active"]];
            tab_custom(inputarray, "tab_view");
            table_initialize_dialplan_info();
            report_menu_start_dialplan_info();
       
        }
        
        else if (field_name == 'softswitch_configuration') {
           
            display_content_custom("1710", "#modalData");
            var inputarray = [["Add", "softswitch_configuration", "active"], ["View", "softswitch_configuration_view", "deactive"]];
            tab_custom(inputarray, "tab_view");
        } else if (field_name == 'softswitch_configuration_view') {
            display_content_custom('150', '#modalData');
            var inputarray = [["Add", "softswitch_configuration", "deactive"], ["View", "softswitch_configuration_view", "active"]];
            tab_custom(inputarray, "tab_view");
            table_initialize_soft_config();
            report_menu_start_soft_config();
        }
        
        
        
        
        else if (field_name == 'softswitch_route_add') {
            display_content_custom("1706", "#modalData");
            var inputarray = [["Add", "softswitch_route_add", "active"], ["View", "softswitch_route_view", "deactive"]];
            tab_custom(inputarray, "tab_view");
        } else if (field_name == 'softswitch_route_view') {
            display_content_custom("150", "#modalData");
            var inputarray = [["Add", "softswitch_route_add", "deactive"], ["View", "softswitch_route_view", "active"]];
            tab_custom(inputarray, "tab_view");
            table_initialize_route_info();
            report_menu_start_route_info();
        } else if (field_name == 'softswitch_server_add') {
            display_content_custom("1711", "#modalData");
            var inputarray = [["Add", "softswitch_server_add", "active"], ["View", "softswitch_server_view", "deactive"]];
            tab_custom(inputarray, "tab_view");
        } else if (field_name == 'softswitch_server_view') {
            display_content_custom('150', '#modalData');
            var inputarray = [["Add", "softswitch_server_add", "deactive"], ["View", "softswitch_server_view", "active"]];
            tab_custom(inputarray, "tab_view");
            table_initialize_server_info();
            report_menu_start_server_info();
        } else if (field_name == 'softswitch_client_setting') {
            display_content_custom("1712", "#modalData");
            show_softswitch_ippbx_client();
        } 
        
        
        
        
        
         else if (field_name == 'softswitch_log_add') {
            display_content_custom('108', '#modalData');
        } else if (field_name == 'softswitch_log_log') {
            display_content_custom("109", "#modalData");
        } else if (field_name == 'softswitch_cdr_call') {
            display_content_custom("110", "#modalData");
        } else if (field_name == 'softswitch_cdr_im') {
            display_content_custom("111", "#modalData");
        } 
        
        
        
        
        else if (field_name == 'softswitch_diagnosis') {
            display_content_custom('1707', '#modalData');
            var inputarray = [["CDR", "softswitch_diagnosis", "active"], ["Log", "softswitch_diagnosis_log", "deactive"], ["Maintenance", "softswitch_diagnosis_maintenance", "deactive"]];
            tab_custom(inputarray, "tab_view");
        }  else if (field_name == 'softswitch_diagnosis_log') {
            display_content_custom('1708', '#modalData');
	    softswitch_DatePicker('log_server_time_from');
            softswitch_DatePicker('log_server_time_to');
            softswitch_DatePicker('source_timestamp_from');
            softswitch_DatePicker('source_timestamp_to');
            var inputarray = [["CDR", "softswitch_diagnosis", "deactive"], ["Log", "softswitch_diagnosis_log", "active"], ["Maintenance", "softswitch_diagnosis_maintenance", "deactive"]];
            tab_custom(inputarray, "tab_view");
        } else if (field_name == 'softswitch_diagnosis_maintenance') {
            display_content_custom('1709', '#modalData');
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

	// if ($("#nav-navbar-collapse-1").hasClass("in")) {
	// $("#nav-navbar-collapse-1").removeClass("in").addClass("collapse");
	// }
}
/*
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

}*/
