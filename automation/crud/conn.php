<?php
        if($_SERVER['SERVER_NAME']=='zendboilerplate.local')
        {
            $host="localhost"; //Database host.
            $user="root"; //Database username.
            $pass="root"; //Database password.
            $dbname="orientation"; //Database.
        }
        else 
        {
            $host="localhost"; //Database host.
            $user="root"; //Database username.
            $pass="123"; //Database password.
            $dbname="zend_db"; //Database.
        }
	
	$link = mysql_connect($host,$user,$pass);
	if(!$link)
	{
		die('Cant open :'. mysql_error());
	}
	
	$db_selected = mysql_select_db($dbname,$link);
	if(!$db_selected)
	{
		die('Cant open database ' .mysql_error());
	}

	function bufferFlush($start=0){
		ob_end_flush();
		ob_flush();
		flush();
		if($start){
			ob_start();
	}
}  
?>