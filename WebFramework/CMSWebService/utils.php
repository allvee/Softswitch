<?php
//mysql return to json

function formatJSON($result)
{
	$str="[";
	$numRows=0;
	while($row = mysql_fetch_array($result))
	{
		if($numRows>0)
			$str=$str.", ";
		$numRows++;
		$n=mysql_num_fields($result);
		for($i=0; $i<$n; $i++)
		{
			$fld=mysql_field_name($result, $i);
			$val=addslashes($row[$fld]);
			$val=str_replace("\t", "", $val);
            $val=str_replace("'", "\'", $val);
			$val=str_replace("\r\n", "", $val);
			
			if($i==0)
				$str=$str."{\"$fld\":\"$val\"";
			else
				$str=$str.", \"$fld\":\"$val\"";
		}
		$str=$str."}\r\n";
	}
	
	$str=$str."]";
	return $str;
}

//json to add query @mahfooz
function jsonDataToQueryString($data){
	
	$field_string = "" ;
	$value_string = "";
	foreach($data as $key=>$val){
		
		$field_string .= $key.',';
		$value_string .= "'".mysql_real_escape_string($val)."',";
	}
	
	return array('fields' => substr($field_string,0,-1), 'values'=>substr($value_string,0,-1));
}

//json to edit query @mahfooz

function jsonEditQuery($data){
    $string = "";
	foreach($data as $key => $val){
		$string .= "{$key} = '".mysql_real_escape_string($val)."',";
	}
	return substr($string,0,-1);
}

?>