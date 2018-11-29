<?
class Core_BP_Components_Users {
	function generateusername($email) {
        /*$arr = explode("@", $email);
        return $arr[0];*/
        return $email;
	}

    function generatepassword($count=7){
        $chars = "qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM1234567890";
        $charactersLength = strlen($chars);
        $generator = "";
        for($i=0; $i<$count; $i++){
            $generator .= $chars[rand(0, $charactersLength - 1)];
        }
        return $generator;
    }
}