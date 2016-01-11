<?php

include_once "../lib/common.php";
$cn = connectDB();
$arrayInput = array();
$query = "SELECT * FROM ugw_version.backup_history where is_active='active'";
$result = Sql_exec($cn, $query);
if (!$result) {
    echo "err+" . $query . " in line " . __LINE__ . " of file" . __FILE__;
    exit;
}
$data = array();
$i = 0;
while ($row = Sql_fetch_array($result)) {
    $j = 0;
    $data[$i][$j++] = Sql_Result($row, "backup_name");
    $data[$i][$j++] = Sql_Result($row, "version_name");

    $options = '';
    $app = Sql_Result($row, "app");

    if ($app == '1') {
        $options .= 'app';
    }
    $webservice = Sql_Result($row, "webservice");
    if ($webservice == '1') {
        if (trim($options) != '') {
            $options .=',' . 'webservice';
        } else {
            $options .= 'webservice';
        }
    }

    $db = Sql_Result($row, "db");
    if ($db == '1') {
        if (trim($options) != '') {
            $options .=',' . 'db';
        } else {
            $options .= 'db';
        }
    }

    $data[$i][$j++] = $options;
    $data[$i][$j++] = Sql_Result($row, "last_updated");
    $data[$i][$j++] = Sql_Result($row, "last_updated_by");
    
    ///'<span onclick="restore_backup(this,' . "'" . Sql_Result($row, "id") . "'" . '); return false;">&nbsp;<img style="position: relative; cursor: pointer; top: 4px" width="16" height="16" border="0" src="rcportal/img/download.png" ></span>'

    $data[$i][$j++] = '<span onclick="delete_backup_history(this,' . "'" . Sql_Result($row, "id") . "'" . '); return false;">&nbsp;<img style="position: relative; cursor: pointer; top: 4px" width="16" height="16" border="0" src="rcportal/img/cancel.png" ></span>';

    $i++;
}
Sql_Free_Result($result);
ClosedDBConnection($cn);
echo json_encode($data);
?>
