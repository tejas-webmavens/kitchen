<?
class Core_BP_Array {
	function intersect_key_dropship($arr,$key) {
		if(strpos($arr,"dropship_")===0) {
			return 0;
		} else {
			return -1;
		}
	}
	function diff_key_audit($arr,$key) {
		if(strpos($arr,"audit_")===0) {
			return 0;
		} else {
			return -1;
		}
	}
	function is_assoc($array) {
	  return (bool)count(array_filter(array_keys($array), 'is_string'));
	}
	function flip_keys($array){
		$new_array = array();
		foreach ($array as $outerKey=>$idata) {
		   	foreach ($idata as $innerKey=>$innerdata) {
		      	$new_array[$innerKey][$outerKey] = $innerdata;
		    }
		}

		return $new_array;
	}
}
