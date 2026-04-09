<?php
require_once '../config.php';
requireLogin();
header('Content-Type: application/json');
$count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS c FROM parking_history WHERE exit_time IS NULL"))['c'];
echo json_encode(['count' => (int)$count]);
?>
