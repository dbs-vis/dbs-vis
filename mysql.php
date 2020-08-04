<?php

$dsn = 'mysql:dbname=dbs_vis_db;host=localhost;charset=utf8';
$user = 'root';
$password = ''; 

try {
	$conn = new PDO($dsn, $user, $password);
} catch (PDOException $e) {
	echo 'Connection failed: ' . $e->getMessage();
}

?>

