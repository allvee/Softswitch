<?php

include_once "../lib/common.php";
$cn = connectDB();
$query = "SELECT id, user_id,user_name, action_command, field_tab, action_date, action_time, old_value, new_value, ip_address, browser, referer FROM tbl_audit_trail ORDER BY action_date desc ,id Desc ";
$result = Sql_exec($cn, $query);
if (!$result) {
    echo "err+" . $query . " in line " . __LINE__ . " of file" . __FILE__;
    exit;
}
$data = array();

$show_response = "";
$header_date = "";
$i=0;
while ($row = Sql_fetch_array($result)) {
	$action_command = Sql_Result($row, "action_command");
	
	$show_response .= '<div class="row " style="padding:5px">';
	$show_response .= '<div class="col-md-12">';
	
	$show_response .= '<div class=" col-md-3">Change in ID : '.Sql_Result($row, "id").'<br />by '.Sql_Result($row, "user_name").'<br /> For :'.		    Sql_Result($row, "action_command").'<br />'.Sql_Result($row, "action_date").'</div>';
	
	if(trim($action_command) == "add"){
		$show_response .= '<div class=" col-md-4" >';
		$show_response .= '<img src="rcportal/img/empty.jpg">'; // img -> for old value
		$show_response .= '</div>';
		
		$show_response .= '<div class=" col-md-1">';
		$show_response .= '</div>';
		
		$show_response .= '<div class=" col-md-4" style="background-color:lightgreen; overflow:auto; border-radius:5px;">';
		$show_response .= Sql_Result($row, "new_value"); 
		$show_response .= '</div>';
	} elseif(trim($action_command) == "edit"){
		$show_response .= '<div class=" col-md-4" style="background-color:salmon; overflow:auto; border-radius:5px;" >';
		$show_response .= Sql_Result($row, "old_value");
		$show_response .= '</div>';
		
		$show_response .= '<div class=" col-md-1">';
		$show_response .= '</div>';
		
		$show_response .= '<div class=" col-md-4" style="background-color:lightgreen ; overflow:auto; border-radius:5px;" >';
		$show_response .= Sql_Result($row, "new_value");
		$show_response .= '</div>';
	} elseif(trim($action_command) == "delete"){
		$show_response .= '<div class=" col-md-4" style="background-color:salmon ; overflow:auto; border-radius:5px;" >';
		$show_response .= Sql_Result($row, "old_value");
		$show_response .= '</div>';
		
		$show_response .= '<div class=" col-md-1">';
		$show_response .= '</div>';
		
		$show_response .= '<div class=" col-md-4">';
		$show_response .= '<img src="rcportal/img/empty.jpg">'; // img -> for old value
		$show_response .= '</div>';
	} else {
		$show_response .= '<div class=" col-md-4" style="background-color:salmon;  overflow:auto; border-radius:5px;" >';
		$show_response .= Sql_Result($row, "old_value");
		$show_response .= '</div>';
		
		$show_response .= '<div class=" col-md-1">';
		$show_response .= '</div>';
		
		$show_response .= '<div class=" col-md-4">';
		$show_response .= '<img src="rcportal/img/empty.jpg">'; // img -> for old value
		$show_response .= '</div>';
	}

	
	$show_response .= '</div>';
	$show_response .= '</div>'; 
  	
	
}
Sql_Free_Result($result);

$data['response'] = $show_response;
ClosedDBConnection($cn);
echo json_encode($data);

?>
