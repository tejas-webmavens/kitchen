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
		$rate = get('rate');
		if(preg_match('/([0-1]{1,})\.([0-1]{1,2})/', $rate) == 1) {
    
			$data['rate'] = $rate;
			$data['user_id'] = $u_id;
			$data['image_id'] = get('image_id');
			$data['image_url'] = get('image_url');
			$data['users_log_id'] = get('users_log_id');
			
			try{
				insert('rates_log',$data,$dbh);
				$res['msg'] = $global_messages['307'];
			}catch(exception $e){
				$res['msg'] = $global_messages['308'];
			}
		}
		else{
			$res['code'] = '213';
			$res['msg'] = 'Rate should be float';
		}
		
		
	}
	echo json_encode($res);
}
?>