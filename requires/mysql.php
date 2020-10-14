<?php
//Variables for connection establishment. charset for UTF-8, because of umlauts
$dsn = 'mysql:dbname=dbs_vis_db;host=localhost;charset=utf8';
$user = 'root';
$password = ''; 

//Try to establish connection to DB
try {
	$conn = new PDO($dsn, $user, $password);
}

//Exception handling, if connection failed
catch (PDOException $e) {
	echo 'Connection failed: ' . $e->getMessage() . "<br/>";
	die();
}
?>