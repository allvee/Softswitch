<?php
	include_once "config.php";

	//$post_data = jsonDataToQueryString($_POST);
	$fileds_data = array();
	$data = array();

	foreach($_POST as $key=>$val){
		$check = explode("#",$key);

		if(sizeof($check)==2){
			$data['module'][] = $val;
		}elseif(sizeof($check)>2){
			$data['actions'][$key] = $val;
		}elseif($key == 'password'){
			$fileds_data[$key] = "{$val}";
		}else{
			$fileds_data[$key] = $val;
		}
	}

	if(!empty($data['module'])){
	$permissions = array();
	//module loop
	foreach($data['module'] as $ind=>$val){
		$permissions[$val] = array();
		//action loop
		foreach($data['actions'] as $key=>$v){
			$action_check = explode('#',$key);
			if($action_check[1] == $val){
				$permissions[$val][$v] = true;
			}
		}
	}

	$permission_string = json_encode($permissions);
	$fileds_data['permissions'] = $permission_string;
    }else{
      $fileds_data['permissions'] = "[]";  
    }


	//insert

	if(isset($_POST['id'])){
		//edit block;

		$edit_id = $_POST['id'];
		unset($fileds_data['id']);
		$edit_query = jsonEditQuery($fileds_data);
		$sql = "UPDATE users SET $edit_query  WHERE id =$edit_id";
		if(mysql_query($sql)){
            $return_data = array('status' => true, 'message' =>"This user has been updated successfully.");
		}else{
            $return_data = array('status' => false, 'message' =>"Please Try again.");
		}

       	echo json_encode($return_data);

	}else{
		//add block
		$post_data = jsonDataToQueryString($fileds_data);
		$query = "insert into users ({$post_data['fields']}) values ({$post_data['values']})";
		//echo $query;
		if(mysql_query($query)){
			$return_data = array('status' => true, 'message' =>"This user has been added successfully.");
			echo json_encode($return_data);
		}else{
			$return_data = array('status' => false, 'message' =>"Please Try Again.");
			echo json_encode($return_data);
		}


	}


?>