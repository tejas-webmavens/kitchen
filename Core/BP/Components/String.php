<?
class Core_BP_Components_String {
	function getwords($string, $count = 15) {
		$string = strip_tags($string);
        preg_match("/(?:\w+(?:\W+|$)){0,$count}/", $string, $matches);
        return $matches[0];
	}
	function removelinebreak($string){
		$string = strip_tags($string);
		return $string;
	}
	function encrypt_url($string){
		$string = md5($string);

		return $string;
	}
}