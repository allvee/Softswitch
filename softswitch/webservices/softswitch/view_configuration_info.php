    <?php
    /*/**
     * Created by PhpStorm.
     * User: Nazibul
     * Date: 5/19/2015
     * Time: 6:20 PM
     */
    /*
    include_once "../lib/common.php";
    $cn = connectDB();
    $arrayInput = array();
    $query = "select * from tbl_ippbx_configuration where is_active='active'";
    $result = Sql_exec($cn, $query);
    if (!$result) {
        echo "err+" . $query . " in line " . __LINE__ . " of file" . __FILE__;
        exit;
    }
    $data = array();
    $i = 0;
    while ($row = Sql_fetch_array($result)) {

        $j = 0;
        $data[$i][$j++] = Sql_Result($row, "udp_bind_ip");
        $data[$i][$j++] = Sql_Result($row, "udp_signaling_port");
        $data[$i][$j++] = Sql_Result($row, "udp_signaling_protocol");
        $data[$i][$j++] = Sql_Result($row, "udp_media_port");
        $data[$i][$j++] = Sql_Result($row, "udp_media_protocol");
        $data[$i][$j++] = Sql_Result($row, "tcp_bind_ip");
        $data[$i][$j++] = Sql_Result($row, "tcp_signaling_port");
        $data[$i][$j++] = Sql_Result($row, "tcp_signaling_protocol");
        $data[$i][$j++] = Sql_Result($row, "tcp_media_port");
        $data[$i][$j++] = Sql_Result($row, "tcp_media_protocol");
        $data[$i][$j++] = Sql_Result($row, "log_level");
        $data[$i][$j++] = Sql_Result($row, "log_destination");
        $data[$i][$j++] = Sql_Result($row, "rcportal_control_udp_port");
        $data[$i][$j++] = Sql_Result($row, "log_tcp_port");


        $data[$i][$j++] = '<span onclick="edit_soft_config(this,\'' . Sql_Result($row, "id") . '\'); return false;">&nbsp;<img style="position: relative; cursor: pointer; top: 4px" width="16" height="16" border="0" src="rcportal/img/pen.png" ></span>'
            . '&nbsp&nbsp' . '<span onclick="delete_soft_config(this,' . Sql_Result($row, "id") . '); return false;">&nbsp;<img style="position: relative; cursor: pointer; top: 4px" width="16" height="16" border="0" src="rcportal/img/cancel.png" ></span>';


        $i++;
    }
    Sql_Free_Result($result);
    ClosedDBConnection($cn);
    echo json_encode($data);
    */

    include_once "../lib/config.php";


    $file_name = $dir_softswitch_ippbx_config."conf.ini";

    $line = file($file_name);

    $map = '';


    if ($line) {
        $map = array();
        foreach($line as $i => $val ){
        //foreach ($line as $row) {
            $arr = explode(" ", $val);

            if ($i==0) {

                $map['udp_bind_ip'] = $arr[0];
                $map['udp_signaling_port'] = $arr[1];
                $map['udp_signaling_protocol'] = $arr[2];
                $map['udp_media_port'] = $arr[3];
                $map['udp_media_protocol'] = $arr[4];

            }
            else if($i==1) {

                $map['tcp_bind_ip'] = $arr[0];
                $map['tcp_signaling_port'] = $arr[1];
                $map['tcp_signaling_protocol'] = $arr[2];
                $map['tcp_media_port'] = $arr[3];
                $map['tcp_media_protocol'] = $arr[4];

            }
            else if($i==2) {

                $map['log_level'] = $arr[0];
                $map['log_destination'] = $arr[1];

            }
            else if($i==3) {

                $map['log_tcp_port'] = $arr[0];
                $map['rcportal_control_udp_port'] = $arr[1];
            }

        }
        $status = true;
    } else {
        $status = false;
    }
    $return_data = array('status' => $status, 'map' => $map);
    echo json_encode($return_data);







    ?>

