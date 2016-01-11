<?php
require_once "../lib/common.php";
$cn = connectDB();
$info = $_POST['info'];
$file_name   = mysql_real_escape_string(htmlspecialchars($info['file_name']));

$score_map = array('udp'=>0,'tcp'=>0,'igmp'=>0,'icmp'=>0,'vrrp'=>0,'icmp6'=>0,'arp'=>0,'aarp'=>0,'stp'=>0);

$ip4_proto = array('udp','tcp','igmp','icmp','vrrp','icmp6');
$ip6_proto = array('udp','tcp','igmp','icmp','vrrp','icmp6');
$ether_proto =array('arp','aarp','stp');
 

$command = "sudo tcpdump -n -r ".$tcp_dump_path.$file_name.".pcap";




//$output = array();
$ip_proto_total = 0;
foreach($ip4_proto as $val){
	$output = array();
	if($val == 'icmp' || $val == 'icmp6'){
	     exec($command." ".$val,$output); 
	}else{
	      exec($command." ip proto \\\\".$val,$output);  
	}
	$previous_val = 0;
	$new_val =0;
	$previous_val = $score_map[$val];
	$new_val=intval($previous_val)+count($output);
	$score_map[$val]=$new_val;
 //   echo " ip proto $val:".count($output)."\n";
	$ip_proto_total +=intval(count($output));
}

//echo "IP4 total proto:".$ip_proto_total."\n";

$ip6_proto_total = 0;
foreach($ip6_proto as $val){
	$output = array();
	if($val == "icmp" || $val == "icmp6"){
		continue;
	}else{
	      exec($command." ip6 proto \\\\".$val,$output);  
	}
	$previous_val = 0;
	$new_val =0;
	$previous_val = $score_map[$val];
	$new_val=intval($previous_val)+count($output);
	$score_map[$val]=$new_val;
	//echo " ip6 proto $val:".count($output)."\n";
	$ip6_proto_total +=intval(count($output));
}
//echo "IP6 total proto:".$ip6_proto_total."\n";
//echo "total ip(ip4+ip6) proto::".($ip_proto_total+$ip6_proto_total)."\n";

$ip_ether_total = 0;
foreach($ether_proto as $val){
	$output = array();
	exec($command." ether proto \\\\".$val,$output);  
	$previous_val = 0;
	$new_val =0;
	$previous_val = $score_map[$val];
	$new_val=intval($previous_val)+count($output);
	$score_map[$val]=$new_val;
	 
 //   echo " Ether proto $val:".count($output)."\n";
	$ip_ether_total +=intval(count($output));
}
//echo "Total Ether proto::".$ip_ether_total ."\n";
//echo "IP+Eher Proto:".($ip_proto_total+$ip6_proto_total+$ip_ether_total)."\n";
$output = array();
exec($command,$output);
$total = intval(count($output));

$ip_and_ether = intval($ip_proto_total+$ip6_proto_total+$ip_ether_total);

$others = $total>$ip_and_ether ? intval($total-$ip_and_ether):0;
//echo "Total Packet:".count($output)."\n";
$score_map['others']= $others;
$jsonData = array();
arsort($score_map);
foreach($score_map as $key=>$val){
       $jsonData[] = array($key,$val);   	
}

echo json_encode($jsonData);
//print_r($output);
ClosedDBConnection($cn);
  
      
?>