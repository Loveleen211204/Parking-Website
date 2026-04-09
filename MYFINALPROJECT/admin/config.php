<?php

// Database Configuration - Update these with your XAMPP settings
 define('DB_HOST', 'localhost');
 define('DB_USER', 'root');
 define('DB_PASS', '');
 define('DB_NAME', 'parking_db');

// Create connection
 $conn = mysqli_connect("localhost","root","","parking_db");
 mysqli_query($conn, "SET time_zone = '+05:30'");


// Check connection
 if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
 }

// Start session
 session_start();

// Check if admin is logged in
 function isLoggedIn() {
     return isset($_SESSION['admin_id']);
 }

// Redirect if not logged in
 function requireLogin() {
     if (!isLoggedIn()) {
         header("Location: login.php");
         exit();
     }
 }

// Get current admin info
 function getCurrentAdmin($conn) {
     $id = $_SESSION['admin_id'];
     $result = mysqli_query($conn, "SELECT id, name, email FROM admins WHERE id = $id");
     return mysqli_fetch_assoc($result);
 }

// Format duration between two times
 function formatDuration($entryTime, $exitTime) {
     if (!$exitTime) return '-';
     $diff = strtotime($exitTime) - strtotime($entryTime);
     $hours = floor($diff / 3600);
     $mins = floor(($diff % 3600) / 60);
     if ($hours > 0) return "{$hours}h {$mins}m";
     return "{$mins}m";
 }
?>
