<?php 
error_reporting(E_ALL);
ini_set('display_errors', 0);
include_once('../inc/config.php');
include_once('../inc/functions.php');
include_once('../inc/custom_functions.php');
global $dbh;
$method = $_SERVER['REQUEST_METHOD'];
if($method=='POST'){
	$valid =  false;
	$data = array();
	$data['token'] = uniqid();
	$data['email'] = get('email');
	$pwd = get('password');
	$password = decode($data['token'],$pwd);
	if(isset($data['email']) && isset($password) && $data['email']!='' && $password!=''){
		$valid = true;
		$wh1 = "email='".$data['email']."'";
		$avail = check_rec_count('users',$wh1,$dbh);
	}
	

	if($avail){
		$res['msg'] = $global_messages['105'];
	}
	else{
		if($valid){

			$data['password'] = encode($data['token'],$pwd);			
			$id = insert('users',$data,$dbh);
			$res['id'] = $id;
			$res['msg'] = $global_messages['300'];
			$res['token'] = $data['token'];
		}
		else{
			$res['msg'] = $global_messages['301'];
		}	
	}
	
	echo json_encode($res);
}




?>