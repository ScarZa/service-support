<?php
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '1234';
$dbname = 'hrd';
$dbport = '3306';
$db=new mysqli("$dbhost","$dbuser","$dbpass","$dbname","$dbport");
if($db->connect_errno) die ('Connect Failed! :'.mysqli_connect_error ());
$db->set_charset('utf8');
//connect PDO
//$dbh = new PDO('mysql:host='.$dbhost.';dbname='.$dbname.';charset=utf8',''.$dbuser.'',''.$dbpass.'');

?>
