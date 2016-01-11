<?php
	include_once "config.php";
	$id = $_POST;
	//initialize
	$content_list_q 	= "SELECT cid,catid FROM content";
	$content_list_rs 	= mysql_query($content_list_q) or die(mysql_error());
	$content_list 		= json_decode(formatJSON($content_list_rs),true);
		
	$cat_list_q 		= "SELECT tbid,parent FROM category";
	$cat_list_rs 		= mysql_query($cat_list_q) or die(mysql_error());
	$cat_list 			= json_decode(formatJSON($cat_list_rs),true);
	
	$cat_tree = createTree($cat_list,0);
	$deleteAbleArray = getDeletePortion($cat_tree,$id['id']);
	processDeleteWithCOntent($deleteAbleArray);
	die();
	
	
//create tree	
function createTree($data = array(), $parent=0){
	$tree = array();
	foreach($data as $index=>$value) {
		if ($value['parent'] == $parent) {
			$children = createTree($data,$value['tbid']);
			if (!empty($children)) {
				$value['children'] = $children;
			}
			$tree[] = $value;
		}
	};
	return $tree;
}

//get delete portion
function getDeletePortion($treeData,$delete_id){
	$deleteable_array = array();
	foreach($treeData as $ind=>$value){
		if($value['tbid'] == $delete_id){
			$deleteable_array = $value;
		}else{
			$deleteable_array = getDeletePortion($value['children'],$delete_id);
		}
		if(!empty($deleteable_array)){
			return $deleteable_array;
		}
	}
	return $deleteable_array;
}

//get deleteablel list
function processDeleteWithCOntent($data){
	//delete category
	$cat_del_q = "DELETE FROM category WHERE tbid='{$data['tbid']}'";
	mysql_query($cat_del_q);
	//delete content
	$cotent_del_q = "DELETE FROM content WHERE catid='{$data['tbid']}'";
	mysql_query($cotent_del_q);
	//process recursive
	if(isset($data['children'][0])){
		processDeleteWithCOntent($data['children'][0]);
	}
}


	?>

