<?php
include "db.php";
if(!isset($_SESSION['user'])){
    header("Location: login.php");
}
?>

<h2>Welcome <?php echo $_SESSION['user']; ?></h2>
<h4>Role: <?php echo $_SESSION['role']; ?></h4>

<a href="logout.php">Logout</a>
