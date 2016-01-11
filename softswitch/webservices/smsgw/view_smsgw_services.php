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
$query = "select * FROM keyword";
$result = Sql_exec($remoteCn, $query);
if (!$result) {
    echo "err+" . $query . " in line " . __LINE__ . " of file" . __FILE__;
    exit;
}
$data = array();
$i=0;
while ($row = Sql_fetch_array($result)) {
    $j=0;
    $data[$i][$j++] = Sql_Result($row, "ShortCode");
    $data[$i][$j++] = Sql_Result($row, "keyword");
    $data[$i][$j++] = Sql_Result($row, "SMSText");
    $data[$i][$j++] = Sql_Result($row, "SrcType");
    $data[$i][$j++] = Sql_Result($row, "URL");
    $data[$i][$j++] = Sql_Result($row, "Status");
    $data[$i][$j++] = '<button style="background-color: blue; margin: 2px;" onclick="edit_input_form_smsgw_keyword(this,'."'".Sql_Result($row, "id")."'".'); return false;" class="btn btn-primary" type="button"> <i class="fa fa-pencil-square-o"></i> Edit
</button>'.'<button style="background-color: #FF0000;margin: 2px;   " onclick="delete_smsgw_keyword(this,'."'".Sql_Result($row, "id")."'".'); return false;" class="btn btn-primary" type="button"> <i class="fa fa-times"></i> Delete
</button>';
    $i++;
}
Sql_Free_Result($result);
ClosedDBConnection($remoteCn);
echo json_encode($data);

?>
