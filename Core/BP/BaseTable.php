<?php

abstract class Core_BP_BaseTable extends Zend_Db_Table {

    public function insert_new($table_name, array $data) {
        if (!in_array($table_name, Core_BP_BaseTable::getAuditExceptionTables())) {
            if (is_array($data)) {
                if (!array_key_exists('audit_created_by', $data)) {
                    $data['audit_created_by'] = Core_BP_Session::getVal('username');
                    if ($data['audit_created_by'] == "") {
                        $data['audit_created_by'] = "Cron";
                    }
                }
                if (!array_key_exists('audit_created_date', $data)) {
                    $data['audit_created_date'] = date('Y-m-d H:i:s');
                }
                if (!array_key_exists('audit_ip', $data)) {
                    $data['audit_ip'] = $_SERVER['REMOTE_ADDR'];
                }
            }
        }

        $db = Zend_Db_Table::getDefaultAdapter();
        $db->insert($table_name, $data);
        $newID = $db->lastInsertId();
        return $newID;
    }

    public function update_new($table_name, array $data, $wh) {
        if (!in_array($table_name, Core_BP_BaseTable::getAuditExceptionTables())) {
            if (is_array($data)) {
                if (!array_key_exists('audit_updated_by', $data)) {
                    $data['audit_updated_by'] = Core_BP_Session::getVal('username');
                }
                if (!array_key_exists('audit_updated_date', $data)) {
                    $data['audit_updated_date'] = date('Y-m-d H:i:s');
                }
                if (!array_key_exists('audit_ip', $data)) {
                    //on update audit_ip doesn't update 2017-04-08
                    //$data['audit_ip'] = $_SERVER['REMOTE_ADDR'];
                }
            }
        }

        $db = Zend_Db_Table::getDefaultAdapter();
        $update_res = $db->update($table_name, $data, $wh);
        return $update_res;
    }

    public function delete_new($table_name, $wh) {
        $db = Zend_Db_Table::getDefaultAdapter();
        $delete_res = $db->delete($table_name, $wh);
        return $delete_res;
    }

    public function insertorupdate_new($table_name, $data, $wh) {
        $db = Zend_Db_Table::getDefaultAdapter();
        //select data
        $query_check_record = "SELECT COUNT(*) AS count FROM " . $table_name . " WHERE " . $wh;
        $res = $db->query($query_check_record);
        $_data = $res->fetch();
        if ($_data['count'] > 0) {
            //update record
            Core_BP_BaseTable::update_new($table_name, $data, $wh);
        } else {
            //insert record
            Core_BP_BaseTable::insert_new($table_name, $data);
        }
    }

    public function insert(array $data) {

        if (!in_array($this->_name, $this->getAuditExceptionTables())) {

            if (is_array($data)) {
                if (!array_key_exists('audit_created_by', $data)) {
                    $data['audit_created_by'] = Core_BP_Session::getVal('username');
                }
                if (!array_key_exists('audit_created_date', $data)) {
                    $data['audit_created_date'] = date('Y-m-d H:i:s');
                }
                if (!array_key_exists('audit_ip', $data)) {
                    $data['audit_ip'] = $_SERVER['REMOTE_ADDR'];
                }
            }
        }
        foreach ($data as $k => $d) {
            if ($d == "") {
                unset($data[$k]);
            }
        }
        //print_r($data);
        $newID = parent::insert($data);

        //$db  = Zend_Registry::get('db');
        $db = Zend_Db_Table::getDefaultAdapter();

        return $newID;


        //history logic here..
    }

    public function update(array $data, $where) {

        if (!in_array($this->_name, $this->getAuditExceptionTables())) {

            if (is_array($data)) {
                if (!array_key_exists('audit_updated_by', $data)) {
                    $data['audit_updated_by'] = Core_BP_Session::getVal('username');
                }
                if (!array_key_exists('audit_updated_date', $data)) {
                    $data['audit_updated_date'] = date('Y-m-d H:i:s');
                }
                if (!array_key_exists('audit_ip', $data)) {
                    //on update audit_ip doesn't update 2017-04-08
                    //$data['audit_ip'] = $_SERVER['REMOTE_ADDR'];
                }
            }
        }

        return parent::update($data, $where);
    }

    public function delete($where) {
        $rows_deleted = parent::delete($where);


        return $rows_deleted;

        //history log logic here..
    }

    private function getAuditExceptionTables() {
        return array('log_users', 'error_log', 'history', 'mail_sentlog', 'api_log', 'CI_Item', 'AR_CustomerContact', 'AR_Customer');
    }

    public function truncate($table_name) {
        $db = Zend_Db_Table::getDefaultAdapter();
        $query_truncate = "TRUNCATE TABLE " . $table_name;
        try {
            $db->query($query_truncate);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

}

?>