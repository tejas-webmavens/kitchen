<?
class Core_BP_Components_Array {
	function find_in_array($find_val, $_array) {
		foreach ($_array as $array) {
			if($array['id']==$find_val){
				return true;
			}
		}
		return false;
	}

	function html_special_chars($data = array()){
		foreach ($data as $key => $_data) {
			if(is_array($_data)){
				$new_data[$key] = Core_BP_Components_Array::html_special_chars($_data);
			}
			else{
				$new_data[$key] = htmlspecialchars($_data);
			}	
		}
		return $new_data;
	}
}