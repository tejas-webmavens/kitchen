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
	$data = array();
	$data['token'] = uniqid();
	$data['email'] = get('email');
	$pwd = get('password');
	$password = decode($data['token'],$pwd);
	$req = array('email'=>$data['email'],'password'=>$password);
	if(isset($data['email']) && isset($password) && $data['email']!='' && $password!=''){
		$valid = true;
		$wh1 = "email='".$data['email']."'";
		$avail = check_rec_count('users',$wh1,$dbh);
	}
	

	if($avail){
		$res['code'] = '105';
		$res['msg'] = $global_messages['105'];
	}
	else{
		if($valid){

			$data['password'] = encode($pwd,$data['token']);			
			$id = insert('users',$data,$dbh);
			$res['id'] = $id;
			$res['code'] = '200';
			$res['msg'] = $global_messages['300'];
			$res['token'] = $data['token'];
		}
		else{
			$res['code'] = '402';
			$res['msg'] = $global_messages['402'];
		}	
	}
	$r1 = array();
	$r1['called_api'] = 'signup';
	$api_log = json_encode($req);
	$r1['request_params'] = $api_log;
	if(isset($res['token'])){
		$req = array('token'=>$data['token'],'id'=>$id,'code'=>$res['code'],'msg'=>$res['msg']);
		$api_log_msg = json_encode($req);
		$r1['response_params'] = $api_log_msg;
	}
	else{
		$req = array('code'=>$res['code'],'msg'=>$res['msg']);
		$api_log_msg = json_encode($req);
		$r1['response_params']=$api_log_msg;
		}	 
	insert('api_log',$r1,$dbh);
	echo json_encode($res);
}




?>