<?php

include_once "../lib/common.php";
$cn = connectDB();
$arrayInput = array();
$query = "select `id`,`inbound`,`anoMax`,`anoMin`,`bnoMax`,`bnoMin`,`outbound` from `soft_dial_plan` where `active`='active'";
$result = Sql_exec($cn, $query);
if (!$result) {
    echo "err+" . $query . " in line " . __LINE__ . " of file" . __FILE__;
    exit;
}
$data = array();
$i=0;
while ($row = Sql_fetch_array($result)) {
    $j=0;
	$data[$i][$j++] = Sql_Result($row, "id");
    $data[$i][$j++] = Sql_Result($row, "inbound");
	$data[$i][$j++] = Sql_Result($row, "anoMax");
    $data[$i][$j++] = Sql_Result($row, "anoMin");
    $data[$i][$j++] = Sql_Result($row, "bnoMax");
	$data[$i][$j++] = Sql_Result($row, "bnoMin");
    $data[$i][$j++] = Sql_Result($row, "outbound");


	
	 $info = '' . Sql_Result($row, "id") . '|' . Sql_Result($row, "inbound") . '|' . Sql_Result($row, "anoMax") . '|' . Sql_Result($row, "anoMin") . '|' . Sql_Result($row, "bnoMax")  . '|' . Sql_Result($row, "bnoMin") . '|' . Sql_Result($row, "outbound") ;

    $data[$i][$j++] = '<span onclick="edit_soft_dialPlan(this,\'' . Sql_Result($row, "id") . '\'); return false;">&nbsp;<img style="position: relative; cursor: pointer; top: 4px" width="16" height="16" border="0" src="softswitch/img/pen.png" ></span>'
        . '&nbsp&nbsp' . '<span onclick="delete_soft_dialplan(this,' . Sql_Result($row, "id") . '); return false;">&nbsp;<img style="position: relative; cursor: pointer; top: 4px" width="16" height="16" border="0" src="softswitch/img/cancel.png" ></span>';




    $i++;
}
Sql_Free_Result($result);
ClosedDBConnection($cn);
echo json_encode($data);


/*
include_once "../lib/config.php";


$file_name = $dir_softswitch_ippbx_config . "dialplan.ini";

$lines = file($file_name);
$latest_line = count($line) - 1;


$data = array();

if (count($lines)>0) {


    //
    $i = 0;
    $j = 0;
    $context = "";
    foreach ($lines as $index => $val) {


        if(preg_match("/\[.*\]/",$val)){

            //$data[$i][$j++] = $val;
            $context = $val;
           // echo $val."\n";

        }else{
            $j=0;
            //$arr = preg_split("/[\s]+/", $val);
            $arr = explode(" ", $val);
            $data[$i][$j++] = htmlspecialchars($context);
            $data[$i][$j++] = $arr[0];
            $data[$i][$j++] = $arr[1];
            $data[$i][$j++] = $arr[2];
            $data[$i][$j++] = '<span onclick="edit_input_form_dialplan_info(this,\'' . Sql_Result($row, "id") . '\'); return false;">&nbsp;<img style="position: relative; cursor: pointer; top: 4px" width="16" height="16" border="0" src="softswitch/img/pen.png" ></span>'
                . '&nbsp&nbsp' . '<span onclick="delete_dialplan_info(this,' . Sql_Result($row, "id") . '); return false;">&nbsp;<img style="position: relative; cursor: pointer; top: 4px" width="16" height="16" border="0" src="softswitch/img/cancel.png" ></span>';
$i++;
        }


    }


}

//fclose($fl);

echo json_encode($data);




*/
?>
