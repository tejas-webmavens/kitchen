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
			$id = get('id');
			$wh1 = "id='".$id."' AND id='".$u_id."' ";
			$avail = check_rec_count('users',$wh1,$dbh);
			if($avail){
				$res['msg'] = $global_messages['312'];
			}
			else{
				$data = array();
				$data['user_id'] = $u_id;
				$data['id'] = $id;
				$data['end_time'] =  date("Y-m-d H:i:s");
				$wh3 = "id='".$data['id']."'";
				try{				
					update('users_log',$wh3,$data,"",$dbh);
					$res['msg'] = $global_messages['313'];
				}catch(exception $e){
					$res['msg'] = $global_messages['314'];
				}
			}
			
		}
	echo json_encode($res);	
		
	}	
	
?>