<?php

$host = "localhost";
$name = "framework";
$user = "framework";
$pass = "W-9lZIgjE]p_tKM5";

try {
	$pdo = new PDO("mysql:host=$host;dbname=$name;charset=utf8mb4", "$user", "$pass",     [
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
		PDO::ATTR_TIMEOUT => 5
	]);
} catch (PDOException $e) {
	die("Could not connect to the database: " . $e->getMessage());
}

//$stmt = $pdo->prepare('SELECT * FROM `product`');
//$stmt->execute();
//$entries = $stmt->fetchAll();
//var_dump($entries);