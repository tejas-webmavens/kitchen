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
		$avail = check_data('users', $data['email'],$dbh);
	}
	

	if(!$avail){
		$res['code'] = '105';
		$res['msg'] = 'User is already available';
	}
	else{
		if($valid){

			$data['password'] = encode($data['token'],$pwd);
			// print_r($data['password']);
			
			$id = insert('users',$data,$dbh);
			$res['id'] = $id;
			$res['code'] = '200';
			$res['msg'] = 'Success';
			$res['token'] = $data['token'];
		}
		else{
			$res['code'] = '104';
			$res['msg'] = 'invalid username or password';
		}	
	}
	
	echo json_encode($res);
}




?>