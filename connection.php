<?php
$host = 'localhost';  // Usually 'localhost'
$dbname = 'event_promotion_site';     // Your database name
$user = 'root';       // Your database username
$pass = '';           // Your database password, default is empty in XAMPP

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("ERROR: Could not connect. " . $e->getMessage());
}

$mysqli = new mysqli('localhost', 'root', '', 'event_promotion_site');
if ($mysqli->connect_error) {
    die('Connection failed: ' . $mysqli->connect_error);
}
return $mysqli;  // Ensure $mysqli is returned to be used in other scripts
?>
