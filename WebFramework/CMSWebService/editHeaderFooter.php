<?php
	include_once "config.php";

	$titleThumb = "";

   // echo "<pre>";
   // print_r($_POST); 
    //exit;


   // dbInsert($_POST);
    if(empty($_POST["id"]))
    {
        unset($_POST['id']);
        $query_data = jsonDataToQueryString($_POST);
	    $query = "INSERT INTO layout ({$query_data['fields']}) VALUES({$query_data['values']})";
        
        if(mysql_query($query)){

            $message="Data has been saved";
        }
        else
        {
             $message= mysql_error();
        }
    }
    else{ // updating category fields

        $id = $_POST['id'];
        unset($_POST['id']);

        $query_data = jsonEditQuery($_POST);


       $sql = "UPDATE layout SET $query_data WHERE id = ".$id."";
       // exit;
                
        if(mysql_query($sql))
        {
            $message= "Data has been updated";
        }else{
             $message= mysql_error();
        }
    }
     //exit;

     echo  $message;





?>