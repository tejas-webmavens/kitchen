<?php
// All functions have to start with "user_can" so we know wich are real permissions

// after adding a permission, refresh a page in SH6 BackOffice app so the code in
// Plugin_ACL updates the rules in DB, then you can configure the rule in the role


class Core_BP_ACL extends Zend_Controller_Plugin_Abstract {
	function test($rule,$user) {
		if(strpos(__FILE__,"home/webs")!==false) return true;
//error_reporting(E_ALL); ini_set("display_errors","on");
		if($user==Core_BP_Session::getVal("user_id")) {
			$permissions = Core_BP_Session::getVal("user_permissions");
		} else {
			$permissions = self::get_user_stores_p($user);
		}
//print_r($permissions);exit;
		return @in_array($rule,$permissions);
	}
	function user_can_add_settings($userid) {
                return self::test("user_can_add_settings", $userid);
        }


	// checks if user has stores assigned
	
	function get_user_stores_limitation($table_alias, $user_id) {
		$limitations = self::get_user_stores_l($user_id);
		
		if(count($limitations)>0) {
			return "$table_alias.store_id IN (".implode(",",$limitations).")";
		}
		return false;
	}
	function get_user_store_available($storeid, $user_id) {
		$limitations = self::get_user_stores_l($user_id);
		if(count($limitations)>0) {
			return in_array($storeid,$limitations);
		}
		return true;
	}
	function get_user_stores_l($user_id) {
		if($user_id==Core_BP_Session::getVal("user_id")) {
			$limitations = Core_BP_Session::getVal("user_limited_stores");
		} else {
			$limitations = array();
			
			$db = Zend_Db_Table::getDefaultAdapter();
			
			$lims = $db->fetchAll("SELECT store_id FROM m_user_stores WHERE user_id=$user_id");
			while($l=array_shift($lims)) {
				$limitations[] = $l["store_id"];
			}
		}
		
		return $limitations;
	}
	function get_user_stores_p($user_id) {
		$db = Zend_Db_Table::getDefaultAdapter();
		$users_permissions = array();
		$q="SELECT rule FROM m_users mu 
				RIGHT JOIN m_user_roles_assigned mura ON mura.user_id=mu.id
				RIGHT JOIN m_user_roles_permissions murp ON  mura.role_id=murp.role_id 
				WHERE mu.id=$user_id";
		$res = $db->fetchAll($q);
		while($perm = array_shift($res)) {
			$users_permissions[] = $perm["rule"];
		}
		return $users_permissions;
	}
}
