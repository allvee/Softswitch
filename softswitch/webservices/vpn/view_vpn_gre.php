<?php
/**
 * Created by PhpStorm.
 * User: Nazibul
 * Date: 5/5/2015
 * Time: 7:39 PM
 */

include_once "../lib/common.php";
$cn = connectDB();
$arrayInput = array();
$query = "SELECT * FROM tbl_gre WHERE is_active='active'";
$result = Sql_exec($cn, $query);
if (!$result) {
    echo "err+" . $query . " in line " . __LINE__ . " of file" . __FILE__;
    exit;
}
$data = array();
$i = 0;
while ($row = Sql_fetch_array($result)) {
    $j = 0;
    $data[$i][$j++] = Sql_Result($row, "id");
    $data[$i][$j++] = Sql_Result($row, "gre_name");
    $data[$i][$j++] = Sql_Result($row, "peer_outer");
    $data[$i][$j++] = Sql_Result($row, "peer_inner");
    $data[$i][$j++] = Sql_Result($row, "my_inner");

    $info = '' . Sql_Result($row, "id") . '|' . Sql_Result($row, "gre_name") . '|' . Sql_Result($row, "peer_outer") . '|' . Sql_Result($row, "peer_inner") . '|' . Sql_Result($row, "my_inner");

    if (Sql_Result($row, "status") != 'disable') {
        $sts = 'disable';

        $data[$i][$j++] = '<span onclick="edit_input_form_vpn_gre(this,\'' . $info . '\'); return false;">&nbsp;<img style="position: relative; cursor: pointer; top: 4px" width="16" height="16" border="0" src="rcportal/img/pen.png" ></span>'
            . '&nbsp&nbsp' . '<span onclick="active_vpn_gre(this,' . Sql_Result($row, "id") . ',\'' . $sts . '\'); return false;">&nbsp;<img style="position: relative; cursor: pointer; top: 4px" width="16" height="16" border="0" src="rcportal/img/deactive.png" ></span>'
            . '&nbsp&nbsp' . '<span onclick="delete_vpn_gre(this,' . Sql_Result($row, "id") . '); return false;">&nbsp;<img style="position: relative; cursor: pointer; top: 4px" width="16" height="16" border="0" src="rcportal/img/cancel.png" ></span>';

/*
        $data[$i][$j++] = '<button style="background-color: blue; margin: 2px;" onclick="edit_input_form_vpn_gre(this,\'' . $info . '\'); return false;" class="btn btn-primary" type="button"> <i class="fa fa-pencil-square-o"></i> Edit</button>'
            . '<button style="background-color: #c7254e; margin: 2px;   " onclick="active_vpn_gre(this,' . Sql_Result($row, "id") . ',\'' . $sts . '\'); return false;" class="btn btn-success" type="button"> Deactive</button>'
            . '<button style="background-color: #FF0000;margin: 2px;   " onclick="delete_vpn_gre(this,' . Sql_Result($row, "id") . '); return false;" class="btn btn-primary" type="button"> <i class="fa fa-times"></i> Delete</button>';
*/
    } else {
        $sts = 'enable';

        $data[$i][$j++] = '<span onclick="edit_input_form_vpn_gre(this,\'' . $info . '\'); return false;">&nbsp;<img style="position: relative; cursor: pointer; top: 4px" width="16" height="16" border="0" src="rcportal/img/pen.png" ></span>'
            . '&nbsp&nbsp' . '<span onclick="active_vpn_gre(this,' . Sql_Result($row, "id") . ',\'' . $sts . '\'); return false;">&nbsp;<img style="position: relative; cursor: pointer; top: 4px" width="16" height="16" border="0" src="rcportal/img/active.png" ></span>'
            . '&nbsp&nbsp' . '<span onclick="delete_vpn_gre(this,' . Sql_Result($row, "id") . '); return false;">&nbsp;<img style="position: relative; cursor: pointer; top: 4px" width="16" height="16" border="0" src="rcportal/img/cancel.png" ></span>';

/*
        $data[$i][$j++] = '<button style="background-color: blue; margin: 2px;" onclick="edit_input_form_vpn_gre(this,\'' . $info . '\'); return false;" class="btn btn-primary" type="button"> <i class="fa fa-pencil-square-o"></i> Edit</button>'
            . '<button style="background-color: green; margin: 2px;   " onclick="active_vpn_gre(this,' . Sql_Result($row, "id") . ',\'' . $sts . '\'); return false;" class="btn btn-success" type="button"> Active</button>'
            . '<button style="background-color: #FF0000;margin: 2px;   " onclick="delete_vpn_gre(this,' . Sql_Result($row, "id") . '); return false;" class="btn btn-primary" type="button"> <i class="fa fa-times"></i> Delete</button>';
*/
    }

    $i++;
}
Sql_Free_Result($result);
ClosedDBConnection($cn);
echo json_encode($data);

?>