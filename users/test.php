<?php
include_once('../inc/functions.php');
$string = "Tejas";
$key = "webmavens";
$encode = encode($string, $key);
echo "Encode:".$encode."<br>";
$decode = decode($encode, $key);
echo $decode;
?>