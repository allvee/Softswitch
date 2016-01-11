<?php

include_once "../lib/common.php";
$cn = connectDB();

$query = "SELECT DISTINCT `table_name`,`page_name`
		  FROM `tbl_audit_trail` 
		  ORDER BY `table_name` ASC";

$result = Sql_exec($cn, $query);
if (!$result) {
    echo "err+" . $query . " in line " . __LINE__ . " of file" . __FILE__;
    exit;
}

$options = '<option value="">--Select--</option>';
while ($row = Sql_fetch_array($result)) {
      $tbl_name = Sql_Result($row, "table_name");
	  $tbl_name = Sql_Result($row, "page_name");
	  $options .='<option value="'. $tbl_name .'">'. $tbl_name .'</option>';
}
Sql_Free_Result($result);
ClosedDBConnection($cn);
echo $options;

?>
