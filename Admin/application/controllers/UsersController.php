<?php

class UsersController extends Zend_Controller_Action
{
        public function init() 
	{
                 // $db = Zend_Db_Table::getDefaultAdapter();
                 // $db->query("SET @app_username='Cron'");	
                  $this->_redirector = $this->_helper->getHelper('Redirector'); 	 
	}
	public function addnewAction() {
		
		
	}
	public function activeuserAction() {
		$db = Zend_Db_Table::getDefaultAdapter();
		
		
		$start_date = $this->getRequest()->getParam('start_date','');
		$end_date = $this->getRequest()->getParam('end_date','');
		// print_r($start_date);die();
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
		
			
			
			$res = $db->query($query);
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
		
			// print_r($data_query);die();
			
			$res = $db->query($data_query);
			$res_data =$res->fetchAll();
			$data = $res_data;
			$this->view->start_date = $start_date;
			$this->view->end_date = $end_date;
			$this->view->Count = $Count;
			$this->view->active = $data;
			$this->view->pagination = Core_BP_Components_Pagination::display($Count, $offset, $this->perpage, $page, 'http://localhost/kitchen/Admin/public/users/activeuser', $link_param);	
		
	}
	public function deactiveuserAction(){
		$db = Zend_Db_Table::getDefaultAdapter();
		
		
		$start_date = $this->getRequest()->getParam('start_date','');
		$end_date = $this->getRequest()->getParam('end_date','');
		// print_r($start_date);die();
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
		
			
			
			$res = $db->query($query);
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
		
			// print_r($data_query);die();
			
			$res = $db->query($data_query);
			$res_data =$res->fetchAll();
			$data = $res_data;
			$this->view->start_date = $start_date;
			$this->view->end_date = $end_date;
			$this->view->Count = $Count;
			$this->view->deactive = $data;
			$this->view->pagination = Core_BP_Components_Pagination::display($Count, $offset, $this->perpage, $page, 'http://localhost/kitchen/Admin/public/users/activeuser', $link_param);

	}
	public function edituserAction(){

	}
	public function userdetailsAction(){

	}
	public function gamedetailAction(){

	}
	public function deleteduserAction(){

	}
	public function blockeduserAction(){

	}
}
