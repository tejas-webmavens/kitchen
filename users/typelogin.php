<?php
error_reporting(E_ALL);
ini_set('display_errors', 0);
include_once('../inc/config.php');
include_once('../inc/functions.php');
include_once('../inc/custom_functions.php');
include_once('../inc/res_msg.php');
global $dbh;
$method = $_SERVER['REQUEST_METHOD'];
if($method=='POST'){
	$data['email'] = get('email');
	$token = get_token('users',$data['email'],$dbh);
	$out = array_shift(array_shift($token));
	$pwd = get('password');
	$data['password'] = encode($pwd,$out);
	if(isset($data['email']) && isset($data['password']) && $data['email']!='' && $data['password']!=''){
		$valid = true;
		$wh1 = "email='".$data['email']."' AND password='".$data['password']."' ";
		$avail = check_rec_count('users',$wh1,$dbh);
	}
	if(!$avail){
		$res['code'] = '104';
		$res['msg'] = $global_messages['104'];
	}
	else{
		$st = check_status('users',$out,$dbh);
		$status = array_shift(array_shift($st));
		if($status == 'active'){
					$data['type'] = get('type');
					if($data['type'] == ''){
						$res['code'] = '407';
						$res['msg'] = $global_messages['407'];
					}
					if($data['type'] == 'F'){
						$wh1 = "email='".$data['email']."' AND password='".$data['password']."' AND type = 'F'";
						$email_type_f_check = check_rec_count('users',$wh1,$dbh);
						if(!$email_type_f_check){
							$res['code'] = '408';
							$res['msg'] = $global_messages['408'];
						}else{
							$res['code'] = '200';
							$res['msg'] = $global_messages['200'];
							$res['token'] = $out;
						}
					}
					if($data['type'] == 'G')
					{
						$wh1 = "email='".$data['email']."' AND password='".$data['password']."' AND type = 'G'";
						$email_type_g_check = check_rec_count('users',$wh1,$dbh);
						if(!$email_type_g_check){
							$res['code'] = '409';
							$res['msg'] = $global_messages['409'];
						}else{
							$res['code'] = '200';
							$res['msg'] = $global_messages['200'];
							$res['token'] = $out;
						}
					}
			}
		else if($status == "deactive"){
			$res['code'] = '206';
			$res['msg'] = $global_messages['206'];
		}
		else if($status == "deleted"){
			$res['code'] = '211';
			$res['msg'] = $global_messages['211'];
		}
		else if($status == "blocked"){
			$res['code'] = '212';
			$res['msg'] = $global_messages['212'];
		}
		else{
				$res['code'] = '210';
				$res['msg'] = $global_messages['210'];
			}	
		
			
		}
		echo json_encode($res);
}
?>