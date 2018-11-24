<?
class Core_BP_Dropdown {
	public function fill($table,$field="name",$id=0,$null_option="Select...",$wh=array(),$optgroup_by="",$debug=0,$distint=false,$return_array=false,$sql_order="",$disabled_cond="",$available_selected_one_item=true,$to_use_as_table_filter=false) {
		if(is_array($null_option)) {
			list($null_option, $do_not_preselect) = $null_option;
		}
		
		$db = Zend_Db_Table::getDefaultAdapter();
		$ret=array();
		$ret[] = $null_option!=""?"<option value=''>$null_option</option>":"";
		if(is_string($wh)) $wh = array($wh);
		
		if(count($wh)>0) {
			$where = "WHERE ".implode(" AND ", $wh);
		}
		if(is_array($field)) {
			$sql_field = "CONCAT_WS(' - ',".implode(",",$field).")";
		} else {
			$sql_field = $field;
		}
		
		if($sql_order==""){
			$sql_order = $sql_field;
		} 
		if($optgroup_by) {
			$sql_order = "$optgroup_by,$sql_order";
			$sql_field = "$optgroup_by,$sql_field";
		}
		
		$q="SELECT ".($distint?" DISTINCT ":"")." SQL_CALC_FOUND_ROWS id,$sql_field AS optiontext".($disabled_cond!=""?", $disabled_cond AS dsbld":"")." FROM $table $where ORDER BY $sql_order";
		if($debug>0){ echo $q;exit();}
		try{
			$res = $db->query($q);
			$row_tot = $db->fetchOne("SELECT FOUND_ROWS()");
		}catch(Exception $e){
			echo $q."<br>".Core_BP_Exception::processException($e);
			exit;
		}
		$optgrp_prev="";
		while($row=$res->fetch()) {
			if($optgroup_by!="" && $row[$optgroup_by]!=$optgrp_prev) {
				$ret[]= "<optgroup label='".ucwords($row[$optgroup_by])."'></optgroup>";
			}
			$optgrp_prev = $row[$optgroup_by];
			$ret[]= "<option ".($row["dsbld"]?"disabled":"")." value='".($to_use_as_table_filter?$row["optiontext"]:$row["id"])."' ".(!$do_not_preselect && ((Core_BP_Dropdown::is_option_selected($id,$row["id"]) || ($row_tot==1 && $available_selected_one_item)))?"selected='selected'":"").">".$row["optiontext"]."</option>";
		}
		$ret=array_filter($ret);
		return !$return_array?implode("",$ret):$ret;
	}
	function is_option_selected($pre,$id) {
		if(is_array($pre)) {
			return in_array($id,$pre);
		} else {
			return $pre==$id;
		}
	}
	public function custom_fill($data, $select=null, $null_option="Select...", $class_name=false){
		if(is_array($null_option)) {
			list($null_option, $do_not_preselect) = $null_option;
		}
		$ret=array();
		$ret[] = $null_option!=""?"<option value=''>$null_option</option>":"";
		foreach ($data as $_data) {
			if($_data['id']==$select){
				$str = "<option value='".$_data['id']."'";
				if($class_name){
					$str .= " class='opt_class_".$_data['class_name']."' ";
				}
				$str .= " selected>".$_data['val']."</option>";

				$ret[] = $str;
			}
			else{
				$str = "<option value='".$_data['id']."'";
				if($class_name){
					$str .= " class='opt_class_".$_data['class_name']."'";
				}
				$str .= " >".$_data['val']."</option>";

				$ret[] = $str;
			}
		}

		$ret=array_filter($ret);
		return implode("",$ret);
	}
	public function getLabelName($table, $id, $field="name", $wh="", $debug=0, $optgroup_by="", $return_array=false){
		$db = Zend_Db_Table::getDefaultAdapter();
		if($wh=="") {
			$where = "WHERE id=".$id;
		}
		if(is_array($field)) {
			$sql_field = "CONCAT_WS(' - ',".implode(",",$field).")";
		} else {
			$sql_field = $field;
		}
		
		if($sql_order==""){
			$sql_order = $sql_field;
		} 
		if($optgroup_by) {
			$sql_order = "$optgroup_by,$sql_order";
			$sql_field = "$optgroup_by,$sql_field";
		}

		$q="SELECT $sql_field FROM $table $where";
		if($debug>0){ echo $q;exit();}
		try{
			$res = $db->query($q);
		}catch(Exception $e){
			echo $q."<br>".Core_BP_Exception::processException($e);
			exit;
		}
		$return = "";
		while($row=$res->fetch()) {
			$return = array_shift($row);
		}
		return $return;
	}
}
