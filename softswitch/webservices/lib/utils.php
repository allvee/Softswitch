<?php
//mysql return to json

function formatJSON($result)
{
    $str = "[";
    $numRows = 0;
    while ($row = mysql_fetch_array($result)) {
        if ($numRows > 0)
            $str = $str . ", ";
        $numRows++;
        $n = mysql_num_fields($result);
        for ($i = 0; $i < $n; $i++) {
            $fld = mysql_field_name($result, $i);
            $val = addslashes($row[$fld]);
            $val = str_replace("\t", "", $val);
            $val = str_replace("'", "\'", $val);
            $val = str_replace("\r\n", "", $val);

            if ($i == 0)
                $str = $str . "{\"$fld\":\"$val\"";
            else
                $str = $str . ", \"$fld\":\"$val\"";
        }
        $str = $str . "}\r\n";
    }

    $str = $str . "]";
    return $str;
}

//json to add query @mahfooz
function jsonDataToQueryString($data)
{

    $field_string = "";
    $value_string = "";
    foreach ($data as $key => $val) {

        $field_string .= $key . ',';
        $value_string .= "'" . mysql_real_escape_string($val) . "',";
    }

    return array('fields' => substr($field_string, 0, -1), 'values' => substr($value_string, 0, -1));
}

//json to edit query @mahfooz

function jsonEditQuery($data)
{
    $string = "";
    foreach ($data as $key => $val) {
        $string .= "{$key} = '" . mysql_real_escape_string($val) . "',";
    }
    return substr($string, 0, -1);
}

function pr($data)
{
    print_r($data);
}

/* ===========================
 * 'uid' 'role'
 * ===========================*/
function checkSession()
{
    if (!isset($_SESSION['UserType']) || !isset($_SESSION['UserID'])) {
        die('no user info found');
    }
}


/* ====================================================================================
 * log checking Database
 *
 * @param $step_name user defined name
 * @param $step_response response coder want to save
 *
 * @param $step_id enum field has specific values
 * check_Session
 * send_flexi_load
 * send_flexi_load_file
 * send_flexi_load_api
 * scratch_card_recharge
 * merchant_api
 * add_reseller_fund
 * resend_old_dhakagate_sc
 * scratch_card_inquiry
 *
 * @param $parent_id value of parent used for identifying call flow
 * ===================================================================================== */
function addLogToDB($step_name, $step_response, $step_id, $parent_id = 0)
{
    date_default_timezone_set("Asia/Dhaka");
    $create_date = date('Y-m-d H:i:s');
    $step_response = str_ireplace("'", '+', $step_response);
    $query = "INSERT INTO debug_log_monitor ( step_name, step_response, step_id, parent_id, create_date ) VALUES ( '$step_name', '$step_response', '$step_id', '$parent_id', '$create_date' ) ";

    $cn = connectDB();
    $result = Sql_exec_continue($cn, $query);

    if ($result) {
        return Sql_insert_id($cn);
    } else {
        return 0;
    }
}

/* ===============================================================================
 * gives role number
 * =============================================================================== */
function getLayoutId($role)
{
    if (strtolower($role) == 'admin') {
        return 7;
    } else if (strtolower($role) == 'partner') {
        return 6;
    } else if (strtolower($role) == 'dealer') {
        return 5;
    } else if (strtolower($role) == 'distributor') {
        return 4;
    } else if (strtolower($role) == 'retailer') {
        return 3;
    } else if (strtolower($role) == 'user') {
        return 2;
    } else {
        return 1;
    }
}


/* ===============================================================================
 * @param $roleArray array of role which can access function
 *
 * @return true for successful role else die with error code
 * =============================================================================== */
function getPrivilege($roleArray)
{
    if (isset($_SESSION['role'])) {

        foreach ($roleArray as $role) {
            if ((getLayoutId($_SESSION['role'])) == getLayoutId($role)) {

                return true;
            }
        }
    }
    die("your are not eligible for the function");
}