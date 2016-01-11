<?php

function export_csv_file($title,$data,$filename,$delimiter=",")
{
		
	header("Content-type:text/octect-stream");
	header("Content-Disposition:attachment;filename=$filename");
                                                                
	
	$headStr="";
	foreach($title as $heading)
	{
		if($headStr !="") $headStr.= $delimiter;
	    $headStr.= $heading;
	}
	
	$headStr.= "\n";
	if(!empty($title))print $headStr;
	
	 
	foreach($data as $row)
	{
		$row_str="";
		foreach($row as $key=>$value)
		{
			if($row_str !="") $row_str.= $delimiter;
			$row_str.=$value;
		}
		$row_str.= "\n";
		print $row_str;
	}
	

}
?>