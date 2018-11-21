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
    // echo "$header: $value <br />\n";
    if($header == "token"){
    	$token = $value;
    }
	}
	$email = get('email');
	$check = check_email('users',$email,$dbh);
	if(!$check){
		$wh = "token='".$token."'";
		$data['email'] = $email; 
		try{
						update('users',$wh,$data,"",$dbh);
							$res['id'] = $token;
							$res['code'] = '200';
							$res['msg'] = 'Successfully changed email';
						}
						catch(Excption $e){
								$res['code'] = '109';
							$res['msg'] = 'email is not updated';
						}
       	
	}
	else{
		$res['code'] = '201';
		$res['msg'] = 'email is already exists';
	}
	echo json_encode($res);
}
?>