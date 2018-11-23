<?php
error_reporting(E_ALL);
ini_set('display_errors', 0);
include_once('../inc/config.php');
include_once('../inc/functions.php');
include_once('../inc/custom_functions.php');
include_once('../inc/res_msg.php');
global $dbh;
$method = $_SERVER['REQUEST_METHOD'];
if($method=='POST'){
	$valid =  false;
	$data['email'] = get('email');
	$token = get_token('users',$data['email'],$dbh);
	$out = array_shift(array_shift($token));
	$pwd = get('password');
	$data['password'] = encode($out,$pwd);
	$req = array('email'=>$data['email'],'password'=>$data['password']);
	if(isset($data['email']) && isset($data['password']) && $data['email']!='' && $data['password']!=''){
		$valid = true;
		$wh1 = "email='".$data['email']."' AND password='".$data['password']."' ";
		$avail = check_rec_count('users',$wh1,$dbh);
	}
	if(!$avail){
		$res['msg'] = $global_messages['104'];
	}
	else{
		
			if($valid){
				$st = check_status('users',$out,$dbh);
				$status = array_shift(array_shift($st));
				if($status == 'active'){
				$wh1 = "token='".$out."'";
				$data = array();
				$data['type'] = get('type');
				update('users',$wh1,$data,"",$dbh);
				$res['msg'] = $global_messages['200'];
				$res['token'] = $out;
				}
				else if($status == "deactive"){
					$res['msg'] = $global_messages['206'];
				}
				else if($status == "deleted"){
					$res['msg'] = $global_messages['211'];
				}
				else if($status == "blocked"){
					$res['msg'] = $global_messages['212'];
				}
				
			}
			else{
				$res['msg'] = $global_messages['210'];
			}
		}
				$r1 = array();
				$r1['called_api'] = 'login';				
				$api_log = json_encode($req);
				$r1['request_params'] = $api_log;
				if(isset($res['token'])){
					$req = array('token'=>$out,'msg'=>$res['msg']);
					$api_log_msg = json_encode($req);
					$r1['response_params'] = $api_log_msg;
				}
				else{
					$req = array('msg'=>$res['msg']);
					$api_log_msg = json_encode($req);
					$r1['response_params']=$api_log_msg;
				}	 
				insert('api_log',$r1,$dbh);
				echo json_encode($res);
}	

?>