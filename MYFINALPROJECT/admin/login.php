<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email    = mysqli_real_escape_string($conn, trim($_POST['email']));
    $password = $_POST['password'];
    $result = mysqli_query($conn, "SELECT * FROM admins WHERE email = '$email' LIMIT 1");
    $admin  = mysqli_fetch_assoc($result);
     if ($admin && $admin['password'] === $password) {
        $_SESSION['admin_id']   = $admin['id'];  
        $_SESSION['admin_name'] = $admin['name'];
        header("Location: dashboard.php");
        exit();
     }
    $error = "Invalid email or password.";
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Login</title>
 <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
 <link rel="stylesheet" href="../style.css">
</head>
<body>
  <div class="topbar">
    <div class="d-flex align-items-center ps-2">
      <div class= "title">  Admin Page of Parking Management </div>
    </div>
  </div>
  <div class="container mt-5">
    <div class="card-ui mx-auto" style="max-width:420px;">
      <h5><i class="fa-solid fa-right-to-bracket me-2"></i> Admin Login</h5>
      <form method="POST">
        <label class="form-label"> Email</label>
        <input type="email" name="email"   class="form-control mb-3"  placeholder="Enter Email" required>
        <label class="form-label"> Password</label>
        <input type="password" name="password" class="form-control mb-3"  placeholder="Enter Password" required>
        <button type="submit" name="login"  class="btn btn-brand w-100">Login</button>
      </form>
    </div>
  </div>
</body>
</html>