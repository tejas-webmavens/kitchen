<?php
class Core_BP_Session {
        public static function get(&$check_last_session_time=0) {
		$config = Zend_Controller_Front::getInstance()->getParam('bootstrap');
		$session_timeout = $config->getOption("session_timeout");
		
		
		$jsonp = Zend_Controller_Front::getInstance()->getRequest()->getParam('jsonp');
		
		$ses = new Zend_Session_Namespace($config->getOption("appnamespace"));
		
		if($check_last_session_time===true) {
			$check_last_session_time = (time()-($ses->last_session_time))>$session_timeout;
		} elseif(!$jsonp) {
			$current_controller = Zend_Controller_Front::getInstance()->getRequest()->getControllerName();
			$current_action = Zend_Controller_Front::getInstance()->getRequest()->getActionName();
			if(!is_array($ses->resetted_session_time)) $ses->resetted_session_time=array();
			$ses->resetted_session_time[] = array("$current_controller/$current_action",debug_backtrace());
			$ses->resetted_session_time=array();
			$ses->last_session_time = time();
		}
		
		$ses->session_live_time = $session_timeout - (time()-($ses->last_session_time));
		$ses->session_timed_out = $ses->session_live_time>$session_timeout;
		
		return $ses;
	}
	public static function getVal($name) {
		$config = Zend_Controller_Front::getInstance()->getParam('bootstrap');
		$ses = new Zend_Session_Namespace($config->getOption("appnamespace"));
		
		return $ses->$name;
	}
	public static function setVal($name,$val) {
		$config = Zend_Controller_Front::getInstance()->getParam('bootstrap');
		$ses = new Zend_Session_Namespace($config->getOption("appnamespace"));
		$ses->$name=$val;
		return $this;
	}
	/**
	 * @@Desc Displays the operation success message and empties the sesssion variable
	 * @@return html of the display message;
	 *
	 */
	public static function displayMessage(){

		$message =  self::getMessage();
		$html = "";
		if($message){
			$html = "<div id=\"system_message\" class=\"\" style=\"font-size:12px;font-weight:bold;font-family:Verdana, Arial, Helvetica, sans-serif;color:#FFFFFF\" ><center>". $message ." </center></div>";
			self::setMessage('');
		}
		return $html;
	}
	public static function setMessage_old($_message){
		Core_BP_Session::setVal("sysappmsg",$_message);
		
		//return self;
	}
	
	
	public static function getMessage_old(){
		$ret = Core_BP_Session::getVal("sysappmsg");
		
		return $ret;
	}
	
	function queryprofiles($clean=0) {
		$session = self::get();
		$_query_uids = Core_BP_Session::getVal("_query_uids");
		$total = 0;
		if($clean) {
			if(is_array($_query_uids)) {
				foreach($_query_uids as $_q) {
					$_var = "query_$_q";
					unset($session->$_var);
				}
			}
			unset($session->_query_uids);
			Core_BP_Session::setVal("_query_uids",array());
		}
		$_query_uids = Core_BP_Session::getVal("_query_uids");
		
		$_qs = array();
		foreach($_query_uids as $u) {
			$q=Core_BP_Session::getVal("query_$u");
			list($query,$time) = explode(" => ",$q);
			$_qs["$time - $u"] = $query;
			$total+=$time;
		}
		echo "total $total<br><br>";
		krsort($_qs);
		foreach($_qs as $time => $u) {
			list($time) = explode(" - ", $time);
			echo "$time <i>$u</i><br>";
		}
		exit;
	}
        public static function setMessage($message,$type)
        {
            Core_BP_Session::setVal("alert_msg",$message);
            Core_BP_Session::setVal("alert_type",$type);
        }
        public static function getMessage()
        {
            $alert_msg = Core_BP_Session::getVal("alert_msg");            
            if($alert_msg!='')
            {
                if(Core_BP_Session::getVal("alert_type")=='success'){
                   $ret ='<div class="myadmin-alert myadmin-alert-icon myadmin-alert-click alert alert-success myadmin-alert-top alerttop" style="display: block;">'.$alert_msg.'</div>';
                }
                else if(Core_BP_Session::getVal("alert_type")=='error')
                {
                    $ret='<div class="myadmin-alert myadmin-alert-icon myadmin-alert-click alert alert-danger myadmin-alert-top alerttop" style="display: block;">'.$alert_msg.'</div>';
                }        
                Core_BP_Session::setVal("alert_msg","");
                Core_BP_Session::setVal("alert_type","");
                return $ret;
            }
        }
}
