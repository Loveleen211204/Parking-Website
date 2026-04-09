<?php
include "db.php";
$result = mysqli_query($conn, "SELECT * FROM users WHERE role = 'Student'");
if(!$result)
{
    die("Query failed: " . mysqli_error($conn));
}
?>

<html>
<head>
  <title>All Student Users</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
  <h3>Registered Students</h3>
  <table class="table table-bordered table-striped mt-3">
    <thead>
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Course</th>
        <th>Roll No</th>
        <th>Vehicle No</th>
        <th>Vehicle Type</th>
        <th>Date</th>
      </tr>
    </thead>
    <tbody>
      <?php if(mysqli_num_rows($result) > 0){ ?>
        <?php while($row = mysqli_fetch_assoc($result)){ ?>
          <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['name'] ?></td>
            <td><?= $row['email'] ?></td>
            <td><?= $row['course'] ?></td>
            <td><?= $row['rollno'] ?></td>
            <td><?= $row['vehicle'] ?></td>
            <td><?=$row['vehicle_type']?></td>
            <td><?= $row['created_at'] ?></td> 
          </tr>
       <?php } ?>
       <?php } else { ?>
        <tr>
          <td colspan="8" class="text-center text-danger">No users found</td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
</div>
</body>
</html>
