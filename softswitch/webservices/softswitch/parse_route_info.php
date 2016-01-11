<?php
/**
 * Created by PhpStorm.
 * User: Plabon Dutta
 * Date: 09-Jul-15
 * Time: 3:16 PM
 */
/*

    include_once "../lib/config.php";


    $file_name = $dir_softswitch_ippbx_config . "routes.ini";

    $line = file($file_name);
    $latest_line = count($line) - 1;



    if ($line) {
        $data = array();
        //
        $i = 0;
        foreach ($line as $index => $val) {
            //$fl = fopen($file_name,"r");
          // while (!feof($fl)) {
                $j = 0;
                $arr = explode(" ", $val);
                $data[$i][$j++] = $arr[0];
                $data[$i][$j++] = $arr[1];
                $data[$i][$j++] = $arr[2];
                $data[$i][$j++] = $arr[3];
                $data[$i][$j++] = $arr[4];
                $data[$i][$j++] = $arr[5];
                $data[$i][$j++] = $arr[6];
                $data[$i][$j++] = $arr[7];
		  $data[$i][$j++] = '<span onclick="edit_input_form_route_info(this,\'' . $i . '\'); return false;">&nbsp;<img style="position: relative; cursor: pointer; top: 4px" width="16" height="16" border="0" src="softswitch/img/pen.png" ></span>'
            . '&nbsp&nbsp' . '<span onclick="delete_route_info(this,\'' . $i . '\'); return false;">&nbsp;<img style="position: relative; cursor: pointer; top: 4px" width="16" height="16" border="0" src="softswitch/img/cancel.png" ></span>';
                $i++;
            }

       // }

    }

//fclose($fl);

echo json_encode($data);
*/




include_once "../lib/common.php";
$cn = connectDB();
$arrayInput = array();
$query = "SELECT `id`,`source_ip`,`source_port`,`source_protocol`,`destination_ip`,`destination_port`,`destination_protocol`,`route_type`,`context_name` FROM `tbl_ippbx_route` WHERE `is_active`='active'";
$result = Sql_exec($cn, $query);
if (!$result) {
    echo "err+" . $query . " in line " . __LINE__ . " of file" . __FILE__;
    exit;
}
$data = array();
$i = 0;
while ($row = Sql_fetch_array($result)) {
    $j = 0;
$id=Sql_Result($row, "id");
    $data[$i][$j++] = Sql_Result($row, "id");
    $data[$i][$j++] = Sql_Result($row, "source_ip");
    $data[$i][$j++] = Sql_Result($row, "source_port");
    $data[$i][$j++] = Sql_Result($row, "source_protocol");
	$data[$i][$j++] = Sql_Result($row, "destination_ip");
    $data[$i][$j++] = Sql_Result($row, "destination_port");
    $data[$i][$j++] = Sql_Result($row, "destination_protocol");
    $data[$i][$j++] = Sql_Result($row, "route_type");
    $data[$i][$j++] = Sql_Result($row, "context_name");


/*
    $info = '' . Sql_Result($row, "id") . '|' . Sql_Result($row, "name") . '|' . Sql_Result($row, "ip_address") . '|' . Sql_Result($row, "port") . '|' . Sql_Result($row, "ep_type") . '|' . Sql_Result($row, "user_name")  . '|' . Sql_Result($row, "password") . '|' . Sql_Result($row, "type") ;
*/

     $data[$i][$j++] = '<span onclick="edit_input_form_route_info(this,\'' . $id . '\'); return false;">&nbsp;<img style="position: relative; cursor: pointer; top: 4px" width="16" height="16" border="0" src="softswitch/img/pen.png" ></span>'
            . '&nbsp&nbsp' . '<span onclick="delete_route_info(this,\'' . $id . '\'); return false;">&nbsp;<img style="position: relative; cursor: pointer; top: 4px" width="16" height="16" border="0" src="softswitch/img/cancel.png" ></span>';


    $i++;
}
Sql_Free_Result($result);
ClosedDBConnection($cn);
echo json_encode($data);


?>