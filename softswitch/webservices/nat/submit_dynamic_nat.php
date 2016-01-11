<?php

header('Access-Control-Allow-Origin: *');
session_start();
require_once "../lib/common.php";

require_once "../lib/filewriter.php";
$cn = connectDB();

$last_updated = date('Y-m-d H:i:s');
$last_updated_by = $_SESSION["UserID"];

if (isset($_REQUEST['info'])) {
    $data = $_REQUEST['info'];
    $action = $data['action'];
    $action_id = $data['action_id'];
} else if (isset($_POST) && isset($_POST['action']) && isset($_POST['action_id'])) {
    $action = mysql_real_escape_string(htmlspecialchars($_POST['action']));
    $action_id = mysql_real_escape_string(htmlspecialchars($_POST['action_id']));
}

$is_error = 0;
$err_field = array();
$count = 0;
$seperator = "";

if ($action == "insert") {
    $qry = "insert into tbl_nat_dynamic (last_updated, last_updated_by, ";
    $values = "'$last_updated','$last_updated_by',";
} elseif ($action == "update") {
    $qry = "update tbl_nat_dynamic set last_updated='$last_updated', last_updated_by='$last_updated_by',";
} elseif ($action == "delete") {
    $qry = "update tbl_nat_dynamic set is_active='inactive',last_updated='$last_updated', last_updated_by='$last_updated_by' where is_active='active' and id='$action_id'";
}

foreach ($_POST as $pname => $pvalue) {
    $pname = mysql_real_escape_string(htmlspecialchars(trim($pname)));
    $$pname = mysql_real_escape_string(htmlspecialchars(trim($pvalue)));

    if (!($pname == "action" || $pname == "action_id")) {
        if ($count > 0) {
            $seperator = ",";
        }

        if ($action == "insert") {
            $qry .= $seperator . $pname;
            $values .= $seperator . "'" . $$pname . "'";
        } elseif ($action == "update") {
            $qry .= $seperator . " " . $pname . "='" . $$pname . "'";
        }
        $count++;
    }
}

if ($action == "insert") {
    $qry .= ") values (" . $values . ")";
} elseif ($action == "update") {
    $qry .= "  where id = '$action_id'";
}



try {
    $res = Sql_exec($cn, $qry);
} catch (Exception $e) {
    $is_error = 1;
    array_push($err_field, $qry);
}
if ($is_error == 0) {
    $is_error = file_writer_nat($cn);
}
ClosedDBConnection($cn);

echo $is_error;
