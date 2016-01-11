<?php
/**
 * Created by PhpStorm.
 * User: Talemul
 * Date: 5/12/2015
 * Time: 6:53 PM
 */
include_once "../lib/common.php";
$cn = connectDB();
$lines = file($dir);
$row_count = 0;
$ip = array();
$host_name= array();
$hardware= array();
$start= array();
$end=array();

foreach (array_values($lines) AS $line){
    $e_line_arr = explode(" ", $line );
    if ($e_line_arr[0] == "lease"){
        $subnet = $e_line_arr[1];
        $subnet_parts = explode(".",$subnet);
        $new_subnet = $subnet_parts[0].".".$subnet_parts[1].".".$subnet_parts[2];
        if($search_ip !=""){
            if(($new_subnet == $search_subnet) && ($search_ip == $e_line_arr[1])){
                $row_count++;
                $ip[$row_count] = "<td>";
                $ip[$row_count] .= $e_line_arr[1] . "</td>";
            }
        } else {
            if($new_subnet == $search_subnet){
                $row_count++;
                $ip[$row_count] = "<td>";
                $ip[$row_count] .= $e_line_arr[1] . "</td>";
            }
        }
    }

    if ($e_line_arr[2] == "starts"){
        $start[$row_count] = "<td>".str_replace(";","",$e_line_arr[4])." ".str_replace(";","",$e_line_arr[5])."</td>";
    }
    if ($e_line_arr[2] == "ends"){
        $end[$row_count] = "<td>".str_replace(";","",$e_line_arr[4])." ".str_replace(";","",$e_line_arr[5])."</td>";
    }
    if ($e_line_arr[2] == "client-hostname"){
        $host_name[$row_count] = "<td>".str_replace(";","",$e_line_arr[3])."</td>";
    }
    if ($e_line_arr[2] == "hardware"){
        $hardware[$row_count] = "<td>".str_replace('"','',str_replace(";","",$e_line_arr[4]))."</td>";
    }
}

for($i=1;$i<=$row_count;$i++){
    if($start[$i] == ""){
        $start[$i] = "<td></td>";
    }
    if($end[$i] == ""){
        $end[$i] = "<td></td>";
    }
    if($host_name[$i] == ""){
        $host_name[$i] = "<td></td>";
    }
    if($hardware[$i] == ""){
        $hardware[$i] = "<td></td>";
    }

    echo '<tr>';
    echo $ip[$i]."".$host_name[$i]."".$hardware[$i]."".$start[$i]."".$end[$i];
    echo '<td><input class="release" type="checkbox" id="release-'.$i.'" name="release-'.$i.'" value="'.$i.'" />';
    echo '</tr>';

}
while ($row = Sql_fetch_array($result)) {
    $j=0;
    $data[$i][$j++] = Sql_Result($row, "subnet");
    $data[$i][$j++] = Sql_Result($row, "net_mask");
    $data[$i][$j++] = Sql_Result($row, "gateway");

    $data[$i][$j++] = Sql_Result($row, "domain_name");
    $data[$i][$j++] = Sql_Result($row, "domain_name_server1");
    $data[$i][$j++] = Sql_Result($row, "netbios_name_server");

    $data[$i][$j++] = Sql_Result($row, "interface");
    $data[$i][$j++] = Sql_Result($row, "max_lease_time");

    $data[$i][$j++] =  '<span  onclick="edit_input_form_dhcp_lease(this,'."'".Sql_Result($row, "id")."'".'); return false;"  > &nbsp;<img style="position: relative; cursor: pointer; top: 4px" width="16" height="16" border="0" src="rcportal/img/pen.png" >
</span>'.'<span    " onclick="delete_dhcp_lease(this,'."'".Sql_Result($row, "id")."'".'); return false;"  > &nbsp;<img style="position: relative; cursor: pointer; top: 4px" width="16" height="16" border="0" src="rcportal/img/cancel.png" >
</span>';

    $i++;
}
Sql_Free_Result($result);
ClosedDBConnection($cn);
echo json_encode($data);