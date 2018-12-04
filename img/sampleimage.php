<?php
include_once('../inc/config.php');
include_once('../inc/functions.php');
include_once('../inc/custom_functions.php');
include_once('../inc/res_msg.php');
global $dbh;
$count = 0;
$method = $_SERVER['REQUEST_METHOD'];
if($method=='POST'){
	$set_ids = get('set_id');
	$data_image = get_images('sample_table',$dbh);
	$count++;
	$set_id = $set_ids.$count;
	$res['set_id']= $set_id;
	foreach ($data_image as  $value) {
		$set_images[] = array('image_id'=>$value['image_id']);
		$res['set_images'] =  $set_images;

	}
				echo json_encode($res);
}
	?>