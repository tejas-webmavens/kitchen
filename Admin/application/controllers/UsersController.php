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
		$email = $_POST['email'];
		$password = $_POST['password'];
		$confirm = $_POST['confirm'];
		$this->view->msg="";
		$data['email'] = $email;
		if(isset($data['email']) && isset($password) && $data['email']!=='' && $password !=='' ){
			$valid=true;
			$wh1 = "email='".$data['email']."'";
			$avail = Core_BP_Custom::check_rec_count('users',$wh1);
		}
		if($avail){
			$this->view->msg="email is already exists";
		}
		else{
			if($valid){
				$token = uniqid();
				$pswd = $password;
				$data['password'] = Core_BP_Custom::encode1($token,$pswd);
				$data['token'] = $token; 
				$res = $this->db->insert("users",$data);
				$this->view->msg="Successfully added";
			}	
		}
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
		$this->view->msg="";
		$data['email'] = $email;
		if(isset($data['email']) || isset($password) && $data['email'] !=='' && $password !==''){
			$valid=true;
			$wh1 = "email='".$data['email']."'";
			$avail = Core_BP_Custom::check_rec_count('users',$wh1);
		}
		if($avail){
			$this->view->msg="email is already exists";
		}
		else{
			if($valid){
				$token = uniqid();
				$em = array_shift($data['email']);
				$pswd = Core_BP_Custom::encode1($token,$password);
				$data = $this->db->query("UPDATE users SET email= '".$em."',password='".$pswd."' where id = '".$user_id."'");
				$this->view->msg="succefully updated";
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
		$user_id = $_GET['user_id'];
		$this->view->userid=$user_id;
		$log_date_query = $this->db->query("select id, STR_TO_DATE(start_time, '%Y-%m-%d') as dates from users_log where user_id = '".$user_id."' GROUP BY STR_TO_DATE(start_time, '%Y-%m-%d') ORDER BY start_time DESC ");
		$log_date = $log_date_query->fetchAll();
	
		echo "<pre>";
		$this->view->log_date=$log_date;
		$display_dates =  array();

		$count = 0;
		foreach ($log_date as $dates) {
			$query_get_users_log = "select * from users_log where user_id='".$user_id."' AND STR_TO_DATE(start_time, '%Y-%m-%d') = '".$dates['dates']."' ORDER BY start_time DESC ";
			$time_query = $this->db->query($query_get_users_log);
			$log_time = $time_query->fetchAll();
			
			foreach ($log_time as $_log_time) {
				$display_dates[$dates['dates']][] = $_log_time['start_time'];
				$display_dates[$dates['id']][] = $_log_time['start_time'];
				$display_data[$_log_time['id']][$count]['id'] = $_log_time['id'];
				$display_data[$_log_time['id']][$count]['start_time'] = $_log_time['start_time'];
				$display_data[$_log_time['id']][$count]['share_count'] = $_log_time['share_count'];
				$display_data[$_log_time['id']][$count]['image_view_log'] = $_log_time['image_view_log'];

				$query_rates_log = "select * from rates_log where user_id='".$user_id."' AND users_log_id ='".$_log_time['id']."' order by rounds";
				$res_rates_log = $this->db->query($query_rates_log);
				$data_rates_log = $res_rates_log->fetchAll();
				// print_r($data_rates_log);
				$display_data[$_log_time['id']][$count]['images'] = $data_rates_log;

				foreach ($data_rates_log as  $rounds_data) {
					// $display_data[$rounds_data['rounds']] = $data_rates_log;
				$query_rounds = "select * from rates_log where user_id='".$user_id."' AND users_log_id ='".$_log_time['id']."' AND rounds ='".$rounds_data['rounds']."' ";

				$res_rounds = $this->db->query($query_rounds);
				$data_rounds = $res_rounds->fetchAll();
					foreach($data_rounds as $rounds_count){

						 $display_data[$_log_time['id']][$count]['rounds'][$rounds_data['rounds']]['data'] = $data_rounds;
						  $display_data[$_log_time['id']][$count]['rounds'][$rounds_data['rounds']]['shared'] = $rounds_data['shared'];
						  $display_data[$_log_time['id']][$count]['rounds'][$rounds_data['rounds']]['viewed'] = $rounds_data['viewed'];
					}
				}
				// $display_data[$_log_time['id']][$count]['rounds'] = $data_rates_log;
					

				
			}
			$count++;
		}
		// print_r($display_data);
// die;
		$this->view->log_time=$display_dates;
		$this->view->rates_log=$display_data;
		// $details_query = $this->db->query("select id from users_log where user_id = '".$user_id."' ");
		// $users_log_id = $details_query->fetchAll();
		// foreach ($users_log_id as $key => $log_id) {
		// 		$data3_query = $this->db->query("select  * from rates_log where user_id='".$user_id."' AND users_log_id =  '".implode(',',$log_id)."' ");
		// 		$rate_data = $data3_query->fetchAll();
		// 		foreach ($rate_data as $key => $value) {
		// 		$display_data[$log_id['id']][] = $value;
		// 	}
			
		// }
// print_r($display_data);
// die;
		

	}
	public function deleteduserAction(){

	}
	public function blockeduserAction(){

	}
}
