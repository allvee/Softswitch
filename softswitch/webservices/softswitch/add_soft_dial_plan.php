
<?php

/*
    include_once "../lib/common.php";


    $cn = connectDB();

    $action = mysql_real_escape_string(htmlspecialchars($_REQUEST['action']));

    $data_info = isset($_REQUEST['info']) ? $_REQUEST['info'] : 'action';
    if ($data_info != 'action') {
        $action = $data_info['action'];
        $deleted_id = $data_info['action_id'];
    }

    $tbl = "soft_dial_plan";
    $is_error = 0;
    //$last_updated = date('Y-m-d H:i:s');
    //$last_updated_by = $_SESSION["UserID"];

    if ($action != "delete") {
        $soft_inbound_gw = mysql_real_escape_string(htmlspecialchars($_REQUEST['soft_inbound_gw']));
        $soft_ano_max = mysql_real_escape_string(htmlspecialchars($_REQUEST['soft_ano_max']));
        $soft_ano_min = mysql_real_escape_string(htmlspecialchars($_REQUEST['soft_ano_min']));
	 $soft_bno_max = mysql_real_escape_string(htmlspecialchars($_REQUEST['soft_bno_max']));
        $soft_bno_min = mysql_real_escape_string(htmlspecialchars($_REQUEST['soft_bno_min']));
        $soft_outbound_gw = mysql_real_escape_string(htmlspecialchars($_REQUEST['soft_outbound_gw']));
    }

    if ($action == "update") {
        $msg = "Successfully Updated";
        $action_id = mysql_real_escape_string(htmlspecialchars($_REQUEST['action_id']));
        $qry = "update $tbl set `inbound`='$soft_inbound_gw',`anoMax`='$soft_ano_max', `anoMin`='$soft_ano_min', `bnoMax`='$soft_bno_max', `bnoMin`='$soft_bno_min', `outbound`='$soft_outbound_gw'";
        $qry .= " where id='$action_id'";

    } elseif ($action == "delete") {

        $action_id = $deleted_id;
        $qry = "update $tbl set active='inactive'";
        $qry .= " where id='$action_id'";

        $msg = "Successfully Deleted";

    } else {

        $msg = "Successfully Saved";
        $qry = "insert into $tbl (`inbound`,`anoMax`,`anoMin`,`bnoMax`,`bnoMin`,`outbound`,`active`) values
    ('$soft_inbound_gw','$soft_ano_max','$soft_ano_min','$soft_bno_max','$soft_bno_min','$soft_outbound_gw','active')";
    }

    try {
        $res = Sql_exec($cn, $qry);
        $is_error = 0;
    } catch (Exception $e) {
        $is_error = 1;
    }

    ClosedDBConnection($cn);

    if ($is_error == 1) {
        $return_data = array('status' => false, 'message' => 'Submission Failed');
    } else {
        $return_data = array('status' => true, 'message' => $msg);
    }

    echo json_encode($return_data);





*/

//testing


//fetching and merging data from database



    include_once "../lib/common.php";


    $cn = connectDB();

    $action = mysql_real_escape_string(htmlspecialchars($_REQUEST['action']));

    $data_info = isset($_REQUEST['info']) ? $_REQUEST['info'] : 'action';
    if ($data_info != 'action') {
        $action = $data_info['action'];
        $deleted_id = $data_info['action_id'];
    }

    $tbl = "soft_dial_plan";
    $is_error = 0;
    //$last_updated = date('Y-m-d H:i:s');
    //$last_updated_by = $_SESSION["UserID"];
	
        $soft_inbound_gw = mysql_real_escape_string(htmlspecialchars($_REQUEST['soft_inbound_gw']));
        $soft_ano_max = mysql_real_escape_string(htmlspecialchars($_REQUEST['soft_ano_max']));
        $soft_ano_min = mysql_real_escape_string(htmlspecialchars($_REQUEST['soft_ano_min']));
	    $soft_bno_max = mysql_real_escape_string(htmlspecialchars($_REQUEST['soft_bno_max']));
        $soft_bno_min = mysql_real_escape_string(htmlspecialchars($_REQUEST['soft_bno_min']));
        $soft_outbound_gw = mysql_real_escape_string(htmlspecialchars($_REQUEST['soft_outbound_gw']));


    if ($action == "update") {
        $msg = "Successfully Updated";
        $action_id = mysql_real_escape_string(htmlspecialchars($_REQUEST['action_id']));
        $qry = "update $tbl set `inbound`='$soft_inbound_gw',`anoMax`='$soft_ano_max', `anoMin`='$soft_ano_min', `bnoMax`='$soft_bno_max', `bnoMin`='$soft_bno_min', `outbound`='$soft_outbound_gw'";
        $qry .= " where id='$action_id'";

    } elseif ($action == "delete") {

        $action_id = $deleted_id;
        $qry = "update $tbl set active='inactive'";
        $qry .= " where id='$action_id'";

        $msg = "Successfully Deleted";

    } else {

        $msg = "Successfully Saved";
        $qry = "insert into $tbl (`inbound`,`anoMax`,`anoMin`,`bnoMax`,`bnoMin`,`outbound`,`active`) values
    ('$soft_inbound_gw','$soft_ano_max','$soft_ano_min','$soft_bno_max','$soft_bno_min','$soft_outbound_gw','active')";
    }

    try {
        $res = Sql_exec($cn, $qry);
        $is_error = 0;
    } catch (Exception $e) {
        $is_error = 1;
    }


    if ($is_error == 1) {
        $return_data = array('status' => false, 'message' => 'Submission Failed');
    } else {
        $return_data = array('status' => true, 'message' => $msg);
    }

    echo json_encode($return_data);

$qry_inbound="SELECT `ip_address`,`port`,`ep_type`,`user_name`,`password` FROM tbl_softswitch_gateway WHERE `name`='$soft_inbound_gw'";

$qry_outbound="SELECT `ip_address`,`port`,`auth` FROM tbl_softswitch_gateway WHERE `name`='$soft_outbound_gw'";

  $res_inbound = Sql_exec($cn, $qry_inbound);
  $res_outbound= Sql_exec($cn, $qry_outbound);
  $data = array();
  $data1 = array();
  $data2 = array();
 
  $i=0;
  
  while ($row_inbound = Sql_fetch_array($res_inbound)) 
  {

	 $j=0;
        $data[$i][$j++] = Sql_Result($row_inbound, "ep_type");
	 $data[$i][$j++] = Sql_Result($row_inbound, "ip_address");
   	 $data[$i][$j++] = Sql_Result($row_inbound, "port"); 
        $data[$i][$j++] = Sql_Result($row_inbound, "user_name");
	 $data[$i][$j++] = Sql_Result($row_inbound, "password");
   
        $i++;
	  }
   $i=0;
  
    while ($row_outbound = Sql_fetch_array($res_outbound)) 
  {
	$j=0;
	$data1[$i][$j++] = Sql_Result($row_outbound, "ip_address");
       $data1[$i][$j++] = Sql_Result($row_outbound, "port");
	$data1[$i][$j++] = Sql_Result($row_outbound, "auth");

       $i++;
	  }
	  $i=0;$j=0;
	  $data2[$i][$j++] = $soft_ano_max;
   	  $data2[$i][$j++] = $soft_ano_min;
	  $data2[$i][$j++] = $soft_bno_max;
   	  $data2[$i][$j++] = $soft_bno_min;
	 
	  $new_array=array();
  $ii=0;
  $d=0;  $d_d=0;
  $d1=0; $d1_d1=0;
  $d2=0; $d2_d2=0;
  $i=0;  $j=0;
  
while($ii<12){
  
		  if($ii==2||$ii==3||$ii==4||$ii>9){
		  $new_array[$i][$j++]=$data[$d][$d_d++];
		  
		  }
		  if($ii==0||$ii==1||$ii==5){
		  $new_array[$i][$j++]=$data1[$d1][$d1_d1++];
		  
		  }
		  if($ii>5&&$ii<10){
		  $new_array[$i][$j++]=$data2[$d2][$d2_d2++];
		  
		  }

$ii++;
		   }

   // print_r($new_array);   
    ClosedDBConnection($cn);

$file_name = $dir_softswitch_ippbx_config . "servers.ini";
 $file = fopen($file_name, "a");
    fwrite($file, trim($new_array[0][0]) . " ");
    fwrite($file, trim($new_array[0][1]) . " ");
    fwrite($file, trim($new_array[0][2]) . " ");
    fwrite($file, trim($new_array[0][3]) . " ");
    fwrite($file, trim($new_array[0][4]) . " ");
    fwrite($file, trim($new_array[0][5]) . " ");
    fwrite($file, trim($new_array[0][6]) . " ");
    fwrite($file, trim($new_array[0][7]) . " ");
    fwrite($file, trim($new_array[0][8]) . " ");
    fwrite($file, trim($new_array[0][9]) . " ");
    fwrite($file, trim($new_array[0][10]) . " ");
    fwrite($file, trim($new_array[0][11]) . " ");
	fwrite($file, trim("0 -1 1 0") . "\n");
    fclose($file);
 

?>



