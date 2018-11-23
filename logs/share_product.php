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
	$u_id= get('user_id');
	$wh1 = "token='".$token."' AND id='".$u_id."' ";
	$check = check_rec_count('users',$wh1,$dbh);
	if(!$check){
		$res['msg'] = $global_messages['106'];
	}
	else{
		$data = array();
		$data['user_id'] = $u_id;
		$data['image_id'] = get('image_id');
		$data['image_link'] = get('image_link');
		try{
			insert('share_log',$data,$dbh);
			$res['msg'] = $global_messages['307'];
		}catch(exception $e){
			$res['msg'] = $global_messages['308'];
		}
	}
				$r1 = array();
				$r1['called_api'] = 'share_product';
				$req = array('user_id'=>$data['user_id'],'image_id'=>$data['image_id'],'image_link'=>$data['image_link'],'token'=>$token);
				$api_log = json_encode($req);
				$r1['request_params'] = $api_log;
				$req = array('msg'=>$res['msg']);
				$api_log_msg = json_encode($req);
				$r1['response_params']=$api_log_msg;
				insert('api_log',$r1,$dbh);
				echo json_encode($res);
}
?>