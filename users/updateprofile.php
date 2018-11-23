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
	$req =array('token'=>$token,'email'=>$email);
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
				$r1 = array();
				$r1['called_api'] = 'updateprofile';
				$api_log = json_encode($req);
				$r1['request_params'] = $api_log;	
				if(isset($res['id'])){
					$req = array('id'=>$token,'msg'=>$res['msg']);
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