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
	
	if(!function_exists('apache_request_headers')){
		$token = $_SERVER['HTTP_TOKEN'];
	}
	else{
		$headers = apache_request_headers();
	   	foreach ($headers as $header => $value) {
	    	if($header == "token"){
	    		$token = $value;
	    	}
		}
	}
	$email= check_token('users',$token,$dbh);
	$out = array_shift(array_shift($email));
	$old_password = get('oldpassword');
	$old_data['password'] = encode($token,$old_password);
	$wh1 = "token='".$token."' AND password='".$old_data['password']."' ";
	$check = check_rec_count('users',$wh1,$dbh);
	if(!$check){
		$res['code'] = '302';
		$res['msg'] = $global_messages['302'];
	}
	else{
		 	$new_password = get('password');
			
					$retype = get('retype');
					if($new_password == $retype)
					{
						$password = encode($token,$new_password);
						$wh = "token='".$token."'";
						$data['password'] = $password; 
						try{
							update('users',$wh,$data,"",$dbh);
							$res['code'] = '200';
							$res['msg'] = $global_messages['304'];
						}
						catch(Excption $e){
							$res['code'] = '305';
							$res['msg'] = $global_messages['305'];
						}
					}
					else{
						$res['code'] = '306';
							$res['msg'] = $global_messages['306'];
					}
					
					
	}
				$r1 = array();
				$r1['called_api'] = 'changepassword';
				$req = array('token'=>$token,'oldpassword'=>$oldpassword,'newpassword'=>$new_password,'retype'=>$retype);
				$api_log = json_encode($req);
				$r1['request_params'] = $api_log;
				if(isset($res['id'])){
					$req = array('token'=>$out,'msg'=>$res['msg'],'code'=>$res['code']);
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