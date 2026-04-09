<?php
include "db.php";
if(isset($_POST['register']))
{
   $role = "Teacher";
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $empid = $_POST['empid'];
    $department = $_POST['department'];
    $vehicle = $_POST['vehicle'];
    $vehicle_type = $_POST['vehicle_type'];
    $sql = "INSERT INTO users (role, name, email, password, empid, department, vehicle,vehicle_type)
            VALUES ('Teacher','$name','$email','$password','$empid','$department','$vehicle','$vehicle_type')";

    if(!mysqli_query($conn, $sql)){
        die("DB Error: " . mysqli_error($conn));
    }
    echo "<script>alert('Teacher Registered Successfully'); window.location='login.php';</script>";
}
?>

<html>
<head>
  <title> Teacher Registration</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="topbar">
     <div class="container d-flex justify-content-between align-items-center">
       <div class="title">🚦 Parking Management</div>
     </div>
  </div>

 <div class="container mt-5">
  <div class="card-ui mx-auto" style="max-width:520px;">
    <!-- ================= TEACHER FORM ================= -->
    <div id="teacherForm">
      <h5><i class="fa-solid fa-chalkboard-user me-2"></i>Teacher / Staff Registration</h5>

      <form id="teacherForm2" onsubmit="return validateTeacherForm()" method="POST" action="register_teacher.php">
        <input type="hidden" name="role" value="Teacher">

        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label">Full Name</label>
            <input class="form-control" id="name" name="name" required>
          </div>

          <div class="col-md-6">
            <label class="form-label">Official Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
          </div>

          <div class="col-md-6">
            <label class="form-label">Department</label>
            <input class="form-control" id="department" name="department" required>
          </div>

          <div class="col-md-6">
            <label class="form-label">Employee ID</label>
            <input class="form-control" id="empid" name="empid" required>
          </div>

          <div class="col-md-6">
            <label class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
          </div>

          <div class="col-md-6">
            <label class="form-label">Vehicle No</label>
            <input class="form-control" id="vehicle" name="vehicle" required>
          </div>

          <div class="col-md-6">
            <label class="form-label">Vehicle Type</label>
            <select class="form-control" name="vehicle_type" id="vehicle_type" required>
              <option value="">Select Vehicle Type</option>
              <option value="Two Wheeler">Two Wheeler</option>
              <option value="Four Wheeler">Four Wheeler</option>
            </select>
          </div>
        </div>
        <button type="submit" class="btn btn-brand w-100 mt-3" name="register">
          Create Teacher Account
        </button>
      </form>
    </div>
  </div>
 </div>
<script>
function validateTeacherForm() {
  let name = document.getElementById("name").value.trim();
  let email = document.getElementById("email").value.trim();
  let department = document.getElementById("department").value.trim();
  let empid = document.getElementById("empid").value.trim();
  let password = document.getElementById("password").value.trim();
  let vehicle = document.getElementById("vehicle").value.trim();
  let vehicle_type = document.getElementById("vehicle_type").value;

  if (name === "" || email === "" || department === "" || empid === "" || password === "" || vehicle === "" || vehicle_type === "") 
  {
    alert("⚠️ Please fill all the credentials before registering!");
    return false;
  }
  return true;
}
</script>
</body>
</html>

