<?php
 ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(0);

$host = 'localhost';
$db   = 'arclothing_db';
$user = 'root';
$pass = '';


try {
    // Create PDO connection
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    
    // Set error mode to exception for debugging
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Optional: confirm connection (remove later)
    // echo "Connexion OK";
} catch(PDOException $e) {
    // If connection fails, show detailed error
    die("Database connection failed: " . $e->getMessage());
}
?>
