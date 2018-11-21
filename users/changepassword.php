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
	// $token = get('token');
	// $t['token'] = $token;
	$email= check_token('users',$token,$dbh);
	$out = implode("&",array_map(function($a) {return implode("~",$a);},$email));
	$old_password = get('oldpassword');
	$old_data['password'] = encode($token,$old_password);
	// print_r($old_data['password']);
	$check = check_pwd('users',$token,$old_data['password'],$dbh);
	if(!$check){
       	$res['code'] = '201';
		$res['msg'] = 'Old password is wrong';
	}
	else{
		 	$new_password = get('password');
			if(!preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{8,12}$/', $new_password)) {
				$res['code'] = '202';
				$res['msg'] = 'Password should be between 8-12 characters and it should contain minimum one character and number';
			}
			else{
					$retype = get('retype');
					if($new_password == $retype)
					{
						$password = encode($token,$new_password);
						$wh = "token='".$token."'";
						$data['password'] = $password; 
						// print_r($data['password']);
						try{
							update('users',$wh,$data,"",$dbh);
							$res['id'] = $id;
							$res['code'] = '200';
							$res['msg'] = 'Successfully changed password';
						}
						catch(Excption $e){
								$res['code'] = '109';
							$res['msg'] = 'password is not updated';
						}
					}
					else{
						
						$res['code'] = '109';
						$res['msg'] = 'please confirm password';
					}
					
				}	
	}
	
	echo json_encode($res);
}
?>