/**
 * Created by Mazhar on 3/10/2015.
 */


function defaultViewController() {

    var cms_auth = checkSession('cms_auth');
    if (cms_auth == null) {
        //login page
        showUserMenu('login');
    } else {
        //login page
        showUserMenu('index');//after log in index
    }
}

function showUserMenu(field_name) {
    message_clear();
    $('#id_loading_image').show();

    /*pages available before logging in*/
    if (field_name == 'login') {
        displayContent("1", "#cmsData", "#contentListLayout", "ContentID");
    }
    else if (field_name == 'about') {
        displayContent("2", "#cmsData", "#contentListLayout", "ContentID");
    }
    else if (field_name == 'terms') {
        displayContent("3", "#cmsData", "#contentListLayout", "ContentID");
    }
    else if (field_name == 'privacy') {
        displayContent("4", "#cmsData", "#contentListLayout", "ContentID");
    }
    else if (field_name == 'refund') {
        displayContent("5", "#cmsData", "#contentListLayout", "ContentID");
    }
    else if (field_name == 'contact') {
        displayContent("6", "#cmsData", "#contentListLayout", "ContentID");
    }
    else if (field_name == 'user_registration') {
        displayContent("55", "#cmsData", "#contentListLayout", "ContentID");
    }
    else if (field_name == 'scratchCard_Inquiry') {
        displayContent("61", "#cmsData", "#contentListLayout", "ContentID");
    }


    /*pages available after logged in*/
    var cms_auth = checkSession('cms_auth');
    if (cms_auth != null) {
        $("#nav-navbar-collapse-1").removeClass("in");
        //if (field_name == 'index') {
        //    displayContent("13", "#cmsData", "#contentListLayout", "ContentID");
        //    $('#id_loading_image').hide();
        //    /*
        //     table_initialize_recharge_history("tbl_view_resellers", "dataTablesRechargeHistory");
        //     recharge_history_create("Partner", "dataTablesRechargeHistory");
        //
        //     displayContent("33", "#cmsData", "#contentListLayout", "ContentID");
        //     */
        //    dhakagate_recharge_history_DatePicker();
        //
        //    table_initialize_recharge_history_menu("tbl_recharge_history_menu", "data_table_recharge_history");
        //    report_recharge_history_menu("data_table_recharge_history", 0, 0, false);
        //
        //}
        //else if (field_name == 'sendFlexi') {
        //    displayContent("7", "#cmsData", "#contentListLayout", "ContentID");
        //
        //} else if (field_name == 'send_flexi_from_file') {
        //    displayContent("8", "#cmsData", "#contentListLayout", "ContentID");
        //} else if (field_name == 'view_sample_xl') {
        //    displayContent("9", "#cmsData", "#contentListLayout", "ContentID");
        //} else if (field_name == 'emergency_recharge') {
        //    displayContent("52", "#cmsData", "#contentListLayout", "ContentID");
        //    $('#id_loading_image').hide();
        //    table_initialize_emergency_recharge();
        //    report_menu_start_emergency_recharge();
        //}
        //else if (field_name == 'view_resellers') {
        //    displayContent("21", "#cmsData", "#contentListLayout", "ContentID");
        //    $('#id_loading_image').hide();
        //    table_initialize_view_resellers_menu("tbl_view_resellers", "dataTablesResellers");
        //    report_resellers_menu("resellers", "dataTablesResellers");
        //} else if (field_name == 'view_partners') {
        //    displayContent("22", "#cmsData", "#contentListLayout", "ContentID");
        //    $('#id_loading_image').hide();
        //    table_initialize_view_resellers_menu("tbl_view_partners", "dataTablesPartners");
        //    report_resellers_menu("Partner", "dataTablesPartners");
        //} else if (field_name == 'view_dealers') {
        //    displayContent("23", "#cmsData", "#contentListLayout", "ContentID");
        //    $('#id_loading_image').hide();
        //    table_initialize_view_resellers_menu("tbl_view_dealers", "dataTablesDealears");
        //    report_resellers_menu("Dealer", "dataTablesDealears");
        //} else if (field_name == 'view_distributors') {
        //    displayContent("24", "#cmsData", "#contentListLayout", "ContentID");
        //    $('#id_loading_image').hide();
        //    table_initialize_view_resellers_menu("tbl_view_distributors", "dataTablesDistributors");
        //    report_resellers_menu("Distributor", "dataTablesDistributors");
        //} else if (field_name == 'view_retailers') {
        //    displayContent("25", "#cmsData", "#contentListLayout", "ContentID");
        //    $('#id_loading_image').hide();
        //    table_initialize_view_resellers_menu("tbl_view_retailers", "dataTablesRetailers");
        //    report_resellers_menu("Retailer", "dataTablesRetailers");
        //} else if (field_name == 'view_users') {
        //    displayContent("26", "#cmsData", "#contentListLayout", "ContentID");
        //    $('#id_loading_image').hide();
        //    table_initialize_view_resellers_menu("tbl_view_users", "dataTablesUsers");
        //    report_resellers_menu("User", "dataTablesUsers");
        //} else if (field_name == 'view_pending_users') {
        //    displayContent("27", "#cmsData", "#contentListLayout", "ContentID");
        //    $('#id_loading_image').hide();
        //    table_initialize_view_pendingUsers_menu("tbl_view_pending_users", "dataTablesPendingUsers");
        //    report_pendingUsers_menu("PendingUser", "dataTablesPendingUsers");
        //}
        //else if (field_name == 'scratch_card') {
        //    displayContent("38", "#cmsData", "#contentListLayout", "ContentID");
        //} else if (field_name == 'generate_scratch_card') {
        //    displayContent("39", "#cmsData", "#contentListLayout", "ContentID");
        //} else if (field_name == 's_card_active') {
        //    displayContent("40", "#cmsData", "#contentListLayout", "ContentID");
        //} else if (field_name == 's_card_amount') {
        //    displayContent("41", "#cmsData", "#contentListLayout", "ContentID");
        //} else if (field_name == 's_card_assign') {
        //    displayContent("42", "#cmsData", "#contentListLayout", "ContentID");
        //} else if (field_name == 'search_s_card') {
        //    displayContent("43", "#cmsData", "#contentListLayout", "ContentID");
        //} else if (field_name == 'inactive_s_card') {
        //    displayContent("44", "#cmsData", "#contentListLayout", "ContentID");
        //} else if (field_name == 'active_s_card') {
        //    displayContent("45", "#cmsData", "#contentListLayout", "ContentID");
        //} else if (field_name == 'used_s_card') {
        //    displayContent("46", "#cmsData", "#contentListLayout", "ContentID");
        //} else if (field_name == 'active_s_card_amount') {
        //    displayContent("47", "#cmsData", "#contentListLayout", "ContentID");
        //}
        //else if (field_name == 'add_reseller_fund') {
        //    displayContent("14", "#cmsData", "#contentListLayout", "ContentID");
        //    $('#id_loading_image').hide();
        //    fetchDropDownOption('#userTransferTo', cms_url['dhakagate_find_reseller'], '');
        //}
        //else if (field_name == 'add_user_fund') {
        //    displayContent("15", "#cmsData", "#contentListLayout", "ContentID");
        //    $('#id_loading_image').hide();
        //    var auth_session_data = checkSession('cms_auth');
        //    var auth_data = JSON.parse(auth_session_data);
        //
        //    $('.show_to_user').remove(); // for admin
        //        fetchDropDownOption('#userTransferTo', cms_url['dhakagate_find_user'], '');
        //
        //}
        ////else if (field_name == 'reports') {
        ////    displayContent("32", "#cmsData", "#contentListLayout", "ContentID");
        ////}
        //else if (field_name == 'recharge_history') {
        //    displayContent("33", "#cmsData", "#contentListLayout", "ContentID");
        //    $('#id_loading_image').hide();
        //    dhakagate_recharge_history_DatePicker();
        //
        //    table_initialize_recharge_history_menu("tbl_recharge_history_menu", "data_table_recharge_history");
        //    report_recharge_history_menu("data_table_recharge_history", return_recharge_history_date_from(), return_recharge_history_date_to(),true);
        //
        //} else if (field_name == 'deleted_recharge_history') {
        //    displayContent("34", "#cmsData", "#contentListLayout", "ContentID");
        //    $('#id_loading_image').hide();
        //    deleted_recharge_history_DatePicker();
        //    table_initialize_dlt_recharge_history_menu("tbl_dlt_recharge_history_menu", "data_table_dlt_recharge_history");
        //    report_dlt_recharge_history_menu("data_table_dlt_recharge_history", return_dlt_recharge_history_date_from(), return_dlt_recharge_history_date_to());
        //
        //} else if (field_name == 'scratch_card_recharge_history') {
        //    displayContent("35", "#cmsData", "#contentListLayout", "ContentID");
        //    $('#id_loading_image').hide();
        //    scratch_card_recharge_history_DatePicker();
        //    table_initialize_sc_recharge_history_menu("tbl_src_recharge_history_menu", "data_table_sc_recharge_history");
        //    report_sc_recharge_history_menu("data_table_sc_recharge_history", return_src_recharge_history_date_from(), return_src_recharge_history_date_to());
        //
        //} else if (field_name == 'api_recharge_history') {
        //    displayContent("48", "#cmsData", "#contentListLayout", "ContentID");
        //    $('#id_loading_image').hide();
        //    table_initialize_api_recharge_history();
        //    report_menu_start_api_recharge_history();
        //} else if (field_name == 'payment_made_history') {
        //    displayContent("36", "#cmsData", "#contentListLayout", "ContentID");
        //    $('#id_loading_image').hide();
        //    table_initialize_view_payment("tbl_view_payment_made_history", "dataTablesPaymentMade");
        //    paymentDatePicker();
        //    report_payment("made", "dataTablesPaymentMade");
        //} else if (field_name == 'payment_received_history') {
        //    displayContent("37", "#cmsData", "#contentListLayout", "ContentID");
        //    $('#id_loading_image').hide();
        //    table_initialize_view_payment("tbl_view_payment_received_history", "dataTablesPaymentReceived");
        //    paymentDatePicker();
        //    report_payment("received", "dataTablesPaymentReceived");
        //}
        //else if (field_name == 'message_template_dhakagate') {
        //    displayContent("28", "#cmsData", "#contentListLayout", "ContentID");
        //    $('#id_loading_image').hide();
        //    table_initialize_message_template();
        //    report_menu_start_message_template();
        //}
        //else if (field_name == 'api_info_dhakagate') {
        //    displayContent("11", "#cmsData", "#contentListLayout", "ContentID");
        //    $('#id_loading_image').hide();
        //    table_initialize_api_info();
        //    report_menu_start_api_info();
        //} else if (field_name == 'operator_balance_dhakagate') {
        //    displayContent("12", "#cmsData", "#contentListLayout", "ContentID");
        //    $('#id_loading_image').hide();
        //    table_initialize_operator_balance();
        //    report_menu_start_operator_balance();
        //
        //}
        //else if (field_name == 'account') {
        //    displayContent("16", "#cmsData", "#contentListLayout", "ContentID");
        //    show_account_details();
        //} else if (field_name == 'account_edit') {
        //    displayContent("17", "#cmsData", "#contentListLayout", "ContentID");
        //    edit_input_form_account_details();
        //} else if (field_name == 'add_fund') {// add fund is unused
        //    displayContent("18", "#cmsData", "#contentListLayout", "ContentID");
        //} else if (field_name == 'change_pass') {
        //    displayContent("19", "#cmsData", "#contentListLayout", "ContentID");
        //} else

        if (field_name == 'signOut') {
            cmsLogout(site_host);
        }
        else if (field_name == 'rcportal_user_info') {
            displayContent("63", "#cmsData", "#contentListLayout", "ContentID");
            $('#id_loading_image').hide();
            table_initialize_user_info();
            report_menu_start_user_info();
        }else if (field_name == 'rcportal_nat_static') {
            displayContent("65", "#cmsData", "#contentListLayout", "ContentID");
            $('#id_loading_image').hide();
            table_initialize_nat_static();
            report_menu_start_nat_static();
        }else if (field_name == 'index') {
            displayContent("67", "#cmsData", "#contentListLayout", "ContentID");
        }else if (field_name == 'test') {
            displayContent("68", "#cmsData", "#contentListLayout", "ContentID");
        }

        dropdown_chosen_style();

        setTimeout(function () {
            showDashboardInfo()
        }, 1000);
    }

    $('#id_loading_image').hide();

    //if ($("#nav-navbar-collapse-1").hasClass("in")) {
    // $("#nav-navbar-collapse-1").removeClass("in").addClass("collapse");
    // }
}