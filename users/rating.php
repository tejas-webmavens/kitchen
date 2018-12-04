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
	
	$data = array();
	$data['name'] = get('name');
	$data['email'] = get('email');
	$data['comment'] = get('comment');
	$data['rate'] = get('rate');
	$req = array('name'=>$data['name'],'email'=>$data['email'],'comment'=>$data['comment'],'rate'=>$data['rate']);
	try{
		$id = insert('app_ratings',$data,$dbh);
		$res['id']= $id;
		$res['code'] = '200';
		$res['msg']= $global_messages['400'];
	}catch(exception $e){
		$res['code'] = '401';
		$res['msg']= $global_messages['401'];
	}
	$r1 = array();
	$r1['called_api'] = 'rating';
	$api_log = json_encode($req);
	$r1['request_params'] = $api_log;
	if(isset($res['token'])){
		$req = array('id'=>$id;'token'=>$data['token'],'code'=>$res['code'],'msg'=>$res['msg']);
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