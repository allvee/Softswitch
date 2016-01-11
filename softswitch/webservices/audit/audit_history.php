<?php

include_once "../lib/common.php";
$cn = connectDB();
$query = "SELECT `id`, 
				`user_id`, 
				`user_name`, 
				`action_command`, 
				`pname`, 
				`page_name`, 
				`table_name`, 
				`primary_key_column`, 
				`action_date`, 
				`action_time`, 
				`rowvalue`, 
				`comments`, 
				`ip_address`, 
				`browser`, 
				`referer`
		FROM 
			`tbl_audit_trail`  
		ORDER BY `action_date` Desc, action_time Desc ";

$result = Sql_exec($cn, $query);
if (!$result) {
    echo "err+" . $query . " in line " . __LINE__ . " of file" . __FILE__;
    exit;
}

$data = array();

$show_response = "";
$header_date = "";
$i = 0;
while ($row = Sql_fetch_array($result)) {
      $j = 0;
	  
//	  $data[$i][$j++] = '<input onclick="check_audit_trail(this,'.'"'.Sql_Result($row, "id")."'".');return false;" type="checkbox" id="row_'.($i+1).'"/>';
	  $data[$i][$j++] = '<input id="row_'.Sql_Result($row, "id").'" type="checkbox"/>';
	  $id = Sql_Result($row, "id");
	  $comments = Sql_Result($row, "comments");
	  $action_time = Sql_Result($row, "action_time");
	  $user_name = Sql_Result($row, "user_name");
	  
	  $str = "";
	  $str .= '<div class="row"><div class="row col-md-3">'. $comments.'</div><div class="row col-md-3"></div><div class="row col-md-3"></div><div class="row col-md-3"></div></div>';
	  $str .='<div class="row"><div class="row col-md-3">'.$id." By ". $user_name .",".$action_time.'</div><div class="row col-md-3"></div><div class="row col-md-3"></div><div class="row col-md-3"></div></div>';
	  $data[$i][$j++] = $str;
	  $data[$i][$j++] = date("l,M d,Y",strtotime($row['action_date']));
/*	  $com_str = "";
	  $com_str = Sql_Result($row, "rowvalue"); 
	  
	  $str_to_json_array = json_decode($com_str,true);
	  ksort($str_to_json_array,SORT_NATURAL);
	  $str_to_json_array = json_encode($str_to_json_array,JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT); */
	//  $data[$i][$j++] = '<pre>'.$str_to_json_array.'</pre>';
	  $i++;
	              
}
Sql_Free_Result($result);

ClosedDBConnection($cn);
echo json_encode($data,JSON_UNESCAPED_SLASHES);

?>
