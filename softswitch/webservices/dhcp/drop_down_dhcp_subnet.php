<?php
require_once "../lib/common.php";

	$qry = "select id,subnet from tbl_dhcp where is_active='active'";
    $options = '';
	                       
    $cn = connectDB();
    $res = Sql_exec($cn,$qry);
                            
    while($dt = Sql_fetch_array($res)){
    	$options .= '<option value="'.$dt['id'].'">'.$dt['subnet'].'</option>';
	}
                            
    ClosedDBConnection($cn);
	
	echo $options;
?>