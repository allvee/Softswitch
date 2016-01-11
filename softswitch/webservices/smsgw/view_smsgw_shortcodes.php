<?php

include_once "../lib/common.php";
$cn = connectDB();

   $remoteCnQry="select * from tbl_process_db_access where pname='SMSGW'";
   $res = Sql_exec($cn,$remoteCnQry);
   $dt = Sql_fetch_array($res);
 

    $dbtype=$dt['db_type'];
    $Server=$dt['db_server'];
    $UserID=$dt['db_uid'];
    $Password=$dt['db_password'];
    $Database=$dt['db_name'];
    ClosedDBConnection($cn);

 $remoteCn=connectDB();
 $arrayInput = array();


//$res = Sql_exec($cn,$remoteCnQry);
//$dt = Sql_fetch_array($res);
$query = "select * FROM shortcode";
$result = Sql_exec($remoteCn, $query);
if (!$result) {
    echo "err+" . $query . " in line " . __LINE__ . " of file" . __FILE__;
    exit;
}
$data = array();
$i=0;
while ($row = Sql_fetch_array($result)) {
    $j=0;
    $data[$i][$j++] = Sql_Result($row, "shortcode");
    $data[$i][$j++] = Sql_Result($row, "ErrorSMS");
    $data[$i][$j++] = Sql_Result($row, "DefaultKeyword");
   
  
    $data[$i][$j++] = '<span  onclick="edit_input_form_smsgw_shortcodes(this,'."'".Sql_Result($row, "shortcode")."'".'); return false;"  > &nbsp;<img style="position: relative; cursor: pointer; top: 4px" width="16" height="16" border="0" src="rcportal/img/pen.png" >
</span>'.'<span    " onclick="delete_smsgw_shortcodes(this,'."'".Sql_Result($row, "shortcode")."'".'); return false;"  > &nbsp;<img style="position: relative; cursor: pointer; top: 4px" width="16" height="16" border="0" src="rcportal/img/cancel.png" >
</span>';

    $i++;
}
Sql_Free_Result($result);
ClosedDBConnection($remoteCn);
echo json_encode($data);

?>
