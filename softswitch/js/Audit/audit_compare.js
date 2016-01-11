
function report_menu_start_audit_compare() {
//alert();
    var dataSet = [[]];
    var dataInfo = {};
    //dataInfo['uid'] = 'test@test.com';
	 dataSet = connectServer(cms_url['audit_compare'],dataInfo );
    //  alert(dataSet);
    dataSet = JSON.parse(dataSet);
    //alert(dataSet);
  //  table_data_audit_view(dataSet);
	$('#tbl_view_table').html(dataSet.response);

}
