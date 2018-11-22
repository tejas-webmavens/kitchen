<?php
function check_data($table, $where, $con){
	 global $dbh;
    $sets = array();
    $query = "select count(*) as counts from `{$table}` where email='{$where}'";
    $count = array_shift(sql($query));
    if ($count['counts'] == 0) {
        return true;
    } else {
        return false;
    }
}
function check_token($table, $where, $con){
	global $dbh;
	    $sets = array();
	    $query = "select email from `{$table}` where token='{$where}'";
	     $result = sql($query,$con);
		return $result;
}
function get_token($table, $where1, $con=''){
	global $dbh;
	    $query = "select token from `{$table}` where email='{$where1}'";
	    $result = sql($query,$con);
		return $result;
}
function check_login($table, $where1,$where2, $con){
	global $dbh;
	    $sets = array();
	    $query = "select count(*) as counts from `{$table}` where email='{$where1}' AND password='{$where2}'";
	    $count = array_shift(sql($query));
	    if ($count['counts'] == 0) {
	        return false;
	    } else {
	        return true;
	    }   
}
function check_pwd($table, $where1,$where2, $con){
	global $dbh;
	    $sets = array();
	    $query = "select count(*) as counts from `{$table}` where token='{$where1}' AND password='{$where2}'";
	    $count = array_shift(sql($query));
	    if ($count['counts'] == 0) {
	        return false;
	    } else {
	        return true;
	    }   
}
function check_email($table,$where1,$dbh){
	global $dbh;
	    $sets = array();
	    $query = "select count(*) as counts from `{$table}` where email='{$where1}'";
	    $count = array_shift(sql($query));
	    if ($count['counts'] == 0) {
	        return false;
	    } else {
	        return true;
	    }   
}
function get_id($table, $where, $con){
	global $dbh;
	    $sets = array();
	    $query = "select id from `{$table}` where $where";
	     $result = sql($query,$con);
		return $result;
}
function check_info($table,$where1,$where2,$dbh){
	global $dbh;
	    $sets = array();
	    $query = "select count(*) as counts from `{$table}` where $where1 AND $where2";
	    $count = array_shift(sql($query));
	    if ($count['counts'] == 0) {
	        return false;
	    } else {
	        return true;
	    }   
}
function check_status($table,$where,$con){
	global $dbh;
	    $sets = array();
	    $query = "select status from `{$table}` where token = '{$where}'";
	     $result = sql($query,$con);
		return $result;
}
?>