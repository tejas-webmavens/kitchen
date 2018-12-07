<?php
error_reporting(E_ALL);
ini_set('display_errors', 0);
include_once('../inc/config.php');
include_once('../inc/functions.php');
include_once('../inc/custom_functions.php');
include_once('../inc/res_msg.php');
include_once('../users/send_mail.php');
global $dbh;
$method = $_SERVER['REQUEST_METHOD'];
if($method =='POST'){
	$email = get('email');
	$data['email'] = $email; 
	$req = array('email'=>$data['email']);
	if(isset($data['email']) && $data['email'] != ''){
		$wh = "email = '".$data['email']."'";
		$avail = check_rec_count('users',$wh,$dbh);
	}
	if(!$avail){
		$res['code'] = '403';
		$res['msg'] = $global_messages['403']; 
	}
	else{
		$result = get_pswd('users',$data['email'],$dbh);
		$result_data = array_shift($result);
		if($result_data == ''){
			$res['code'] = '405';
			$res['msg'] = $global_messages['405']; 
		}
		else{
			$token = $result_data['token'];
			$password = $result_data['password'];
			$original_password = decode($password,$token);
			$header = array();
			$header['from'] = 'tejas@webmavens.com';
			$header['to'] = $data['email'];
			$header['subject'] = '[Kitchen Kraze] Forgot password';
			$msg = "Hello!!!<br/>Your password is : '".$original_password."'";
			$mail = send_mail($header,$msg);
			if($mail == 1){
				$res['code'] = '200';
				$res['msg'] = $global_messages['404']; 
			}
			else{
				$res['code'] = '406';
				$res['msg'] = $global_messages['406'];
			}
			
		}

	}
	$r1 = array();
	$r1['called_api'] = 'forgotpassword';
	$api_log = json_encode($req);
	$r1['request_params'] = $api_log;
	$api_log_msg = json_encode($res);
	$r1['response_params'] = $api_log_msg;
	insert('api_log',$r1,$dbh);
	echo json_encode($res);
}
?>