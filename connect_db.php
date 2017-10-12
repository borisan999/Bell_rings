<?php

/*
Versión:1.0
conexión a mysql
Creado por: Boris Urrea
*/
$host = "localhost"; // Host name 
$username = "bellrings"; // Mysql username 
$password = "900007657"; 
$db_name = "ring_bells"; // Database name 
$server_name = "localhost";


// Create connection
$mysqli = new MySQLi($server_name, $username, $password, $db_name, 3306);
mysqli_set_charset($mysqli, 'utf8');

?>
