<?php
include "db.php";
if(isset($_POST['register']))
{
    $role = "Student";
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $roll = $_POST['roll'];
    $course = $_POST['course'];
    $vehicle = $_POST['vehicle'];
    $vehicle_type = $_POST['vehicle_type'];
    $sql = "INSERT INTO users (role, name, email, password, rollno, course, vehicle,vehicle_type)
            VALUES ('$role','$name','$email','$password','$roll','$course','$vehicle','$vehicle_type')";
    if(!mysqli_query($conn, $sql)){
        die(mysqli_error($conn));
    }
    echo "<script>alert('Student Registered Successfully!'); window.location='login.php';</script>";
}
?>

<html>
<head>
  <title>Student Registration</title>
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
  <!-- ================= STUDENT FORM ================= -->
    <div id="studentForm">
     <h5><i class="fa-solid fa-chalkboard-user me-2"></i>👩‍🎓 Student Registration</h5>

      <form id="registerForm" onsubmit="return validateStudentForm()" method="POST" action="register_student.php">
        <input type="hidden" name="role" value="Student">

        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label"> Name</label>
            <input class="form-control" name="name" id="name" required>
          </div>

          <div class="col-md-6">
            <label class="form-label">Email</label>
            <input class="form-control" type="email" id="email" name="email" required>
          </div>

          <div class="col-md-6">
            <label class="form-label">Roll No</label>
            <input class="form-control" id="roll" name="roll" required>
          </div>

          <div class="col-md-6">
            <label class="form-label">Course</label>
            <input class="form-control" id="course" name="course" required>
          </div>

          <div class="col-md-6">
            <label class="form-label">Password</label>
            <input class="form-control" type="password" id="password" name="password" required>
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
          Create Student Account
        </button>
      </form>
    </div>
  </div>
 </div>
<script>
function validateStudentForm() {
  let name = document.getElementById("name").value.trim();
  let email = document.getElementById("email").value.trim();
  let roll = document.getElementById("roll").value.trim();
  let course = document.getElementById("course").value.trim();
  let password = document.getElementById("password").value.trim();
  let vehicle = document.getElementById("vehicle").value.trim();
  let vehicle_type = document.getElementById("vehicle_type").value.trim();

  if (name === "" || email === "" || roll === "" || course === "" || password === "" || vehicle === ""|| vehicle_type === "")
  {
    alert("⚠️ Please fill all the credentials before registering!");
    return false;
  }
  return true;
}
</script>
</body>
</html>
