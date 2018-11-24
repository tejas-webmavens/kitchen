<?
class Core_BP_Components_Mail {
	function getemaildata($mail_type="default", $_data = array()) {
        if($mail_type=="default"){
            $core_email = Core_BP_Helpers::coreRegistry('email');
            $data['from'] = $core_email['default'];
            $data['cc'] = "CC";
            $data['bcc'] = "BCC";
            $data['subject'] = "subject";
            $data['body'] = "DEFAULT TEMPLATE";
            $data['attachment'] = "attachment";
        }
        else{
            $db = Zend_Db_Table::getDefaultAdapter();

            $query_get_template = "SELECT `from`, `to`, `cc`, `bcc`, `subject`, `body` FROM mail_templates WHERE template_name='".$mail_type."'";
            $res_template = $db->query($query_get_template);
            $data_template = $res_template->fetch();

            $data['from'] = $data_template['from'];
            $data['cc'] = $data_template['cc'];
            $data['bcc'] = $data_template['bcc'];
            $data['subject'] = $data_template['subject'];
            $data['body'] = $data_template['body'];

        }

        $data['from'] = Core_BP_Components_Mail::apply_values($data['from'], $_data);
        $data['subject'] = Core_BP_Components_Mail::apply_values($data['subject'], $_data);
        $data['body'] = Core_BP_Components_Mail::apply_values($data['body'], $_data);
        return $data;
	}

    function sendmailqueue(){
        $db = Zend_Db_Table::getDefaultAdapter();
        $query_mail_queue = "SELECT * FROM mail_queue WHERE failed=0";
        $res_mail_queue = $db->query($query_mail_queue);
        $data_mail_queue = $res_mail_queue->fetchAll();
        
        if(count($data_mail_queue)>0){
            foreach ($data_mail_queue as $_data) {
                $attachments = json_decode($_data['attachment']);
                $data['from_email'] = $_data['from_email'];
                $data['to_email'] = $_data['to_email'];
                $data['cc_email'] = $_data['cc_email'];
                $data['bcc_email'] = $_data['bcc_email'];
                $data['subject'] = $_data['subject'];
                $data['body'] = $_data['body'];
                $data['attachment'] = $attachments;
                $data['audit_created_by'] = $_data['audit_created_by'];

                $mail = new Core_BP_PHPMailer($data['from_email'], $data['from_email']);
                try{
                    $return = $mail->send($data['to_email'], $data['to_email'], $data['cc_email'], $data['bcc_email'], $data['subject'], $data['body'], $data['attachment'], $data['from_email']);
                    if($return){
                        //insert to sent mail
                        Core_BP_BaseTable::insert_new('sent_mail', $data);
                        //remove from queue
                        $wh = "id=".$_data['id'];
                        Core_BP_BaseTable::delete_new('mail_queue', $wh);
                    }
                    else{
                        $mail_queue = array();
                        $mail_queue['failed'] = 1;
                        $wh = "id=".$_data['id'];
                        Core_BP_BaseTable::update_new('mail_queue', $mail_queue, $wh);
                        unset($mail_queue);
                    }
                }
                catch(Exception $e){

                }
                unset($mail);
            }
        }
    }

    function apply_values($template, $params){
        $toreplace = array_keys($params);
        array_walk($toreplace,function(&$value){
            $value="{".$value."}";
        });
        $replace = array_values($params);
        return str_replace($toreplace,$replace,$template);
    }

    function clean_email($email){
        if (strpos($email, '"') !== false) {
            $email = explode('"', $email);
            return $email[1];
        }
        else{
            return $email;
        }
    }
}