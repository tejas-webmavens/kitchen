<?php
error_reporting(E_ALL);
ini_set('display_errors',0);
class UsersController extends Zend_Controller_Action
{
    public function init() 
	{
	      $this->start_date = Core_BP_Session::getVal("start_date");
		  $this->end_date = Core_BP_Session::getVal("end_date");
		  $this->Count = Core_BP_Session::getVal("Count");

			if($this->start_date==''){
				$start_date = date('Y-m-d');
				$end_date = date('Y-m-d');
			}
		  $this->db = Zend_Db_Table::getDefaultAdapter();
		  $this->perpage = 50;	 
		  
	}
	public function addnewAction() {
		
		
	}
	public function activeuserAction() {
		
		$user_id = $_GET['id'];
		$active_query = $this->db->query("UPDATE users SET status='active' WHERE id = '".$user_id."'");
		$start_date = $this->getRequest()->getParam('start_date','');
		$end_date = $this->getRequest()->getParam('end_date','');
		$page = $this->getRequest()->getParam('page', 1);

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
			$games_played = $_POST['games_played'];
			$total_time_spent = $_POST['total_time_spent'];
			$total_shares = $_POST['total_shares'];
			$id = mysql_real_escape_string($id);
			$email = mysql_real_escape_string($email);
			$games_played = mysql_real_escape_string($games_played);
			$total_time_spent = mysql_real_escape_string($total_time_spent);
			$total_shares = mysql_real_escape_string($total_shares);
			$query = "select COUNT(id) AS count from users WHERE status='active' ";
			if(isset($id) && $id !== ''){
				$query .= " AND id LIKE '%{$id}%' ";
			}
			if(isset($email) && $email !== ''){
				$query .= "AND email LIKE '%{$email}%' ";
			}
			if(isset($games_played) && $games_played !== ''){
				$query .= "AND games_played  LIKE '%{$games_played}% '";
			}
			if(isset($total_time_spent) && $total_time_spent !== ''){
				$query .= "AND total_time_spent  LIKE '%{$total_time_spent}% '";
			}
			if(isset($total_shares) && $total_shares !== ''){
				$query .= "AND total_shares  LIKE '%{$total_shares}% ' ";
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

			$data_query = "select * from users WHERE status='active' ";
			if(isset($id) && $id !== ''){
				$data_query .= " AND id LIKE '%{$id}%' ";
			}
			if(isset($email) && $email !== ''){
				$data_query .= "AND email LIKE '%{$email}%' ";
			}
			if(isset($games_played) && $games_played !== ''){
				$data_query .= "AND games_played  LIKE '%{$games_played}% ' ";
			}
			if(isset($total_time_spent) && $total_time_spent !== ''){
				$data_query .= "AND total_time_spent  LIKE '%{$total_time_spent}% ' ";
			}
			if(isset($total_shares) && $total_shares !== ''){
				$data_query .= "AND total_shares  LIKE '%{$total_shares}% '";
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
			Core_BP_Session::setVal("Count", $Count);
			$this->view->active = $data;
			$this->view->pagination = Core_BP_Components_Pagination::display($Count, $offset, $this->perpage, $page, 'http://localhost/kitchen/Admin/public/users/activeuser', $link_param);	
		
	}
	public function deactiveuserAction(){
		
		$user_id = $_GET['id'];
		$deactive_query = $this->db->query("UPDATE users SET status='deactive' WHERE id = '".$user_id."'");
		$start_date = $this->getRequest()->getParam('start_date','');
		$end_date = $this->getRequest()->getParam('end_date','');
		$page = $this->getRequest()->getParam('page', 1);
		
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
			$games_played = $_POST['games_played'];
			$total_time_spent = $_POST['total_time_spent'];
			$total_shares = $_POST['total_shares'];
			$id = mysql_real_escape_string($id);
			$email = mysql_real_escape_string($email);
			$games_played = mysql_real_escape_string($games_played);
			$total_time_spent = mysql_real_escape_string($total_time_spent);
			$total_shares = mysql_real_escape_string($total_shares);
			$query = "select COUNT(id) AS count from users WHERE status='deactive' ";
			if(isset($id) && $id !== ''){
				$query .= " AND id LIKE '%{$id}%' ";
			}
			if(isset($email) && $email !== ''){
				$query .= "AND email LIKE '%{$email}%' ";
			}
			if(isset($games_played) && $games_played !== ''){
				$query .= "AND games_played  LIKE '%{$games_played}% '";
			}
			if(isset($total_time_spent) && $total_time_spent !== ''){
				$query .= "AND total_time_spent  LIKE '%{$total_time_spent}% '";
			}
			if(isset($total_shares) && $total_shares !== ''){
				$query .= "AND total_shares  LIKE '%{$total_shares}% ' ";
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

			$data_query = "select * from users WHERE status='deactive' ";
			if(isset($id) && $id !== ''){
				$data_query .= " AND id LIKE '%{$id}%' ";
			}
			if(isset($email) && $email !== ''){
				$data_query .= "AND email LIKE '%{$email}%' ";
			}
			if(isset($games_played) && $games_played !== ''){
				$data_query .= "AND games_played  LIKE '%{$games_played}% ' ";
			}
			if(isset($total_time_spent) && $total_time_spent !== ''){
				$data_query .= "AND total_time_spent  LIKE '%{$total_time_spent}% ' ";
			}
			if(isset($total_shares) && $total_shares !== ''){
				$data_query .= "AND total_shares  LIKE '%{$total_shares}% '";
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
			$this->view->deactive = $data;
			$this->view->pagination = Core_BP_Components_Pagination::display($Count, $offset, $this->perpage, $page, 'http://localhost/kitchen/Admin/public/users/activeuser', $link_param);

	}
	public function edituserAction(){
		$user_id = $_GET['id'];
		$details_query = $this->db->query("select * from users where id = '".$user_id."' ");
		$res_details = $details_query->fetchAll();
		$details = array_shift($res_details);	
		$this->view->useredit = $details;
		$email = $_POST['email'];
		$password = $_POST['password'];
		$confirm = $_POST['confirm'];
		if(isset($email) || isset($password)){
			if($password == $confirm){
			$data = $this->db->query("UPDATE users SET email= '".$email."',password='".$password."' where id = '".$user_id."'");
			}
		}
		
	}
	public function userdetailsAction(){
		$user_id = $_GET['id'];
		$details_query = $this->db->query("select * from users where id = '".$user_id."' ");
		$res_details = $details_query->fetchAll();
		$details = array_shift($res_details);	
		$this->view->userdetails = $details;
		$date_query = $this->db->query("select DISTINCT STR_TO_DATE(start_time, '%Y-%m-%d') as start_time  from users_log where user_id = '".$user_id."' ");
		$res_date = $date_query->fetchAll();
		foreach ($res_date as $key => $value) {
				$v1[] = $value;
				$this->view->userdate=$v1;
				$data_query = $this->db->query("select  * from users_log where user_id='".$user_id."' AND STR_TO_DATE(start_time, '%Y-%m-%d') =  '".implode(',',$value)."' ");
				$res_data = $data_query->fetchAll();
				$res[]= $res_data;
				$this->view->userlogs=$res;
				
		}
		

	}	
	public function gamedetailAction(){

	}
	public function deleteduserAction(){

	}
	public function blockeduserAction(){

	}
}
