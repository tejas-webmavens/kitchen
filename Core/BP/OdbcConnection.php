<?php
abstract class Core_BP_OdbcConnection extends Zend_Db_Table
{
	public function connect(){
		try{
			$db = new PDO ("odbc:MAS_HRB");
			return $db;
		}
		catch(PDOException $ex){
			die(json_encode(array('outcome' => false, 'message' => 'Unable to connect')));
		}
	}
	public function get_results($query){
		$response = array();
		$db = Core_BP_OdbcConnection::connect();
		$res = $db->query($query);
		foreach($db->query($query) AS $row){
			$row = Core_BP_OdbcConnection::createAssocArr($row);
			$response[] = $row;
		}
		return $response;
	}

	private function createAssocArr($arr){
		foreach ($arr as $key => $value) {
		    if (is_int($key)) {
		        unset($arr[$key]);
		    }
		}
		return $arr;
	}

	
	private function getAuditExceptionTables(){
		return array('log_users','error_log','history','mail_sentlog','api_log');
	}
}
?>