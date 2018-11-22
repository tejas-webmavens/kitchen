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
	$data['email'] = get('email');
	$token = get_token('users',$data['email'],$dbh);
	$out = array_shift(array_shift($token));
	$pwd = get('password');
	$data['password'] = encode($out,$pwd);
	// print_r($data['password']);
	if(isset($data['email']) && isset($data['password']) && $data['email']!='' && $data['password']!=''){
		$valid = true;
		$avail = check_login('users',$data['email'],$data['password'],$dbh);

	}
	if(!$avail){
		$res['code'] = '104';
		$res['msg'] = 'invalid username or password';
	}
	else{
		
			if($valid){
				$st = check_status('users',$out,$dbh);
				$status = array_shift(array_shift($st));
				if($status == 'active'){
				$res['code'] = '200';
				$res['msg'] = 'Successfully Login';
				$res['token'] = $out;
				}
				else if($status == "deactive"){
					$res['code'] = '206';
					$res['msg'] = 'User is deactive';
				}
				else if($status == "deleted"){
					$res['code'] = '211';
					$res['msg'] = 'User is deleted';
				}
				else if($status == "blocked"){
					$res['code'] = '212';
					$res['msg'] = 'User is blocked';
				}
			}
			else{
				$res['code'] = '210';
				$res['msg'] = 'Username and password should not be empty';
			}
		}
		
	echo json_encode($res);
}	

?>