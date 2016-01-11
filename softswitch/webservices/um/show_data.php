<?php
require_once "../lib/common.php";
$cn = connectDB();

	$is_error = 0;
	$data = "";
	
	$tbl_name = mysql_real_escape_string(htmlspecialchars($_REQUEST['tbl_name']));
	$col_no = mysql_real_escape_string(htmlspecialchars($_REQUEST['col_no']));
	$cols = mysql_real_escape_string(htmlspecialchars($_REQUEST['cols']));
	$is_active = mysql_real_escape_string(htmlspecialchars($_REQUEST['is_active']));
	
	$attributes = explode(",",$cols);
	
	$qry = "";
	$qry .= "select ";
	for($i=0; $i<$col_no; $i++){
		$qry .= $attributes[$i];
		if($i==($col_no-1)){
			break;
			}
		$qry .=", ";
	}
		
	$qry .= " from ".$tbl_name;
	
	if($is_active==1){
		$qry .= " where is_active='active'";
	}
	
	$data .= "<tr class='h'>";
	for($i=0; $i<$col_no; $i++){
		$data .= "<th>".$attributes[$i]."</th>";
	}
	$data .= "</tr>";
	
	$res = Sql_exec($cn,$qry);
	
	$n=mysql_num_rows($res);
	
	if($n==0){
		$row = $col_no;
		$data .= "<tr>";
		$data .= "<td style='text-align:center;' colspan='".$row."' class='e'>No data available</td>";
		$data .= "</tr>";
		
	}
	
	while($dt = Sql_fetch_array($res)){
		$data .= "<tr>";
		
		for($i=0; $i<$col_no; $i++){
			$data .= "<td class='e'>".$dt[$attributes[$i]]."</td>";
		}
		$data .= "</tr>";
		
		}
ClosedDBConnection($cn);

echo $data;

?>