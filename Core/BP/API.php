<?php
abstract class Core_BP_API
{
	public function getRequestParams(){
		$request_params = array();
		//$request_params['post'] = $this->params()->fromPost();   // From POST
		//$request_params['query'] = $this->params()->fromQuery();  // From GET
		//$request_params['route'] = $this->params()->fromRoute();  // From RouteMatch
		//$request_params['header'] = $this->params()->fromHeader(); // From header
		//$request_params['files'] = $this->params()->fromFiles();  // From file being uploaded
		return Core_BP_API::convertToJson($request_params);
	}

	public function getRequestTime(){
		return date('Y-m-d H:i:s');
	}

	public function getResponseTime(){
		return date('Y-m-d H:i:s');
	}

	public function requestApiLog($called_api, $request_time){
		$api_log = array();
		$api_log['called_api'] = $called_api;
		$api_log['request_data'] = Core_BP_API::getRequestParams();
		$api_log['request_datetime'] = $request_time;
		$db = Zend_Db_Table::getDefaultAdapter();
		$api_id = Core_BP_BaseTable::insert_new('api_log', $api_log);
		return $api_id;
	}

	public function responseApiLog($id, $response){
		$api_log = array();
		$api_log['response_data'] = $response;
		$api_log['response_datetime'] = Core_BP_API::getResponseTime();
		$wh = "id=".$id;
		Core_BP_BaseTable::update_new('api_log', $api_log, $wh);
	}

	public function convertToJson($data){
		return json_encode($data);
	}

	public function readJson($json){
		return json_decode($json);
	}
        function curl_request($url='',$header='',$method='POST',$data=array(),$requested_by_script='',$options=array())
        {            
            if($requested_by_script=='')            
                $requested_by_script=Zend_Controller_Front::getInstance()->getRequest()->getControllerName() . " : " . Zend_Controller_Front::getInstance()->getRequest()->getActionName();
            //insert api_log
            $db = Zend_Db_Table::getDefaultAdapter();
            $api_log_request_data=array(
                'request_dump'=>$data,
                'request_timestamp'=>date("Y-m-d H:i:s"),
                'requested_by_script'=>$requested_by_script,
                'request_sent_to_url'=>$url,
                'request_method'=>$method
            );
            $id = Core_BP_BaseTable::insert_new('api_log', $api_log_request_data);
            //curl request
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            if($header!='')
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
            if($method!='')
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
            if($data!='')
            curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            if (strpos($url, '/ethereum/transaction') == false && strpos($url, '/ethereum/balance') == false) 
            curl_setopt($ch, CURLOPT_HEADER, true);
            if(count($options)>0)
            {
                    foreach ($options as $key=>$value)
                    {     
                        curl_setopt($ch, constant($key), $value);
                    }
            }            
            $response = curl_exec($ch);                                
            //update api_log
            $api_log_response_data=array(
                'response_dump'=>$response,
                'response_timestamp'=>date("Y-m-d H:i:s"),                                                
            );
            Core_BP_BaseTable::update_new('api_log', $api_log_response_data, 'id=' . $id);
            if (strpos($url, '/ethereum/transaction') !== FALSE || strpos($url, '/ethereum/estimate/gas') !==FALSE) 
            {
                $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);                
                if($httpcode!='200')
                    return false;
            }
            curl_close($ch);
            return $response;
        }        
        function curl_exec_wrapper($ch)
        {            
            $url=curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
            $requested_by_script=Zend_Controller_Front::getInstance()->getRequest()->getControllerName() . " : " . Zend_Controller_Front::getInstance()->getRequest()->getActionName();
            $data=curl_getinfo($ch);
            //insert api_log
            $db = Zend_Db_Table::getDefaultAdapter();
            $api_log_request_data=array(
                'request_dump'=>  json_encode($data),
                'request_timestamp'=>date("Y-m-d H:i:s"),
                'requested_by_script'=>$requested_by_script,
                'request_sent_to_url'=>$url,
                'request_method'=>''
            );
            $id = Core_BP_BaseTable::insert_new('api_log', $api_log_request_data);
            $response = curl_exec ($ch);          
             //update api_log
            $api_log_response_data=array(
                'response_dump'=>$response,
                'response_timestamp'=>date("Y-m-d H:i:s"),                                                
            );
            Core_BP_BaseTable::update_new('api_log', $api_log_response_data, 'id=' . $id);
            return $response;
        }
}
?>