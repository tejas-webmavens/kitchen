<?php

class UserController extends Zend_Controller_Action
{
        public function init() 
	{
                 $db = Zend_Db_Table::getDefaultAdapter();
                 $db->query("SET @app_username='Cron'");		 
	}
	public function loginAction() {
		$this->_helper->layout()->disableLayout();  
		
		$db = Zend_Db_Table::getDefaultAdapter();
		
		
		$username = $this->getRequest()->getParam('username');
		$this->view->username = $username;
		//$_pass=$this->getRequest()->getParam('password');
                $_pass=$_POST['password'];
		$password = md5($_pass);
		if($username!="" && $_pass!="") {
			$res = $db->query("SELECT id,username FROM m_users WHERE username='$username' AND `password`='$password'");
			if($row=$res->fetch()) {
				$session = Core_BP_Session::get();
				
				$session->user_id = $row["id"];
				$session->user_name = $row["username"];
				
				$_sets = array("user_id" => $row["id"],
							"datetime" => date('Y-m-j H:i:s'),
							"ip_address" => @$_SERVER["REMOTE_ADDR"],
							"referrer" => 2,
							"action" => 1);
				$this->db->insert("log_users", $_sets);
				
				$user_limitations = array();								
				$user_permissions = Core_BP_ACL::get_user_stores_p($row["id"]);
				Core_BP_Session::setVal("user_permissions", $user_permissions);
				 
				if($this->view->ref!="") {
					header("Location: ".base64_decode($this->view->ref));
				} else {
					header("Location: /index");
				}
				exit;
			} else {
			
				$this->view->invalid_login=1;
			}
			
		}
		
	}
	public function logoutAction() {
		$session = Core_BP_Session::get();
		$_sets = array("user_id" => $session->user_id,
					"datetime" => date('Y-m-j H:i:s'),
					"ip_address" => @$_SERVER["REMOTE_ADDR"],
					"referrer" => 2,
					"action" => 0);
		$this->db->insert("log_users", $_sets);
		$session->user_id = 0;
		$session->user_name = "";
		
		Core_BP_Session::setVal("user_id",0);
		Core_BP_Session::setVal("user_name","");		
		
		$username = $this->getRequest()->getParam('username');
		$iframe = $this->getRequest()->getParam('iframe');
		header("Location: /user/login/");
		exit;
	}
}
