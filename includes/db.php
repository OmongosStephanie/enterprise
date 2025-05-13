<?php
$host = 'localhost';        // or your database host
$db   = 'online_shop'; // replace with your database name
$user = 'root';   // replace with your MySQL username
$pass = '';   // replace with your MySQL password
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Show exceptions on error
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Fetch associative arrays
    PDO::ATTR_EMULATE_PREPARES   => false,                  // Use native prepared statements
];

try {
    $conn = new mysqli($host, $user, $pass, $db); // If you're using MySQLi (which your main script does)
} catch (Exception $e) {
    die('Database connection failed: ' . $e->getMessage());
}
?>