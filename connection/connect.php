<?php
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$dbname = 'hrd';
//connect mysqli
$db=new mysqli("$dbhost","$dbuser","$dbpass","$dbname");
if($db->connect_errno) die ('Connect Failed! :'.mysqli_connect_error ());
$db->set_charset('utf8');
//connect PDO
$dbh = new PDO('mysql:host='.$dbhost.';dbname='.$dbname.';charset=utf8',''.$dbuser.'',''.$dbpass.'');

?>
