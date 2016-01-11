<?php
/**
 * Created by PhpStorm.
 * User: Plabon Dutta
 * Date: 09-Jul-15
 * Time: 3:16 PM
 */


include_once "../lib/config.php";


$file_name = $dir_softswitch_ippbx_config . "servers.ini";

$line = file($file_name);
$latest_line = count($line) - 1;


/*print_r($line);
exit;*/

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
        $data[$i][$j++] = $arr[8];
        $data[$i][$j++] = $arr[9];
        $data[$i][$j++] = $arr[10];
        $data[$i][$j++] = $arr[11];
        $data[$i][$j++] = $arr[12];
        $data[$i][$j++] = $arr[13];
        $data[$i][$j++] = $arr[14];
        $data[$i][$j++] = $arr[15];
        $i++;
    }

    // }

}

//fclose($fl);

echo json_encode($data);


?>