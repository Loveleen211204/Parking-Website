<html>
<head>
  <title>Register As | Parking Management</title>
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
    <div class="card-ui mx-auto" style="max-width:460px;">
      <h5><i class="fa-solid fa-user-plus me-2"></i>Register As</h5>

      <div class="form-check mb-2">
        <input class="form-check-input" type="radio" name="role" id="Student">
        <label class="form-check-label" for="Student">
          👩‍🎓 Student
        </label>
      </div>

      <div class="form-check mb-3">
        <input class="form-check-input" type="radio" name="role" id="Teacher">
        <label class="form-check-label" for="Teacher">
          👨‍🏫 Teacher / Staff
        </label>
      </div>

      <button class="btn btn-brand w-100" onclick="goNext()">Continue</button>
    </div>
  </div>
<script>
  function goNext(){
  const s = document.getElementById('Student').checked;
  const t = document.getElementById('Teacher').checked;

  if(s) window.location.href = "register_student.php";
  else if(t) window.location.href = "register_teacher.php";
  else alert("Please select Student or Teacher");
}
</script>
</body>
</html>
