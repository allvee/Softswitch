<?php

include_once "../lib/common.php";

$info = $_POST['info'];

$cn = connectDB();

$id_1 = mysql_real_escape_string(htmlspecialchars($info['id_1']));
$id_2 = mysql_real_escape_string(htmlspecialchars($info['id_2']));
$query = "SELECT  
				`rowvalue` 
		  FROM 
			`tbl_audit_trail`  
		  WHERE (`id` = '$id_1' OR `id` = '$id_2')
		  ORDER BY `action_date` Desc ";

$result = Sql_exec($cn, $query);
if (!$result) {
    echo "err+" . $query . " in line " . __LINE__ . " of file" . __FILE__;
    exit;
}

$data = array();

$show_response = "";
$header_date = "";
$i = 0;

$data_rows = array();
while ($row = Sql_fetch_array($result)) {
      $com_str = Sql_Result($row, "rowvalue");
	  $str_to_json_array = json_decode($com_str,true);
	  ksort($str_to_json_array,SORT_NATURAL);
	  $str = json_encode($str_to_json_array,JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT);
	  $data_rows[$i++] = $str;
	              
}

$original = "";
$changed = "";
if(isset($data_rows[0])&& $data_rows[0] != "") $original = $data_rows[0];
if(isset($data_rows[1])&& $data_rows[1] != "") $changed = $data_rows[1];

$str_output = '<table class="table table-striped table-bordered table-hover responsive">
        <thead>
        <tr>
            <th>Original</th>
            <th>Changed</th>
            <th>Difference</th>
        </tr>
        </thead>
        <tbody>
        <tr id="compare_row">
            <td class="original"><pre id="original_txt" style="background-color: palevioletred;font-size: medium;">'.$original.'</pre>'.'</td>
            <td class="changed"><pre id="changed_txt" style="background-color: mediumseagreen;font-size: medium;">'.$changed.'</pre>'.'</td>
            <td class="diff"><pre id="diff_txt" style="background-color: darkgrey; color: windowtext;font-size: medium;"></pre></td>
        </tr>
        </tbody>
    </table>';


Sql_Free_Result($result);

ClosedDBConnection($cn);
echo $str_output

?>
