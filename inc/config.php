<?php
if ($_SERVER['HTTP_HOST'] == '23.89.193.244'){
	$db_username = "kitchenkraze_api";
	$db_password = "OKPN#esD&Jxb";
	$db_name = "kitchenkraze_api";
	$db_host = "23.89.193.244";
}	else {
 	$db_username = "root";
	$db_password = "123";
	$db_name = "kitchenk";
	$db_host = "localhost";
}

$dbh=mysqli_connect($db_host, $db_username, $db_password, $db_name) or die ('You need to set your database connection in includes/db.php.</td></tr></table></body></html>');
?>