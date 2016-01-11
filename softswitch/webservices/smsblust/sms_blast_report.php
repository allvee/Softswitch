<?php
require_once "../lib/common.php";

$cn = connectDB();

$qry="SELECT * FROM `tbl_process_db_access` WHERE `pname`='SMSBLAST'";
$res = Sql_exec($cn,$qry);
$dt = Sql_fetch_array($res);

$dbtype = $dt['db_type'];
$Server = $dt['db_server'];
$UserID = $dt['db_uid'];
$Password = $dt['db_password'];
$Database = $dt['db_name'];
ClosedDBConnection($cn);

$remoteCn = connectDB();
$qry = "SELECT `msgID`,`msg`,`srcMN`, `dstMN`, `writeTime`, `msgStatus` FROM `smsoutbox`";
		
$rs = Sql_exec($remoteCn,$qry);
$data = array();
$i=0;
while($row = Sql_fetch_array($rs)){
    
	$status = Sql_Result($row, "msgStatus");
	$j=0;
	$data[$i][$j++] = Sql_Result($row, "msgID");
    $data[$i][$j++] = Sql_Result($row, "msg");
    $data[$i][$j++] = Sql_Result($row, "srcMN");
    $data[$i][$j++] = Sql_Result($row, "dstMN");
	$data[$i][$j++] = Sql_Result($row, "writeTime");
	$data[$i][$j++] = $status;
	if( $status == "FAILED" ){
		$data[$i][$j++] = '<button style="background-color: blue; margin: 2px;" onclick="Resend(this,'."'".Sql_Result($row, "msgID")."'".'); return false;" class="btn btn-primary" type="button"> <i class="fa fa-pencil-square-o"></i> Resend
		</button>';
	}else{
		$data[$i][$j++] = '';
	}
    $i++;
}
		

		
echo json_encode($data);	
ClosedDBConnection($remoteCn);

	
?>