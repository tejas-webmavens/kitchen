<?php
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
function get_id($table, $where, $con){
	global $dbh;
    $sets = array();
    $query = "select id from `{$table}` where $where";
    $result = sql($query,$con);
	return $result;
}
function check_rec_count($table,$where1,$dbh){
	global $dbh;
    $sets = array();
    $query = "select count(*) as counts from `{$table}` where $where1";
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
function get_images($table,$con){
    global $dbh;
    $sets = array();
    $query = "select image_id from `{$table}`  limit 8";
    $result = sql($query,$con);
    return $result;
}
?>