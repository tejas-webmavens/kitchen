<?php

/**
 *
 * @author ThirdEye
 *
 */

abstract class Core_BP_Base extends Core_BP_BaseTable{

	private $empty = true;

	protected $tableName;

	private $identifier = "id";
	/**
	 *
	 * @var array
	 * @name dbFields
	 * @desc Holds the list of fields of the associated table with the current object
	 * that we need to interact with.
	 */
	protected $dbFields = array();

	/**
	 * @desc constructor
	 * @param $_idValue
	 * @return void
	 */


	private $validators = array();

	private $errors = array();

	private $isValid;

	private $error_msgs = "";

	private $references = array();

	public function __construct($_idValue=null){
		$this->_name = $this->tableName;


		parent::__construct();
		if($_idValue){
			$this->loadByIdentifier($this->getIdentifier(), $_idValue);
		}

	}

	public function getIdentifier(){
		return $this->identifier;
	}



	public final function isEmpty(){
		return $this->empty;
	}

	public final function isValid(){
		if(count($this->errors)>0){
			return false;
		}
		else
		{
			return true;
		}
	}


	/**
	 *
	 * @param $_value = identifier value using which you want load the data into the object from db
	 * @return current object
	 */

	public function loadByIdentifier($_identifier, $_value){

		//echo $_identifier."<br/>";
		//echo $_value."<br/>";

		$field_list = implode(",", $this->dbFields);

		//$db  = Zend_Registry::get('db');
		$db = Zend_Db_Table::getDefaultAdapter();

		$sql = "SELECT ". $field_list ." FROM ". $this->_name ." WHERE ". $_identifier ."= ? ";



		$stmt = $db->query($sql,  array($_value));

		$allrows = $stmt->fetchAll();

		if($allrows){
			$row = $allrows[0];
			foreach($row as $key=>$val){
				call_user_func(array($this,"set".$key),$val);
			}
			$this->empty = false;
		}
		return $this;

	}

	public function add(){
		$data = array();
		$passedCallback = true;

		foreach($this->dbFields as $field){
			$data[$field] = call_user_func(array($this,"get".$field));
		}


		if(method_exists($this,'beforeAdd')){
			$passedCallback = $this->beforeAdd();
		}

		if($passedCallback === true){
			$this->setId($this->insert($data));

			if(method_exists($this,'afterAdd')){
				$this->afterAdd();
			}
		}

		return $this->getId();
	}


	public function update(array $updateFields = NULL, $updateWhere = ""){

		$updatableFields = array();
		$updateFilter = "";

		$passedCallback = true;

		if(count($updateFields)>0){
			$updatableFields = $updateFields;
		}
		else{
			$updatableFields = $this->dbFields;
		}

		foreach($updatableFields as $field){
			$data[$field] = call_user_func(array($this,"get".$field));
		}

		if($updateWhere == ""){
			$updateFilter = " ". $this->getIdentifier() ." = ". $this->getId();

		}
		else{
			$updateFilter = $updateWhere;
		}

		if(method_exists($this,'beforeUpdate')){
			$passedCallback = $this->beforeUpdate();
		}

		if($passedCallback === true){
			parent::update($data, $updateFilter);
			if(method_exists($this,'afterUpdate')){
				$this->afterUpdate();
			}
		}
	}


	public function delete($deleteWhere = ""){
		$deleteFilter = "";

		$passedCallback = true;

		if($deleteWhere == ""){
			$deleteFilter = " ". $this->getIdentifier() ." = ". $this->getId();

		}
		else{
			$deleteFilter = $deleteWhere;
		}

		$totalReferences = $this->referenceExists();

		if(!$totalReferences){
			if(method_exists($this,'beforeDelete')){
				$passedCallback = $this->beforeDelete();
			}
				
			if($passedCallback === true){
				parent::delete($deleteFilter);
				if(method_exists($this,'afterDelete')){
					$this->afterDelete();
				}

				return 0; 	//zero references, deleted succesfully
			}
		}
		else{
			return $totalReferences;
		}



	}

	public function validate(){

		$this->executeValidation();

		if(!$this->isValid()){
			return false;
		}
		else
		{
			return true;
		}

	}

	private function executeValidation(){

		foreach($this->validators as $validator){
			$validatorName = "Zend_Validate_". $validator['validator'];
			$validate = new $validatorName;
			if($validatorName=="Zend_Validate_EmailAddress"){
				$mails=explode(",",call_user_func(array($this,"get". $validator['property'])));
				foreach($mails as $mail){
					$valid = $validate->isValid(trim($mail));
					if($valid == false){
						$this->appendError($validator['error_msg']);
					}
				}
			}else{
				$valid = $validate->isValid(call_user_func(array($this,"get". $validator['property'])));
				if($valid == false){
					$this->appendError($validator['error_msg']);
				}
			}

		}
		return $this->errors;

	}

	public function addValidator($validator, $property, $error_message){

		array_push($this->validators, array("validator"=> $validator,
											"property" => $property,
											"error_msg" => $error_message));
	}


	public function appendError($error_msg){
		array_push($this->errors,$error_msg);
	}


	public function getErrorList(){
		return $this->errors;
	}

	public function getErrorMessages(){

		$core_path  = self::CoreRegistry('bdk_core_path');
		$core_path .= "Validator/";

		$error_view = new Zend_View();
		$error_view->errors =  $this->errors;
			
		$error_view->addScriptPath($core_path);
		$this->error_msgs = $error_view->render("errorlist.phtml");

		return $this->error_msgs;
	}

	public function lookup($whereClause ="", $fetchFields = array(), $orderBy ="", $limit=""){

		$field_list = implode(",", $this->dbFields);



		if(count($fetchFields)>0){

			$field_list = implode(",", $fetchFields);
		}
		else{

			$field_list = implode(",", $this->dbFields);
			
			if(method_exists($this,"getAuditFieldList")) {
				if(!in_array($this->_name,$this->getAuditExceptionTables())){
					$field_list .= ",". $this->getAuditFieldList();					
				}
			}
		}

		//$db  = Zend_Registry::get('db');
		$db = Zend_Db_Table::getDefaultAdapter();

		$sql = "SELECT ". $field_list ." FROM ". $this->_name ." WHERE 1=1 ";

		if($whereClause != ""){
			$sql .= " AND ". $whereClause;
		}

		if($orderBy != ""){
			$sql .= " ORDER BY ". $orderBy;
		}

		if($limit != ""){
			$sql .= " LIMIT  ". $limit;
		}

	
		$results  = $db->fetchAll($sql);

		return $results;

	}




	public static function CoreRegistry($param){
		$registry = Zend_Registry::getInstance();

		return $registry->core_config->$param;
	}

	public static function AppRegistry($param){
		$registry = Zend_Registry::getInstance();
		return $registry->app_config->$param;
	}


	public function addReference($referencingObject, $referenceIdentifier){
		$this->references[$referencingObject] = $referenceIdentifier;
	}

	private function countReference($refIdentifier, $refValue){

		//$db  = Zend_Registry::get('db');
		$db = Zend_Db_Table::getDefaultAdapter();

		$sql = "SELECT count($refIdentifier) FROM ". $this->_name ." WHERE $refIdentifier = $refValue ";

		//echo $sql ."<br>";

		/*if($whereClause != ""){
			$sql .= " AND ". $whereClause;
			}*/
		$results  = $db->fetchOne($sql);

		return $results;

	}

	public function referenceExists(){

		$totalReferences = 0;

		foreach($this->references as $refObject=>$referenceIdentifier){
			$count = Factory::$refObject()->countReference($referenceIdentifier, $this->getId());
				
			if($count>0){
				$totalReferences ++;
			}
				
		}
		return $totalReferences;

	}
	
	public function query($sql){
				
		//$db = Zend_Registry::get('db');
		$db = Zend_Db_Table::getDefaultAdapter();
		$results  = $db->fetchAll($sql);
		
		return $results;
		
	}

}
?>
