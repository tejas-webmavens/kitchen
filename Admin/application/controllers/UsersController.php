<?php
error_reporting(E_ALL);
ini_set('display_errors',0);
class UsersController extends Zend_Controller_Action
{
    public function init() 
	{
	      $this->start_date = Core_BP_Session::getVal("start_date");
		  $this->end_date = Core_BP_Session::getVal("end_date");
		  // $this->msg = Core_BP_Session::getVal("msg");
		  if($this->start_date==''){
				$this->start_date = date('Y-m-d');
				$this->end_date = date('Y-m-d');
				Core_BP_Session::setVal("start_date", $start_date);
				Core_BP_Session::setVal("end_date", $end_date);
			}
		  $this->db = Zend_Db_Table::getDefaultAdapter();
		  $this->perpage = 10;	 
		  $Count_active = Core_BP_Custom::count_data('users','active', $this->start_date,$this->end_date);
		  $this->view->activeCount = $Count_active;
		  Core_BP_Session::setVal("activeCount",$Count_active);
		  $Count_deactive = Core_BP_Custom::count_data('users','deactive', $this->start_date,$this->end_date);
		  $this->view->deactiveCount = $Count_deactive;
		  Core_BP_Session::setVal("deactiveCount",$Count_deactive);		
	}
	public function addnewAction() {
		$this->view->msg="";
		if($this->getRequest()->isPost()){
				$email = $this->_request->getPost('email');
				$password = $this->_request->getPost('password');
				$confirm = $this->_request->getPost('confirm');
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
	}
	public function activeuserAction() {
		$user_id = $_GET['id'];
		$active_query = $this->db->query("UPDATE users SET status='deactive' WHERE id = '".$user_id."'");
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
							$query_active = "select COUNT(id) AS count from users WHERE status='active' ";
							if($this->start_date ==''){
								$query_active .= "AND STR_TO_DATE(audit_created_date, '%Y-%m-%d')=CURDATE()";
							}
							else{
							$query_active .= "AND STR_TO_DATE(audit_created_date, '%Y-%m-%d')>='". $start_date."' AND STR_TO_DATE(audit_created_date, '%Y-%m-%d')<='". $end_date."'";
							}
							$res_active = $this->db->query($query_active);
							$Count_active =$res_active->fetchAll();
							$c = array_shift($Count_active);
							// $Count = $c['count'];
							$data_query = "select * from users WHERE status='active' ";
							if($start_date ==''){
								$data_query .= "AND STR_TO_DATE(audit_created_date, '%Y-%m-%d') = CURDATE()";
							}
							else{
								$data_query .= "AND STR_TO_DATE(audit_created_date, '%Y-%m-%d')>='".$start_date."' AND STR_TO_DATE(audit_created_date, '%Y-%m-%d')<='".$end_date."''".$limit."'";
							}
							$res = $this->db->query($data_query);
							$res_data =$res->fetchAll();
					if($this->getRequest()->isPost()){
						$id = $this->_request->getPost('id');
						$email = $this->_request->getPost('email');
						$games_played = $this->_request->getPost('games_played');
						$total_time_spent = $this->_request->getPost('total_time_spent');
						$total_shares = $this->_request->getPost('total_shares');
							$query_active = "select COUNT(id) AS count from users WHERE status='active' ";
							if(isset($id) && $id !== ''){
								$query_active .= " AND id LIKE '%{$id}%' ";
							}
							if(isset($email) && $email !== ''){
								$query_active .= "AND email LIKE '%{$email}%' ";
							}
							if(isset($games_played) && $games_played !== ''){
								$query_active .= "AND games_played  LIKE '%{$games_played}% '";
							}
							if(isset($total_time_spent) && $total_time_spent !== ''){
								$query_active .= "AND total_time_spent  LIKE '%{$total_time_spent}% '";
							}
							if(isset($total_shares) && $total_shares !== ''){
								$query_active .= "AND total_shares  LIKE '%{$total_shares}% ' ";
							}
							if($this->start_date ==''){
								$query_active .= "AND STR_TO_DATE(audit_created_date, '%Y-%m-%d')=CURDATE()";
							}
							else{
								$query_active .= "AND STR_TO_DATE(audit_created_date, '%Y-%m-%d')>='". $start_date."' AND STR_TO_DATE(audit_created_date, '%Y-%m-%d')<='". $end_date."'";
							}
							$res_active = $this->db->query($query_active);
							$Count_active =$res_active->fetchAll();
							$c = array_shift($Count_active);
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
								}
					$data = $res_data;
					$Count = $c['count'];
					$this->view->start_date = $start_date;
					$this->view->end_date = $end_date;
					$this->view->active = $data;
					$this->view->pagination = Core_BP_Components_Pagination::display($Count, $offset, $this->perpage, $page, 'users/activeuser', $link_param);	
	}
	public function deactiveuserAction(){
		
		$user_id = $_GET['id'];
		$deactive_query = $this->db->query("UPDATE users SET status='active' WHERE id = '".$user_id."'");
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

			$query_deactive = "select COUNT(id) AS count from users WHERE status='deactive' ";
			if($this->start_date ==''){
				$query_deactive .= "AND STR_TO_DATE(audit_created_date, '%Y-%m-%d')=CURDATE()";
			}
			else{
				$query_deactive .= "AND STR_TO_DATE(audit_created_date, '%Y-%m-%d')>='". $start_date."' AND STR_TO_DATE(audit_created_date, '%Y-%m-%d')<='". $end_date."'";
			}
			$res_deactive = $this->db->query($query_deactive);
			$Count_data =$res_deactive->fetchAll();
			$c = array_shift($Count_data);
			$data_query = "select * from users WHERE status='deactive' ";
			if($start_date ==''){
				$data_query .= "AND STR_TO_DATE(audit_created_date, '%Y-%m-%d') = CURDATE()";
			}
			else{
				$data_query .= "AND STR_TO_DATE(audit_created_date, '%Y-%m-%d')>='".$start_date."' AND STR_TO_DATE(audit_created_date, '%Y-%m-%d')<='".$end_date."''".$limit."'";
			}
			$res = $this->db->query($data_query);
			$res_data =$res->fetchAll();
			if($this->getRequest()->isPost()){
					$id = $this->_request->getPost('id');
					$email = $this->_request->getPost('email');
					$games_played = $this->_request->getPost('games_played');
					$total_time_spent = $this->_request->getPost('total_time_spent');
					$total_shares = $this->_request->getPost('total_shares');	

					$query_deactive = "select COUNT(id) AS count from users WHERE status='deactive' ";
					if(isset($id) && $id !== ''){
						$query_deactive .= " AND id LIKE '%{$id}%' ";
					}
					if(isset($email) && $email !== ''){
						$query_deactive .= "AND email LIKE '%{$email}%' ";
					}
					if(isset($games_played) && $games_played !== ''){
						$query_deactive .= "AND games_played  LIKE '%{$games_played}% '";
					}
					if(isset($total_time_spent) && $total_time_spent !== ''){
						$query_deactive .= "AND total_time_spent  LIKE '%{$total_time_spent}% '";
					}
					if(isset($total_shares) && $total_shares !== ''){
						$query_deactive .= "AND total_shares  LIKE '%{$total_shares}% ' ";
					}
					if($this->start_date ==''){
						$query_deactive .= "AND STR_TO_DATE(audit_created_date, '%Y-%m-%d')=CURDATE()";
					}
					else{
						$query_deactive .= "AND STR_TO_DATE(audit_created_date, '%Y-%m-%d')>='". $start_date."' AND STR_TO_DATE(audit_created_date, '%Y-%m-%d')<='". $end_date."'";
					}
					$res_deactive = $this->db->query($query_deactive);
					$Count_data =$res_deactive->fetchAll();
					$c = array_shift($Count_data);
					

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
				}
			$data = $res_data;
			$Count_deactive = $c['count'];
			$this->view->start_date = $start_date;
			$this->view->end_date = $end_date;
			Core_BP_Session::setVal("deactiveCount", $Count);
			$this->view->deactive = $data;
			$this->view->pagination = Core_BP_Components_Pagination::display($Count_deactive, $offset, $this->perpage, $page, 'users/deactiveuser', $link_param);

	}
	public function edituserAction(){
		$user_id = $_GET['id'];
		$details_query = $this->db->query("select * from users where id = '".$user_id."' ");
		$res_details = $details_query->fetchAll();
		$details = array_shift($res_details);	
		$this->view->useredit = $details;
		$token = $details['token'];
		$em = $details['email'];
		$old_pwd = $details['password'];
		$this->view->msg="";
		if($this->getRequest()->isPost()){
				$email = $this->_request->getPost('email');
				$password = $this->_request->getPost('password');
				$confirm = $this->_request->getPost('confirm');
				if(isset($email) || isset($password) && $email !=='' && $password !==''){
					if($em !== $email){
						 $data['email'] = $email;
						$wh1 = "email='".$data['email']."'";
						$avail = Core_BP_Custom::check_rec_count('users',$wh1);
						if($avail){
							$msg = "email already exists";
							Core_BP_Session::setVal("msg", $msg);
							}
						else{
							 $data = $this->db->query("UPDATE users SET email= '".$email."' where id = '".$user_id."'");
							 $msg = "succefully updated email";
							 Core_BP_Session::setVal("msg", $msg);
						}	
					}
					if($old_pwd !== $password){
						$new_password = Core_BP_Custom::encode1($password,$token);
						$data = $this->db->query("UPDATE users SET password='".$new_password."' where id = '".$user_id."'");
						 $msg = "succefully updated password";
							 Core_BP_Session::setVal("msg", $msg);
					}
					// if($em !== $email && $old_pwd !== $password ){
						
					// 	// $data['email'] = $email;
					// 	$wh1 = "email='".$email."'";
					// 	$avail = Core_BP_Custom::check_rec_count('users',$wh1);
						
					// 	if(!$avail){
					// 		$msg = "email already exists";
					// 		Core_BP_Session::setVal("msg", $msg);
					// 	}
					// 	else{
					// 		$new_password = Core_BP_Custom::encode1($password,$token);
					// 		echo "UPDATE users SET email= '".$data['email']."',password='".$new_password."' where id = '".$user_id."'";
					// 		 $data = $this->db->query("UPDATE users SET email= '".$data['email']."',password='".$new_password."' where id = '".$user_id."'");

					// 		 $msg = "succefully updated email and password";
					// 		 Core_BP_Session::setVal("msg", $msg);
					// 	}
					// }
					header("Location: activeuser");
				}
		}	
			
	}
	public function userdetailsAction(){
		$user_id = $_GET['id'];
		$details_query = $this->db->query("select * from users where id = '".$user_id."' ");
		$res_details = $details_query->fetchAll();
		$details = array_shift($res_details);	
		$this->view->userdetails = $details;
		$date_query = $this->db->query("select DISTINCT STR_TO_DATE(start_time, '%Y-%m-%d') as dates  from users_log where user_id = '".$user_id."' ");
		$res_date = $date_query->fetchAll();
		foreach ($res_date as $value) {
				$data_query = $this->db->query("select  * from users_log where user_id='".$user_id."' AND STR_TO_DATE(start_time, '%Y-%m-%d') =  '".$value['dates']."' ");
				$res_data = $data_query->fetchAll();
				foreach($res_data as $data){
					$display_dates[$value['dates']][] = $data;
					// $display_dates[$value['dates']]['total_time_spend'] = $data['total_time_spend'];
				}
		}
		 $this->view->userlogs=$display_dates;
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
				$display_data[$_log_time['id']][$count]['images'] = $data_rates_log;

				foreach ($data_rates_log as  $rounds_data) {
				$query_rounds = "select * from rates_log where user_id='".$user_id."' AND users_log_id ='".$_log_time['id']."' AND rounds ='".$rounds_data['rounds']."' ";

				$res_rounds = $this->db->query($query_rounds);
				$data_rounds = $res_rounds->fetchAll();
					foreach($data_rounds as $rounds_count){

						 $display_data[$_log_time['id']][$count]['rounds'][$rounds_data['rounds']]['data'] = $data_rounds;
						  $display_data[$_log_time['id']][$count]['rounds'][$rounds_data['rounds']]['shared'] = $rounds_data['shared'];
						  $display_data[$_log_time['id']][$count]['rounds'][$rounds_data['rounds']]['viewed'] = $rounds_data['viewed'];
					}
				}					
			}
			$count++;
		}
		$this->view->log_time=$display_dates;
		$this->view->rates_log=$display_data;
	}
	public function deleteduserAction(){

	}
	public function blockeduserAction(){

	}
}
