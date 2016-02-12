<?php

$servername = "localhost";
$username = "root";
$password = "";

echo phpinfo();
/*
// Create connection
$conn = mysql_connect($servername, $username, $password);
if (!$conn) {
    die('Could not connect: ' . mysql_error());
}
mysql_select_db('test', $conn);

//$id = "\xbf\x27 OR 1=1 /*";
$name='martin';
$name="' OR 1=1 -- ";
$name1= mysql_real_escape_string($name);
echo $query = sprintf("SELECT * FROM users where name='%s'", $name1);
//$query = "SELECT * FROM users where name='martin'";
$rs =  mysql_query($query, $conn);
while ($row = mysql_fetch_assoc($rs)) {
    print_r($row);
}
*/
?>