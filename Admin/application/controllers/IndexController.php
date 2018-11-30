<?php
error_reporting(E_ALL);
ini_set('display_errors',0);
class IndexController extends Zend_Controller_Action
{
	public function init(){
			
			$this->start_date = Core_BP_Session::getVal("start_date");
			$this->end_date = Core_BP_Session::getVal("end_date");

			if($this->start_date==''){
				$start_date = date('Y-m-d');
				$end_date = date('Y-m-d');
			}
			$this->db = Zend_Db_Table::getDefaultAdapter();
			$this->perpage = 50;	 	
	}
	public function indexAction() {

		$res = $this->db->query("SELECT * FROM users WHERE STR_TO_DATE(audit_created_date, '%Y-%m-%d') = CURDATE() ORDER BY audit_created_date DESC");

		if($row=$res->fetchAll()) {
			$this->view->user =$row;
		}
		$res1 = $this->db->query("SELECT * FROM app_ratings WHERE STR_TO_DATE(audit_created_date, '%Y-%m-%d') = CURDATE() ORDER BY audit_created_date DESC");

		if($row1=$res1->fetchAll()) {
			$this->view->rating =$row1;
		}		
	}
	public function ratingsAction() {
		
		
		$start_date = $this->getRequest()->getParam('start_date','');
		$end_date = $this->getRequest()->getParam('end_date','');
		
		if($start_date==''){
			$start_date = $this->start_date;
			$end_date = $this->end_date;
		}
		else{
			Core_BP_Session::setVal("start_date", $start_date);
			Core_BP_Session::setVal("end_date", $end_date);
		}

		
			$link_param = '?start_date='.$start_date.'&end_date='.$end_date;
			$offset = ($page-1)*$this->perpage;
			$limit = " LIMIT ".$this->perpage." OFFSET ".$offset;
			$id = $_POST['id'];
			$email = $_POST['email'];
			$ratings = $_POST['ratings'];
			$comments = $_POST['comments'];
			$id = mysql_real_escape_string($id);
			$email = mysql_real_escape_string($email);
			$ratings = mysql_real_escape_string($ratings);
			$comments = mysql_real_escape_string($comments);
			$query = "select COUNT(id) AS count from app_ratings WHERE 1 ";
			if(isset($id) && $id !== ''){
				$query .= " AND id LIKE '%{$id}%' ";
			}
			if(isset($email) && $email !== ''){
				$query .= "AND email LIKE '%{$email}%' ";
			}
			if(isset($ratings) && $ratings !== ''){
				$query .= "AND rate LIKE '%{$ratings}%' ";
			}
			if(isset($comments) && $comments !== ''){
				$query .= "AND comment  LIKE '%{$comments}% '";
			}
			if($start_date !==''){
				$query .= "AND STR_TO_DATE(audit_created_date, '%Y-%m-%d')=CURDATE()";
			}
			else{
				$query .= "AND STR_TO_DATE(audit_created_date, '%Y-%m-%d')>='".$start_date."' AND STR_TO_DATE(audit_created_date, '%Y-%m-%d')<='".$end_date."'";
			}
		
			
			
			$res = $this->db->query($query);
			$Count_data =$res->fetchAll();
			$Count = $Count_data['count'];

			$data_query = "select * from app_ratings WHERE 1 ";
			if(isset($id) && $id !== ''){
				$data_query .= " AND id LIKE '%{$id}%' ";
			}
			if(isset($email) && $email !== ''){
				$data_query .= "AND email LIKE '%{$email}%' ";
			}
			if(isset($ratings) && $ratings !== ''){
				$data_query .= "AND rate LIKE '%{$ratings}%' ";
			}
			if(isset($comments) && $comments !== ''){
				$data_query .= "AND comment  LIKE '%{$comments}%' ";
			}
			if($start_date ==''){
				$data_query .= "AND STR_TO_DATE(audit_created_date, '%Y-%m-%d') = CURDATE()";
			}
			else{
				$data_query .= "AND STR_TO_DATE(audit_created_date, '%Y-%m-%d')>='".$start_date."' AND STR_TO_DATE(audit_created_date, '%Y-%m-%d')<='".$end_date."''".$limit."'";
			}
		
			
			$res = $this->db->query($data_query);
			$res_data =$res->fetchAll();
			$data = $res_data;
			$this->view->start_date = $start_date;
			$this->view->end_date = $end_date;
			$this->view->Count = $Count;
			$this->view->rating = $data;
			$this->view->pagination = Core_BP_Components_Pagination::display($Count, $offset, $this->perpage, $page, 'http://localhost/kitchen/Admin/public/index/rating', $link_param);	

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
		
		
		header("Location: http://localhost/kitchen/Admin/public/index/login");
		exit;
	}
	public function loginAction(){
		$username=$_POST['username'];
        $_pass=$_POST['password'];
		if($username!="" && $_pass!="") {
			$res = $this->db->query("SELECT id,username FROM m_users WHERE username='$username' AND `password`='$_pass'");

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
				
				
				 
				if($this->view->ref!="") {
					header("Location: ".base64_decode($this->view->ref));
				} else {
					header("Location: http://localhost/kitchen/Admin/public/index/index");
				}
				exit;
			} else {
				
				$this->view->invalid_login=1;
			}
			
		}
	}
	public function registerAction(){
		
		
	}
	public function campaignsAction(){
		
		
	}
	public function conversationreportsAction(){
		
		
	}

}
	