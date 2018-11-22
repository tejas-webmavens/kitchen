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
	$email= check_token('users',$token,$dbh);
	$out = array_shift(array_shift($email));
	$old_password = get('oldpassword');
	$old_data['password'] = encode($token,$old_password);
	$wh1 = "token='".$token."' AND password='".$old_data['password']."' ";
	$check = check_rec_count('users',$wh1,$dbh);
	if(!$check){
		$res['msg'] = $global_messages['302'];
	}
	else{
		 	$new_password = get('password');
			if(!preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{8,12}$/', $new_password)) {
				$res['msg'] = $global_messages['202'];
			}
			else{
					$retype = get('retype');
					if($new_password == $retype)
					{
						$password = encode($token,$new_password);
						$wh = "token='".$token."'";
						$data['password'] = $password; 
						try{
							update('users',$wh,$data,"",$dbh);
							$res['id'] = $id;
							$res['msg'] = $global_messages['304'];
						}
						catch(Excption $e){
							$res['msg'] = $global_messages['305'];
						}
					}
					else{
							$res['msg'] = $global_messages['306'];
					}
					
				}	
	}
	
	echo json_encode($res);
}
?>