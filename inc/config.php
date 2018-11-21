<?php
if ($_SERVER['HTTP_HOST'] == '23.89.193.244'){
	$db_username = "";
	$db_password = "";
	$db_name = "";
	$db_host = "";
}	else {
 	$db_username = "root";
	$db_password = "123";
	$db_name = "kitchenk";
	$db_host = "localhost";
}

$dbh=mysqli_connect($db_host, $db_username, $db_password, $db_name) or die ('You need to set your database connection in includes/db.php.</td></tr></table></body></html>');
?>