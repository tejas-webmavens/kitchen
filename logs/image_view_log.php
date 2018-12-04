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

	$data = array();
	$data['image_id'] = get('image_id');
	$data['image_url'] = get('image_url');
	$req = "'".$data['image_id']."', '".$data['image_url']."', '".$token."'";
	$wh = "token='".$token."'";
	$u_id = get_id('users',$wh,$dbh);
	if(empty($u_id)){
		$res['code'] = '309';
		$res['msg'] = $global_messages['309'];
	}
	else{
		$data['user_id'] = array_shift(array_shift($u_id));
		$data['users_log_id'] = get('users_log_id');
	try{
	 insert('image_view_log',$data,$dbh);
	 $res['code'] = '200';
	$res['msg'] = $global_messages['310'];
	$res['token'] = $token;
	}
	catch(exception $e){
		$res['code'] = '311';
		$res['msg'] = $global_messages['311'];
	}
	}
				$r1 = array();
				$r1['called_api'] = 'image_view_log';
				$req = array('user_id'=>$data['user_id'],'users_log_id'=>$data['users_log_id'],'image_id'=>$data['image_id'],'image_url'=>$data['image_url'],'token'=>$token);
				$api_log = json_encode($req);
				$r1['request_params'] = $api_log;
				if(isset($res['token'])){
					$req = array('token'=>$token,'code'=>$res['code'],'msg'=>$res['msg']);
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