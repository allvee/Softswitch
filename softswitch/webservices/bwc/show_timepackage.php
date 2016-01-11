<?php
//session_start();
header('Access-Control-Allow-Origin: *');
require_once "../lib/common.php";
//require_once "../Lib/filewriter.php";



//print_r($info);
//print_r($_SESSION);
//exit;
//
$cn = connectDB();
$qry = "select * from `bwc_timepackageinfo` where `is_active`='active'";
$rs = Sql_exec($cn,$qry);
$data = array();
$i=0;
while($row = Sql_fetch_array($rs)){

    $j=0;
    $data[$i][$j++] = Sql_Result($row, "packageName");
      $data[$i][$j++] = Sql_Result($row, "startTime");
    $data[$i][$j++] = Sql_Result($row, "endTime");
    $data[$i][$j++] = Sql_Result($row, "days");
    $data[$i][$j++] = Sql_Result($row, "upLoad");
    $data[$i][$j++] = Sql_Result($row, "downLoad");

    $data[$i][$j++] = '<span onclick="edit_input_form_bwc_timepackage(this,'."'".Sql_Result($row, "packageId")."'".'); return false;">&nbsp;<img style="position: relative; cursor: pointer; top: 4px" width="16" height="16" border="0" src="rcportal/img/pen.png" ></span>'.'&nbsp&nbsp'.'<span onclick="delete_bwc_timepackage(this,'."'".Sql_Result($row, "id")."'".'); return false;">&nbsp;<img style="position: relative; cursor: pointer; top: 4px" width="16" height="16" border="0" src="rcportal/img/cancel.png" ></span>';
    /*  $data[$i][$j++] = '<button style="background-color: blue; margin: 2px;" onclick="edit_input_form_bwc_group(this,' . "'" . Sql_Result($row, "id") . "'" . '); return false;" class="btn btn-primary" type="button"> <i class="fa fa-pencil-square-o"></i> Edit
  </button>' . '<button style="background-color: #FF0000;margin: 2px;   " onclick="delete_bwc_group(this,' . "'" . Sql_Result($row, "id") . "'" . '); return false;" class="btn btn-primary" type="button"> <i class="fa fa-times"></i> Delete
  </button>';*/
    $i++;
}



echo json_encode($data);
ClosedDBConnection($cn);


?>