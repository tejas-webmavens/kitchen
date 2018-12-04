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
		$res['code'] = '105';
		$res['msg'] = $global_messages['105'];
	}
	else{
			$id = get('id');
			$wh1 = "id='".$id."' AND id='".$u_id."' ";
			$avail = check_rec_count('users',$wh1,$dbh);
			if($avail){
				$res['code'] = '312';
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
					$res['code'] = '200';
					$res['msg'] = $global_messages['313'];
				}catch(exception $e){
					$res['code'] = '314';
					$res['msg'] = $global_messages['314'];
				}
			}
			
		}
				$r1 = array();
				$r1['called_api'] = 'game_stop';
				$req = array('id'=>$data['id'],'user_id'=>$data['user_id'],'end_time'=>$data['end_time']);
				$api_log = json_encode($req);
				$r1['request_params'] = $api_log;
				$req = array('code'=>$res['code'],,'msg'=>$res['msg']);
				$api_log_msg = json_encode($req);
				$r1['response_params']=$api_log_msg;
				insert('api_log',$r1,$dbh);
				echo json_encode($res);
		
	}	
	
?>