<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Core_BP_Custom
{
    public static function check_num($number) {
        if ($number > 1) {
            throw new Exception("The value has to be 1 or lower");
        }
        return true;
    }

	public function encode1($string, $key) {
		    $key = sha1($key);
		    $strLen = strlen($string);
		    $keyLen = strlen($key);
		    $j = 0;
		    $hash = "";
		    for ($i = 0; $i < $strLen; $i++) {
		        $ordStr = ord(substr($string, $i, 1));
		        if ($j == $keyLen) {
		            $j = 0;
		        }
		        $ordKey = ord(substr($key, $j, 1));
		        $j++;
		        $hash .= strrev(base_convert(dechex($ordStr + $ordKey), 16, 36));
		    }
    	return $hash;
	}
    function decode1($string, $key) {
        $key = sha1($key);
        $strLen = strlen($string);
        $keyLen = strlen($key);
        $j = 0;
        $hash = "";
        for ($i = 0; $i < $strLen; $i+=2) {
            $ordStr = hexdec(base_convert(strrev(substr($string, $i, 2)), 36, 16));
            if ($j == $keyLen) {
                $j = 0;
            }
            $ordKey = ord(substr($key, $j, 1));
            $j++;
            $hash .= chr($ordStr - $ordKey);
        }
        return $hash;
    }
	public function check_rec_count($table_name,  $wh) {
        $db = Zend_Db_Table::getDefaultAdapter();
        //select data
        $query_check_record = "SELECT COUNT(*) AS count FROM " . $table_name . " WHERE " . $wh;
        $res = $db->query($query_check_record);
        $_data = $res->fetch();
        if ($_data['count'] == 0) {
            
            //update record
           return false;
        } else {
            //insert record
           return true;
        }
    }
    public function check_token($table, $where){
        $db = Zend_Db_Table::getDefaultAdapter();
        $sets = array();
        $query = "select email from `{$table}` where token='{$where}'";
        $res = $db->query($query);
        $_data = $res->fetch();
        return $result;
    }	
}
