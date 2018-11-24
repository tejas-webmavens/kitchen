<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Core_BP_Settings {        
    
    const ENCRYPTION_KEY= "!@#$%^&*123";
    public static function get_setting($slug)
    {
        //check if available in session, and return from there, if not , fetch and save.
        //before returning data, decruypt everytime in runtime.
        $db = Zend_Db_Table::getDefaultAdapter();            
        if(Core_BP_Session::getVal($slug)){                          
            $setting_details_row=array_shift((Core_BP_Session::getVal($slug)));                        
            if($setting_details_row['encrypted']==1)                                  
                return Core_BP_Settings::decrypt($setting_details_row['setting_value']);            
            else 
                return $setting_details_row['setting_value'];
        }
        else {                                     
            $setting_details = $db->fetchAll("SELECT setting_slug,setting_value,encrypted FROM settings WHERE setting_slug='$slug' limit 1");                    
            Core_BP_Session::setVal($slug,  $setting_details);
            $setting_details_row=array_shift($setting_details);
            if($setting_details_row['encrypted']==1)
                return Core_BP_Settings::decrypt($setting_details_row['setting_value']);            
            else
                return $setting_details_row['setting_value'];
        }   
        
    }
    //function to encryupt setting
    function encrypte_old($data)
    {
        return base64_encode($data);
    }
    //function to decrypt setting
    function decrypt_old($data)
    {
        return base64_decode($data);
    }  
    //Returns an encrypted & utf8-encoded
    public static function encrypt($pure_string) {       
        $encryption_key=self::ENCRYPTION_KEY;
        $iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        $encrypted_string = mcrypt_encrypt(MCRYPT_BLOWFISH, $encryption_key, utf8_encode($pure_string), MCRYPT_MODE_ECB, $iv);
        return $encrypted_string;
    }
    //Returns decrypted original string
    public static function decrypt($encrypted_string) {   
        $encryption_key=self::ENCRYPTION_KEY;
        $iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        $decrypted_string = mcrypt_decrypt(MCRYPT_BLOWFISH, $encryption_key, $encrypted_string, MCRYPT_MODE_ECB, $iv);
        return preg_replace('/\\0/', "", $decrypted_string);        
    }
}