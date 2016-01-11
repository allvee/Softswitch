<?php
require_once "../lib/common.php";

$output = array();
$cmd = "sudo ip link show up";
exec($cmd,$output);
$str ="";
$str ="";

foreach($output as $val){
	if(preg_match("/eth/",$val) && !preg_match("/link/",$val)){
		
		list($num,$eth_name,$rest) = explode(":",$val);
         
              if(preg_match("/\@/",$eth_name)){
                   list($sub,$main) = explode("@",$eth_name);
                   $eth_name = $sub;
              }
              
              if($str !="") $str.='<option value="'.trim($eth_name).'">'.trim($eth_name).'</option>';
              else $str='<option value="'.trim($eth_name).'">'.trim($eth_name).'</option>';
	}
}
echo $str;

//echo json_encode($output);	  
      
?>