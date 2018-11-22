<?php
error_reporting(E_ALL);
ini_set('display_errors', 0);
include_once('../inc/config.php');
include_once('../inc/functions.php');
include_once('../inc/custom_functions.php');
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
	$wh1 = "token='".$token."'";
	$wh = "id='".$u_id."'";
	$check = check_info('users',$wh,$wh1,$dbh);
	if(!$check){
		$res['code'] = '105';
		$res['msg'] = 'Token or User id is wrong';
	}
	else{
			$data = array();
			$data['user_id'] = $u_id;
			$data['start_time'] =  date("Y-m-d H:i:s");
			
			try{
				$id = insert('users_log',$data,$dbh);
				$res['id'] = $id;
				$res['code'] = '200';
				$res['msg'] = 'Game start successfully';
			}catch(exception $e){
				$res['code'] = '109';
				$res['msg'] = 'Game failed to start';
			}
		}
	echo json_encode($res);	
		
	}
	
?>