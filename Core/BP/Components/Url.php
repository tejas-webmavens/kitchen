<?
class Core_BP_Components_Url {
    function encrypt_assumption_url($id){
        return base64_encode($id);
    }

    function decrypt_assumption_url($id){
        return base64_decode($id);
    }
}