<?php
function getFieldName($file,$name,$postfix=NULL){
     $lines = file($file);
     foreach (array_values($lines) AS $line){
          list($key, $val) = explode('=', trim($line) );

          if (trim($key) == $name){
                return $val;
          }
     }
     return false;
} 

function replaceFieldVal($file,$name, $postfix=NULL, $replaceWith,$alter_prefix = NULL, $alter_postfix = NULL)
{
    $lines = file($file);

    foreach (array_values($lines) AS $line)
	{
		list($key, $val) = explode('=', trim($line) );	
		$key_update = strrev(strtok(strrev($key),"#"));		
		if (trim($key_update) == $name)
		{
					   
			if($replaceWith == "")
			{				   
				$key_update = "#" . $key_update;
			}				
			$current = file_get_contents($file);				
			$data = str_replace($key."=".$val, $key_update."=".$replaceWith, $current); 				
			file_put_contents($file, $data);
			return true;
          }
    }
    return false;
}

function readMyFile($file) {
    $file_handle = fopen($file, "r");
    $lines = "";
    while (!feof($file_handle)) {
        $line = fgets($file_handle);
        $lines .= $line;
    }
    fclose($file_handle);

    return $lines;
}

function findNonBridge($file) {
    
    if (strpos($file, "BRIDGE=") > 0)
        return true;
    else
        return false;
}
?>