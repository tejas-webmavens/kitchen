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
	$email = get('email');
	$wh1 = "email='".$email."'";
	$check = check_rec_count('users',$wh1,$dbh);
	if(!$check){
		$wh = "token='".$token."'";
		$data['email'] = $email; 
		try{
						update('users',$wh,$data,"",$dbh);
							$res['id'] = $token;
							$res['msg'] = $global_messages['301'];
						}
						catch(Excption $e){
							$res['msg'] = $global_messages['303'];
						}
       	
	}
	else{
		$res['msg'] = $global_messages['201'];
	}
	echo json_encode($res);
}
?>