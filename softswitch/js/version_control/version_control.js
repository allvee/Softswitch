function version_check() {
    var dataInfo = {};
    var available = "";
    var current_version = "";
    var current_version_name = "";
    var available_version = "";
    var available_version_name = "";

    var response = connectServer(cms_url['rcportal_check_available_version'], dataInfo);


    var result_array = response.split("|");


    available = result_array[0];
    available_version_name = result_array[1];
    current_version = result_array[2];
    available_version = [3];
    current_version_name = result_array[4];

    if (available.trim() == '1') {
        $.notify('<a style="text-decoration:none; color:black;" href="http://www.google.com" target="_blank">New version <span style="color:red; font-weight:bold;">' + available_version_name + '</span> available. Upgrade to new version!</a>', 'success');
    }

}
