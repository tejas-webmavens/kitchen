<?php
class Core_BP_File{
	
	public function getFileExtension($path){
		$get_ext = explode('.', $path);
		$ext = $get_ext[count($get_ext)-1];
		if($ext==""){
			$ext = "Custom Drawing";
		}
		return $ext;
	}

}
?>
