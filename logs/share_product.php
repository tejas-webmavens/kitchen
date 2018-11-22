<?php
error_reporting(E_ALL);
ini_set('display_errors', 0);
include_once('../inc/config.php');
include_once('../inc/functions.php');
include_once('../inc/custom_functions.php');
include_once('../inc/res_msg.php');
global $dbh;
$method = $_SERVER['REQUEST_METHOD'];
if($method =='POST'){
	$headers = apache_request_headers();
   foreach ($headers as $header => $value) {
    	if($header == "token"){
    		$token = $value;
    	}
	}
	$u_id= get('user_id');
	$wh1 = "token='".$token."' AND id='".$u_id."' ";
	$check = check_rec_count('users',$wh1,$dbh);
	if(!$check){
		$res['msg'] = $global_messages['105'];
	}
	else{
		$data = array();
		$data['user_id'] = $u_id;
		$data['image_id'] = get('image_id');
		$data['image_link'] = get('image_link');
		try{
			insert('share_log',$data,$dbh);
			$res['msg'] = $global_messages['307'];
		}catch(exception $e){
			$res['msg'] = $global_messages['308'];
		}
	}
	echo json_encode($res);
}
?>