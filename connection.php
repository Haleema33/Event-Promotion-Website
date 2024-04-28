<?php


$host = 'localhost';  // Usually 'localhost'
$dbname = 'event_promotion_site';     // Your database name
$user = 'root';       // Your database username
$pass = '';           // Your database password, default is empty in XAMPP

// Create mysqli connection
$mysqli = new mysqli($host, $user, $pass, $dbname);

// Check mysqli connection
if ($mysqli->connect_error) {
    die("mysqli Connection failed: " . $mysqli->connect_error);
}

// Create PDO connection
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("PDO ERROR: Could not connect. " . $e->getMessage());
}

// Since $conn and $mysqli are the same, we will use only $mysqli
// If needed, you can assign $conn = $mysqli to use the $conn variable in other parts of your application
$conn = $mysqli;

// Return array of connections if needed; otherwise, just use as global variables in included files
return ['pdo' => $pdo, 'mysqli' => $mysqli];


?>
