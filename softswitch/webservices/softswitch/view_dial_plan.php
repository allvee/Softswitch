<?php

/*include_once "../lib/common.php";
$cn = connectDB();
$arrayInput = array();
$query = "select id,name_of_context,ano_pattern,bno_pattern,destination_context from tbl_ippbx_dialplan where is_active='active'";
$result = Sql_exec($cn, $query);
if (!$result) {
    echo "err+" . $query . " in line " . __LINE__ . " of file" . __FILE__;
    exit;
}
$data = array();
$i=0;
while ($row = Sql_fetch_array($result)) {
    $j=0;
    $data[$i][$j++] = Sql_Result($row, "name_of_context");
	$data[$i][$j++] = Sql_Result($row, "ano_pattern");
    $data[$i][$j++] = Sql_Result($row, "bno_pattern");
    $data[$i][$j++] = Sql_Result($row, "destination_context");

    $data[$i][$j++] = '<span onclick="edit_input_form_dialplan_info(this,\'' . Sql_Result($row, "id") . '\'); return false;">&nbsp;<img style="position: relative; cursor: pointer; top: 4px" width="16" height="16" border="0" src="rcportal/img/pen.png" ></span>'
        . '&nbsp&nbsp' . '<span onclick="delete_dialplan_info(this,' . Sql_Result($row, "id") . '); return false;">&nbsp;<img style="position: relative; cursor: pointer; top: 4px" width="16" height="16" border="0" src="rcportal/img/cancel.png" ></span>';



    $i++;
}
Sql_Free_Result($result);
ClosedDBConnection($cn);
echo json_encode($data);*/



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





?>
