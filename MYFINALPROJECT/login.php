<?php
session_start();
include "db.php";

if(isset($_POST['login'])){
    $email = $_POST['email'];
    $password = $_POST['password'];
    $q = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
   if(mysqli_num_rows($q) == 1){
      $row = mysqli_fetch_assoc($q);
      if(password_verify($password, $row['password']))
      {
           $_SESSION['user_id'] = $row['id'];
           $_SESSION['user'] = $row['name'];
           $_SESSION['role'] = $row['role'];
           if($row['role'] == "Student")
            {
               header("Location: studentafterlogin.php");
            }   
           elseif($row['role'] == "Teacher")
            {
                  header("Location: teacherafterlogin.php");
            }
           exit();
      }else {
               echo "<script>alert('Wrong Password');</script>";
            }

   } else {
        echo "<script>alert('User Not Registered');</script>";
   }
}
?>

<html>
<head>
  <title>Login | Parking Management</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="topbar">
     <div class="d-flex align-items-center ps-2">
        <a href="main.php" class="btn btn-light btn-sm me-3">
           <i class="fa-solid fa-house"></i> Home
        </a>
        <div class="title">🚦 Parking Management</div>
      </div>
  </div>

 <div class="container mt-5">
   <div class="card-ui mx-auto" style="max-width:420px;">
     <h5><i class="fa-solid fa-right-to-bracket me-2"></i>Login</h5>
     <form method="POST" action="login.php" >
       <label class="form-label">Email</label>
       <input type="email" class="form-control mb-3" name="email" placeholder="Enter email">
       <label class="form-label">Password</label>
       <input type="password" class="form-control mb-3" name="password" placeholder="Enter password">
       <button class="btn btn-brand w-100"name="login">Login</button>
       <p class="text-center mt-3 mb-0">
           New user? <a href="role.php">Register Here</a>
       </p>
   </div>
 </div>
</body>
</html>