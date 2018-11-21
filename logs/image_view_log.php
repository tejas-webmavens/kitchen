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

	$data = array();
	$data['image_id'] = get('image_id');
	$data['image_url'] = get('image_url');
	$wh = "token='".$token."'";
	$u_id = get_id('users',$wh,$dbh);
	if(empty($u_id)){
		$res['code'] = '110';
		$res['msg'] = 'token is not valid';
	}
	else{
		$data['user_id'] = array_shift(array_shift($u_id));
		$data['users_log_id'] = get('users_log_id');
	try{
	 insert('image_view_log',$data,$dbh);
	$res['code'] = '200';
	$res['msg'] = 'Log succefully';
	$res['token'] = $token;
	}
	catch(exception $e){
		$res['code'] = '104';
		$res['msg'] = 'Data is not inserted';
	}
	}
	
echo json_encode($res);
}
?>