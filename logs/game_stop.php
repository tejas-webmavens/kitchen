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
			$id = get('id');
			$wh1 = "id='".$id."'";
			$wh = "user_id='".$u_id."'";
			$avail = check_info('users_log',$wh,$wh1,$dbh);
			if(!$avail){
				$res['code'] = '109';
				$res['msg'] = 'user id or id is wrong';
			}
			else{
				$data = array();
				$data['user_id'] = $u_id;
				$data['id'] = $id;
				$data['end_time'] =  date("Y-m-d H:i:s");
				$wh3 = "id='".$data['id']."'";
				try{				
					update('users_log',$wh3,$data,"",$dbh);
					$res['code'] = '200';
					$res['msg'] = 'Game stop successfully';
				}catch(exception $e){
					$res['code'] = '109';
					$res['msg'] = 'Game failed to stop';
				}
			}
			
		}
	echo json_encode($res);	
		
	}	
	
?>